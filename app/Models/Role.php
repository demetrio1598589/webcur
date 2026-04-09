<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_rol';
    public $timestamps = false;
    protected $fillable = ['nombre', 'descripcion'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'usuario_roles', 'id_rol', 'id_usuario');
    }
}
