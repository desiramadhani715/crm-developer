<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    // public static function PT(){
    //     $table = DB::table('PT')
    //             ->leftjoin('user', 'user.UsernameKP','=','PT.UsernameKP')->get();

    //     return $table;

    // }

    protected $table = 'User';
    protected $primaryKey = 'UserID';
    const CREATED_AT = 'AddDate';
    const UPDATED_AT = 'EditDate';
    protected $fillable = [
        'UsernameKP','PasswordKP','Email','LevelUserID','Active'
    ];


    public function getAuthPassword()
    {
        return $this->PasswordKP;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'PasswordKP', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
