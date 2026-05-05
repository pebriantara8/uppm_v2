<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Issue_level_publikasi extends Model
{

    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'nama_level_publikasi',
        'nominal_level_publikasi',
    ];

    // protected $table = 'issue_luarans';
}
