<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class userPT extends Model
{
    protected $table ='PT';
    protected $primaryKey = 'KodePT';
    public static function get_PT($UsernameKP){
        return DB::table('PT')
                    ->select('PT.NamaPT')
                    ->where('PT.UsernameKP','=',$UsernameKP)
                    ->get();

    }
    public static function get_logo($UsernameKP){
        return  DB::table('PT')
                    ->select('Logo')
                    ->where('PT.UsernameKP','=',$UsernameKP)
                    ->get();

    }
    public static function get_KodePT(){
        return DB::table('PT')
                    ->select('PT.KodePT','PT.UsernameKP')
                    ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->get();
    }
}
