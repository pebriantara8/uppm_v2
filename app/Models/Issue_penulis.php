<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Issue_penulis extends Model
{

    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'issue_id',
        'nama',
        'koresponden',
        'penulis_ke',
        'no_rekening',
        'issue_penulis_jabatan_id',
        'penulis_bank',
        'status',
    ];

    public function join_issue()
    {
        // return $this->belongsTo(Issue::class, 'user_id', 'id');
        // return $this->hasOne(Issue::class, 'id', 'issue_id');
    }

    protected $table = 'issue_penulis';
}
