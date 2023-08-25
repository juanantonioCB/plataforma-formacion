<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Enroll;
use App\Models\Curso;
use App\Models\User;


if (! function_exists('has_rol')) {
    function has_rol($role)
    {
        $response = Http::asForm()->post(config('keycloak-web.base_url').'/realms/'.config('keycloak-web.realm').'/protocol/openid-connect/token', [
            'client_id' => config('app.keycloak_client_id_api'),
            'client_secret' => config('app.keycloak_client_secret_api'),
            'grant_type' => 'client_credentials',
        ]);

        if (!$response->successful()) {
            return false;
        } else {
            $token = json_decode($response)->access_token;
            $email = Auth()->user()->email;
            $response2 = Http::withToken($token)->get(config('keycloak-web.base_url').'/admin/realms/'.config('keycloak-web.realm').'/users?email='.$email);
                if (!$response2->successful()) {
                    return false;
                } else {
                    $id_cliente = json_decode($response2)[0]->id;
                    $response3 = Http::withToken($token)->get(config('keycloak-web.base_url').'/admin/realms/'.config('keycloak-web.realm').'/users/'.$id_cliente.'/role-mappings');
                    if (!$response3->successful()) {
                        return false;
                    } else {
                        $esRol = false;
                        foreach(json_decode($response3)->realmMappings as $rol) {
                            if ($rol->name == $role) { 
                                $esRol = true;
                            } 
                        }
                        
                        if ($esRol) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
        }
    }
}


if (! function_exists('new_user_moodle')) {
    function new_user_moodle($email)
    {
        try {
            $response = Http::asForm()->post(config('app.moodle_base_url'), [
                'wstoken' => config('app.moodle_token'),
                'wsfunction' => 'core_user_create_users',
                'moodlewsrestformat' => 'json',
                'users[0][username]' => $email,
                'users[0][firstname]' => $email,
                'users[0][lastname]' => $email,
                'users[0][email]' => $email,
                'users[0][auth]' => 'saml2'
            ]);
            if (!$response->successful()) {
                return json_encode(['ok' => false, 'message' => 'Imposible conexión moodle', 'id_moodle' => '']);
            } else {
                if (isset(json_decode($response->body())->exception)) {
                    return json_encode(['ok' => false, 'message' => 'Imposible conexión moodle', 'id_moodle' => '']);
                } else {
                    if (isset(json_decode($response->body())->debuginfo)) {
                        if (str_contains(json_decode($response->body())->debuginfo,'Username already exists')) {
                            return json_encode(['ok' => false, 'message' => 'Email usuario ya existente', 'id_moodle' => '']);
                        } else {
                            return json_encode(['ok' => false, 'message' => 'Error desconocido', 'id_moodle' => '']);
                        }
                    } else {
                        return json_encode(['ok' => true, 'message' => '', 'id_moodle' => json_decode($response)[0]->id]);
                    }
                }
            }
        } catch (Exception $e) {
            return json_encode(['ok' => false, 'message' => 'Imposible conexión moodle', 'id_moodle' => '']);
        }
    }
}

if (! function_exists('new_user_wp_badges')) {
    function new_user_wp_badges($email, $first_name, $last_name)
    {
        try {
            $response = Http::withBasicAuth(config('app.wp_basic_auth_username'),config('app.wp_basic_auth_password'))->asForm()->post(config('app.wp_base_url').'/index.php/wp-json/wp/v2/users', [
                'username' => $email,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => generateRandomString(),
            ]);
            if (!$response->successful()) {
                return json_encode(['ok' => false, 'message' => 'Imposible conexión wp', 'id_wp' => '']);
            } else {
                return json_encode(['ok' => true, 'message' => '', 'id_wp' => json_decode($response)->id]);
            }
        } catch (Exception $e) {
            return json_encode(['ok' => false, 'message' => 'Imposible conexión wp', 'id_wp' => '']);
        }
    }
}

if (! function_exists('sincronizacionMoodle')) {
    function sincronizacionMoodle($id_moodle, $id_user)
    {
        $response = Http::asForm()->post(config('app.moodle_base_url'), [
            'wstoken' => config('app.moodle_token'),
            'wsfunction' => 'core_enrol_get_users_courses',
            'moodlewsrestformat' => 'json',
            'userid' => $id_moodle
        ]);
        if (!$response->successful()) {
            return json_encode(['ok' => false, 'message' => 'Imposible conexión moodle', 'id_moodle' => '']);
        } else {
            foreach (json_decode($response) as $curso) {
                if ( $curso->progress == 100 /* $curso->completed == true */) {
                    $enrolls = Enroll::where('user_id', $id_user)->where('discontinued',false)->get();
                    foreach ($enrolls as $enroll) {
                        if (intval($enroll->curso->course_id) == $curso->id) {
                            // Asignar medalla si procede
                            $asignar_badge = json_decode(asignar_badge($enroll->curso->id, $id_user));
                            if ($asignar_badge->ok) {
                            }
                            $enro = Enroll::find($enroll->id);
                            $enro->finished = true;
                            $enro->save();
                        }
                    }
                }
                  
            }
        }
    }
}

if (! function_exists('sincronizacionEnrolls')) {
    function sincronizacionEnrolls($id_user)
    {
        $enrolls = Enroll::where('user_id', $id_user)->get();
        foreach ($enrolls as $enroll) {
            if ($enroll->edicion->is_open == false) {
                $enro = Enroll::find($enroll->id);
                $enro->discontinued = true;
                $enro->save();
            } else {
                $enro = Enroll::find($enroll->id);
                $enro->discontinued = false;
                $enro->save();
            }
        }
    }
}


if (! function_exists('bajaKC')) {
    function bajaKC($uuid)
    {
        $response = Http::asForm()->post(config('keycloak-web.base_url').'/realms/'.config('keycloak-web.realm').'/protocol/openid-connect/token', [
            'client_id' => config('app.keycloak_client_id_api'),
            'client_secret' => config('app.keycloak_client_secret_api'),
            'grant_type' => 'client_credentials',
        ]);

        if (!$response->successful()) {
            return json_encode(['ok' => false]);
        } else {
            $token = json_decode($response)->access_token;
            $response2 = Http::withToken($token)->delete(config('keycloak-web.base_url').'/admin/realms/'.config('keycloak-web.realm').'/users/'.$uuid);
            if (!$response2->successful()) {
                return json_encode(['ok' => false]);
            } else {
                return json_encode(['ok' => true]);
            }
        }
    }
}


if (! function_exists('badgeToUser')) {
    function badgeToUser($user_id, $achievement_id)
    {
        try {
            $response = Http::asForm()->post(config('app.wp_base_url').'/index.php/wp-json/badgeos-api/admin-award-achievement?apikey='.config('app.api_key_badgeos'), [
                'user_id' => $user_id,
                'achievement_id' => $achievement_id
            ]);
            if (!$response->successful()) {
                return json_encode(['ok' => false, 'message' => 'Imposible conexión wp']);
            } else {
                return json_encode(['ok' => true, 'message' => '']);
            }
        } catch (Exception $e) {
            return json_encode(['ok' => false, 'message' => 'Imposible conexión wp']);
        }
    }
}

if (! function_exists('obtenerEntryId')) {
    function obtenerEntryId($user_id, $achievement_id)
    {
        try {
            $response = Http::asForm()->post(config('app.wp_base_url').'/index.php/wp-json/badgeos-api/awarded-achievements?apikey='.config('app.api_key_badgeos'), [
                'achievement_id' => $achievement_id,
                'user_id' => $user_id
            ]);
            if (!$response->successful()) {
                return json_encode(['ok' => false, 'message' => 'Imposible conexión wp','entry_id' => '']);
            } else {
                return json_encode(['ok' => true, 'message' => '','entry_id' => json_decode($response)->data[0]->entry_id]);
            }
        } catch (Exception $e) {
            return json_encode(['ok' => false, 'message' => 'Imposible conexión wp','entry_id' => '']);
        }
    }
}

if (!function_exists('generateRandomString')) {
	function generateRandomString($length = 12) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	} 
}

if (! function_exists('update_user_wp_badges')) {
    function update_user_wp_badges($wp_id, $first_name, $last_name)
    {
        try {
            $response = Http::withBasicAuth(config('app.wp_basic_auth_username'),config('app.wp_basic_auth_password'))->asForm()->post(config('app.wp_base_url').'/index.php/wp-json/wp/v2/users/'.$wp_id, [
                'first_name' => $first_name,
                'last_name' => $last_name
            ]);
            if (!$response->successful()) {
                return json_encode(['ok' => false, 'message' => 'Imposible conexión wp']);
            } else {
                return json_encode(['ok' => true, 'message' => '']);
            }
        } catch (Exception $e) {
            return json_encode(['ok' => false, 'message' => 'Imposible conexión wp']);
        }
    }
}

if (! function_exists('asignar_badge')) {
    function asignar_badge($curso_id, $user_id)
    {
        try {
            $curso = Curso::find($curso_id);
            $subscriptor = User::find($user_id);

            // Comprobar que la edicion tiene medalla
            if ($curso->edicionAbierta->badge_id) {
                // Asignar medalla a usuario en wp
                $entry_id = '';
                $badgetoUser = json_decode(badgeToUser($subscriptor->wp_badges_id, $curso->edicionAbierta->badge_id));
                if ($badgetoUser->ok) {
                    // Obtener entry id
                    $obtenerEntryId = json_decode(obtenerEntryId($subscriptor->wp_badges_id, $curso->edicionAbierta->badge_id));
                    if ($obtenerEntryId->ok) {
                        $entry_id = $obtenerEntryId->entry_id;
                        // Actualizar enroll plataforma con evidence
                        $enroll = Enroll::where('user_id', $subscriptor->id)->where('edition_id',$curso->edicionAbierta->id)->first();
                        $enroll->url_evidence = config('app.wp_base_url').'/index.php/evidence-page/?bg='.$curso->edicionAbierta->badge_id.'&eid='.$entry_id.'&uid='.$subscriptor->wp_badges_id;
                        $enroll->save();
                        return json_encode(['ok' => true]);
                    } else {
                        return json_encode(['ok' => false]);
                    }
                } else {
                    return json_encode(['ok' => false]);
                }
            } else {
                return json_encode(['ok' => false]);
            }
        } catch (Exception $e) {
            return json_encode(['ok' => false]);
        }

    }
}
