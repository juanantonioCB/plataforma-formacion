<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Library\AWS\SignWithCloudFront;

class Curso extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];
    protected $table = 'coursers';
    
    protected $keyType = 'string';

    public function getImagenAttribute() {
        if ($this->image) {
            $result = SignWithCloudFront::sign($this->image, 'course', 5);
            if ($result->Success == true) {
                return $result->Link;
             } else {
                return '';
            }
        } else {
            return '';
        }
    }

    public function cursosEdicionesAbiertas()
    {
        return $this->hasMany(Edicion::class, 'course_id','id')->where('is_open',true)->where('visible',true)->orderBy('init_date', 'desc');
    }

    public function cursosTodos()
    {
        return $this->hasMany(Edicion::class, 'course_id','id')->where('visible',true)->orderBy('init_date', 'desc');
    }

    public function edicionAbierta()
    {
        return $this->hasOne(Edicion::class, 'course_id','id')->where('is_open',true)->orderBy('init_date', 'desc');
    }

    public function cursosEnrolls()
    {
        return $this->hasMany(Enroll::class, 'course_id','id')->where('discontinued', false)->where('finished',false);
    }

    public function cursosEnrollsFinished()
    {
        return $this->hasMany(Enroll::class, 'course_id','id')->where('finished',true);
    }

    /* public function edicionesCerradas()
    {
        return $this->hasMany(Edicion::class, 'course_id','id')->where('is_open',false)->orderBy('init_date', 'desc');
    } */

}
