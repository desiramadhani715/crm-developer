<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class notInterested extends Model
{
    public static function get_alasan(){
        return DB::table('NotInterested')
                            ->select('NotInterested.Alasan')
                            ->get();

    }

    public static function get_prospect(){
        return DB::table('Prospect')
                    ->join('PT','PT.KodePT','Prospect.KodePT')
                    ->join('NotInterested','Prospect.NotInterestedID','=','NotInterested.NotInterestedID')
                    ->select(DB::raw('count(Prospect.ProspectID) as prospect'),'NotInterested.Alasan')
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                    ->groupBy('NotInterested.Alasan')
                    ->orderBy('NotInterested.NotInterestedID','asc')
                    ->get();
    }
    public static function get_total_prospect(){
        return DB::table('Prospect')
                    ->join('PT','PT.KodePT','Prospect.KodePT')
                    ->join('NotInterested','Prospect.NotInterestedID','=','NotInterested.NotInterestedID')
                    ->select(DB::raw('count(Prospect.ProspectID) as prospect'))
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                    ->get();
    }
}
