<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Issue extends Model
{

    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'user_id',
        'bentuk_luaran',
        'judul',
        'jenis_buku',
        'isbn_buku',
        'jenis_publikasi',
        'level_publikasi',
        'link_publikasi',
        'jenis_hak_cipta',
        'no_hak_cipta',
        'penulis_utama',
        'biaya_apc',
        'bukti_pembayaran',
        'issue_status',
    ];

    // public function sapi()
    // {
    //     return $this->belongsTo(Issue_luaran::class, 'bentuk_luaran', 'id');
    // }

    public function ayam()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function kerbau()
    {
        return $this->belongsTo(Issue_luaran::class, 'bentuk_luaran', 'id');
    }

    public function join_penulis()
    {
        return $this->hasMany(Issue_penulis::class, 'issue_id', 'id');
    }
}
