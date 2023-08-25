<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/* use Illuminate\Support\Facades\Auth;  */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\Email;
use Illuminate\Support\Facades\Http;
use Config;
use App\Models\User;
use App\Models\Curso;
use App\Models\Contenido;
use App\Models\Enroll;
use App\Models\ForumUser;
use Auth;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Storage;
use App\Library\AWS\SignWithCloudFront;
use PhpParser\Node\Stmt\TryCatch;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
        $contenido = Contenido::first();
        $cursosDisponibles = Curso::has('cursosEdicionesAbiertas')->get();
        /* $cursosTodos = Curso::with('cursosEnrolls')->has('cursosTodos')->get(); */
        $cursosTodos = Curso::has('cursosTodos')->get();
        $subscriptor_id = null;
        //$cursosSubscriptor = [];
        //SignWithCloudFront::sign()
        $avatar = '';

        if (Auth()->user()) {
            if (!has_rol(config('app.keycloak_role_subscriptor_name'))) {
                return redirect()->route('keycloak.logout');
            }
            $subscriptor = User::where('email',Auth()->user()->email)->first();
            /* $subscriptor_id = $subscriptor->id; */
            //config(['app.picture' => $subscriptor->picture]);
            
            //echo 'texto';die;
            if ($subscriptor->picture) {
                $result = SignWithCloudFront::sign($subscriptor->picture, 'person', 5);
                if ($result->Success == true) {
                    $avatar = $result->Link;
                } else {
                    $avatar = '';
                }
            }
            
            //config(['app.picture_route' => $link]);
            config(['app.subscriptor_id' => $subscriptor->id]);
            
            sincronizacionEnrolls($subscriptor->id);
            sincronizacionMoodle($subscriptor->moodle_id, $subscriptor->id);

            $cursosTodos = Curso::with('cursosEnrolls')->has('cursosTodos')->get();
            //dd($cursosTodos);
        }
        
        /* return view('index', compact('contenido','cursosDisponibles','cursosTodos','subscriptor_id')); */
        return view('index', compact('contenido','cursosDisponibles','cursosTodos','avatar'));
    }

    public function curso($uuid)
    {
        $estado = 'no enroll';
        $terminado = 'no';
        $curso = Curso::find($uuid);
        if ($curso->cursosEdicionesAbiertas->count() !== 0) {
            $estado_curso = 'activo';
        } else {
            $estado_curso = 'no activo';
        }
        $avatar = '';
        $enroll2 = '';
        if (Auth()->user()) {
            if (!has_rol(config('app.keycloak_role_subscriptor_name'))) {
                return redirect()->route('keycloak.logout');
            }
            $subscriptor = User::where('email',Auth()->user()->email)->first();
            if ($subscriptor->picture) {
                $result = SignWithCloudFront::sign($subscriptor->picture, 'person', 5);
                if ($result->Success == true) {
                    $avatar = $result->Link;
                } else {
                    $avatar = '';
                }
            }
            //config(['app.picture' => $subscriptor->picture]);
            //config(['app.picture_route' => SignWithCloudFront::sign($subscriptor->picture, 'person', 5)]);
            config(['app.subscriptor_id' => $subscriptor->id]);

            if ($curso->cursosEdicionesAbiertas->count() !== 0) {
                $enroll = Enroll::where('user_id',$subscriptor->id)->where('edition_id',$curso->edicionAbierta->id)->where('finished', false)->first();
                if ($enroll) {
                    $estado = 'enroll';
                } else {
                    $estado = 'no enroll';
                }
                
            } else {
                $estado = 'no enroll';
            }

            $enroll2 = Enroll::where('user_id',$subscriptor->id)->where('course_id',$curso->id)->where('finished', true)->first();
            if ($enroll2) {
                $terminado = 'si';
            }
        }

        return view('curso', compact('curso','estado','estado_curso','terminado','avatar','enroll2'));
    }

    public function enviarRegistro(Request $request)
    {
        
        $altaKeycloak = false;
        $altaMoodle = false;
        $rules = [
            'email' => ['required', new Email],
            'name_registro' => 'required',
            'surname_registro' => 'required',
            'condiciones' => 'required'
        ];
        $messages = [
            'email.required' => 'El dato email es obligatorio.',
            'name_registro.required' => 'El dato nombre es obligatorio.',
            'surname_registro.required' => 'El dato apellidos es obligatorio.',
            'condiciones.required' => 'Debe aceptar las condiciones de uso.',
        ];
        //dd($request->all());
        $validator = Validator::make($request->all(), $rules,$messages);
        $request->flash();
        $errores='Errores:<br>';
        if ($validator->fails()) {
            $errores='Errores:<br>'; 
            foreach ($validator->errors()->all() as $message) {
                $errores=$errores.$message.'<br>';
            }
            return response()->json(['status' => 'error','errores' => $errores]);
        }

       
        $response = Http::asForm()->post(config('keycloak-web.base_url').'/realms/'.config('keycloak-web.realm').'/protocol/openid-connect/token', [
            'client_id' => config('app.keycloak_client_id_api'),
            'client_secret' => config('app.keycloak_client_secret_api'),
            'grant_type' => 'client_credentials',
        ]);

        if (!$response->successful()) {
            $errores=$errores.'Imnposible conectar al sistema de registro'.'<br>';
            return response()->json(['status' => 'error','errores' => $errores]);
        } else {
            $token = json_decode($response)->access_token;
            /******* pruebas  */
            /*$urlencode = urlencode('https://incibe-front.test');
            /**************** */
            $response2 = Http::withToken($token)->post(config('keycloak-web.base_url').'/admin/realms/'.config('keycloak-web.realm').'/users', [
                "emailVerified" => true,
                "enabled" => true,
                "username" => $request->email,
                "email" => $request->email
            ]);
            if (!$response2->successful()) {
                $errores=$errores.'Email ya existente'.'<br>';
                return response()->json(['status' => 'error','errores' => $errores]);
            } else {
                $response3 = Http::withToken($token)->get(config('keycloak-web.base_url').'/admin/realms/'.config('keycloak-web.realm').'/users?email='.$request->email);
                if (!$response3->successful()) {
                    $errores=$errores.'Error desconocido'.'<br>';
                    return response()->json(['status' => 'error','errores' => $errores]);
                } else {
                    $id_cliente = json_decode($response3)[0]->id;
                    $body = json_encode('["UPDATE_PASSWORD"]');
                    $body35 = '[{"id": "'.config('app.keycloak_role_subscriptor_id').'","name": "'.config('app.keycloak_role_subscriptor_name').'"}]';
                    $response35 = Http::withHeaders(['Content-Type' => 'application/json'])->withBody($body35,'json')->withToken($token)->post(config('keycloak-web.base_url').'/admin/realms/'.config('keycloak-web.realm').'/users/'.$id_cliente.'/role-mappings/realm'
                    );
                    if (!$response35->successful()) {
                        //$errores=$errores.'Error desconocido'.'<br>';
                        $errores=$errores.$body35.'<br>';
                        return response()->json(['status' => 'error','errores' => $errores]);
                    } else {
                        $response4 = Http::withHeaders(['Content-Type' => 'application/json'])->withBody('["UPDATE_PASSWORD"]','json')->withToken($token)->put(config('keycloak-web.base_url').'/admin/realms/'.config('keycloak-web.realm').'/users/'.$id_cliente.'/execute-actions-email?lifespan=43200&cliente_id='.config('app.keycloak_client_id_api')
                        );
                        if (!$response4->successful()) {
                            $errores=$errores.'Error envío email'.'<br>';
                            return response()->json(['status' => 'error','errores' => $errores]);
                        }
                        $altaKeycloak = true;
                    }
                }
            }
        }

        $alta_moodle = json_decode(new_user_moodle($request->email));
        if ($alta_moodle->ok) {
            $altaMoodle = true;
        } else {
            $deleteKC = json_decode(bajaKC( $id_cliente ));
            $errores=$errores.'Error alta en moodle'.'<br>';
            return response()->json(['status' => 'error','errores' => $errores]);
        }

        $alta_wp = json_decode(new_user_wp_badges($request->email, $request->name_registro, $request->surname_registro));
        if ($alta_wp->ok) {
        } else {
            $errores=$errores.'Error alta en wp badges'.'<br>';
            return response()->json(['status' => 'error','errores' => $errores]);
        }

        $user = new User;
        $user->id = $id_cliente;
        $user->email = $request->email;
        $user->name = $request->name_registro;
        $user->surname = $request->surname_registro;
        $user->moodle_id = $alta_moodle->id_moodle;
        $user->wp_badges_id = $alta_wp->id_wp;
        $user->save();

        $forumuser = new ForumUser;
        $uuid = Uuid::generate()->string;
        $forumuser->id = $uuid;
        $forumuser->user_id = $id_cliente;
        $forumuser->save();


        $mensajeOk = '<b>Bienvenido a Incibe Formación</b><br/>'.'Para continuar, por favor acceda al enlace que hemos enviado al correo electrónico que ha facilidado.';
        return response()->json(['status' => 'ok','errores' => $errores,'resp' => $mensajeOk]);

    }

    public function inscripcionCurso(Request $request)
    {
        $subscriptor = User::where('email',Auth()->user()->email)->first();
        $curso = Curso::find($request->idCurso);
        if ($curso->course_type == 'moodle') {
            $response = Http::asForm()->post(config('app.moodle_base_url'), [
                'wstoken' => config('app.moodle_token'),
                'wsfunction' => 'enrol_manual_enrol_users',
                'moodlewsrestformat' => 'json',
                'enrolments[0][userid]' => $subscriptor->moodle_id,
                'enrolments[0][courseid]' => $curso->course_id,
                'enrolments[0][roleid]' => 5,
            ]);
            if (!$response->successful()) {
                return response()->json(['status' => 'error','errores' => 'Error conexión moodle','resp' => '']);
            } 
    
            $uuid = Uuid::generate()->string;
            $enroll = new Enroll;
            $enroll->id = $uuid;
            $enroll->user_id = $subscriptor->id;
            $enroll->edition_id = $curso->edicionAbierta->id;
            $enroll->course_id = $curso->id;
            $enroll->save();
    
            $errores='';
            $mensajeOk = 'Inscripción en el curso correcta';
            return response()->json(['status' => 'ok','errores' => $errores,'resp' => $mensajeOk]);
        } else {
            return response()->json(['status' => 'error','errores' => 'Error curso no moodle','resp' => '']);
        }
    }

    public function modalPerfil(Request $request)
    {
        
        if (!Auth()->user()) {
            //return redirect()->route('index');
            return '';
        }
        $subscriptor = User::where('email',Auth()->user()->email)->first();
        if ($subscriptor->picture) {
            $result = SignWithCloudFront::sign($subscriptor->picture, 'person', 5);
            if ($result->Success == true) {
                $avatar = $result->Link;
            } else {
                $avatar = '';
            }
        } else {
            $avatar = '';
        }
        return view('layouts.modals.modalperfil', compact('subscriptor','avatar'))->render();
    }

    public function guardarPerfil(Request $request)
    {
        $rules = [
            'name' => 'required',
            'surname' => 'required'
        ];
        $messages = [
            'name.required' => 'El dato nombre es obligatorio.',
            'surname.required' => 'El dato apellidos es obligatorio.'
        ];
        //dd($request->all());
        $validator = Validator::make($request->all(), $rules,$messages);
        $request->flash();
        $errores='Errores:<br>';
        if ($validator->fails()) {
            $errores='Errores:<br>'; 
            foreach ($validator->errors()->all() as $message) {
                $errores=$errores.$message.'<br>';
            }
            return response()->json(['status' => 'error','errores' => $errores]);
        }

        if ($request->file('picture')) {
            $path = Storage::disk('s3')->put('images/persons', $request->file('picture'));
        }
                
        $subscriptor = User::where('email',Auth()->user()->email)->first();
        $forumuser = ForumUser::where('user_id',$subscriptor->id)->first();
        if ($subscriptor->picture) {
            try {
                Storage::disk('s3')->delete('images/persons/'.$subscriptor->picture);//code...
            } catch (\Throwable $th) {
            }
        }
        $subscriptor->name = $request->name;
        $subscriptor->surname = $request->surname;
        $subscriptor->nick = $request->nick;
        if ( $request->birth_date ) {
            $subscriptor->birth_date = $request->birth_date;
        }
        if ($request->file('picture')) {
            $subscriptor->picture = substr($path, strripos($path, '/')+1);
        }
        $subscriptor->save();
        $forumuser->name = $request->nick;
        if ($request->file('picture')) {
            $forumuser->avatar = substr($path, strripos($path, '/')+1);
        }
        $forumuser->save();

        if ($subscriptor->wp_badges_id) {
            $update_wp = json_decode(update_user_wp_badges($subscriptor->wp_badges_id, $request->name, $request->surname));
            if ($update_wp->ok) {
            } else {
                $errores = $errores.'Error alta en wp badges'.'<br>';
                return response()->json(['status' => 'error','errores' => $errores]);
            }
        }
 
        return response()->json(['status' => 'ok','errores' => '','resp' => 'Perfil actualizado']);

    }

    /* function test() {
        return view('index');
    }
    function test12() {
        return json_encode(Auth::user()->preferred_username);
    }
    function test13() {
        return json_encode(Auth::user());
    } */

    public function terminos()
    {
        return view('terminos');
    }

    public function politica()
    {
        return view('politica');
    }

    public function cerrarSesion(Request $request)
    {
        $request->session()->invalidate();
        return true;
    }

    public function obtenerMedalla(Request $request)
    {
        $curso = Curso::find($request->idCurso);
        $subscriptor = User::where('email',Auth()->user()->email)->first();
        //$edition_id = $curso->edicionAbierta->id;

        // API PostBadge
        $errores='Errores:<br>';
        $entry_id = '';
        $badgetoUser = json_decode(badgeToUser($subscriptor->wp_badges_id, $curso->edicionAbierta->badge_id));
        if ($badgetoUser->ok) {
            // API GetAwards (Obtener eid)
            $errores='Errores:<br>';
            $obtenerEntryId = json_decode(obtenerEntryId($subscriptor->wp_badges_id, $curso->edicionAbierta->badge_id));
            if ($obtenerEntryId->ok) {
                $entry_id = $obtenerEntryId->entry_id;
                // https://dev-wp-incibe.local.ticsmart.eu/index.php/evidence-page/?bg=325&eid=20&uid=15
                // Update EnRoll con Url evidencia
                $enroll = Enroll::where('user_id', $subscriptor->id)->where('edition_id',$curso->edicionAbierta->id)->first();
                $enroll->url_evidence = config('app.wp_base_url').'/index.php/evidence-page/?bg='.$curso->edicionAbierta->badge_id.'&eid='.$entry_id.'&uid='.$subscriptor->wp_badges_id;
                $enroll->save();
                return response()->json(['status' => 'ok','errores' => '','resp' => 'Proceso completado']);
            } else {
                $errores = $errores.'Error alta en wp badges'.'<br>';
                return response()->json(['status' => 'error','errores' => $errores]);
            }
            //return response()->json(['status' => 'ok','errores' => '','resp' => 'Badge to user ok']);
        } else {
            $errores = $errores.'Error alta en wp badges'.'<br>';
            return response()->json(['status' => 'error','errores' => $errores]);
        }

    }

    public function salirOut(Request $request)
    {
        
        if (!Auth()->user()) {
            return redirect()->route('index');
        } else {
            return redirect()->route('keycloak.logout');
        }

    }

    public function irAlCurso(Request $request)
    {
        $enlace = $request->enlace;
        if (!Auth()->user()) {
            return response()->json(['status' => 'error','enlace' => '']);
        } else {
            return response()->json(['status' => 'ok','enlace' => $enlace.'&saml=on']);
        }
    }

    public function irAlForo(Request $request)
    {
        $enlace = $request->enlace;
        if (!Auth()->user()) {
            return response()->json(['status' => 'error','enlace' => '']);
        } else {
            return response()->json(['status' => 'ok','enlace' => $enlace]);
        }
    }
    

}
