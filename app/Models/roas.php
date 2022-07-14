<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class roas extends Model
{
    use HasFactory;
    protected $table = 'Roas';
    protected $fillable = ['Google','Sosmed','Detik','Bulan','Tahun','KodeProject'];

    public static function total($bulan, $tahun, $ket, $KodeProject){
        $query = DB::table('Prospect')
                    ->join('PT','PT.KodePT','=','Prospect.KodePT');
                    if($ket == 'total'){
                        $query->select(DB::raw('count(Prospect.ProspectID) as total'));
                    }elseif($ket == 'closing'){
                        $query->select(DB::raw('count(Prospect.ProspectID) as total'))
                              ->where('Prospect.Status','=','Closing');
                    }
                    $query->whereRaw('month(Prospect.AddDate) = '.'"'.$bulan.'" && year(Prospect.AddDate) = '.'"'.$tahun.'"')
                        ->where('Prospect.KodeProject','=',$KodeProject)
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP);
        return $query->get();
    }
}