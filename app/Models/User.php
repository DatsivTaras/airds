<?php

namespace App\Models;

use App\Classes\Enum\OrderStatus;

use App\Classes\Enum\UserStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'password',
        'phone_nomber',
        'surname',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getStatus()
    {
        $statuses = self::statusList();

        return array_key_exists($this->status, $statuses) ? $statuses[$this->status] : '' ;
    }

    public function statusList()
    {
        return [
            UserStatus::NEW => 'Новий',
            UserStatus::ACTIVE => 'Активний',
            UserStatus::DELETED => 'Видалений',

        ];
    }
}
