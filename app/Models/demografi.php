<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class demografi extends Model
{
    use HasFactory;


    public static function get_usia(){
        return DB::table('Prospect')
                    ->join('Usia','Usia.UsiaID','=','Prospect.UsiaID')
                    ->join('PT','PT.KodePT','=','Prospect.KodePT')
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                    ->select('Usia.RangeUsia as name',DB::raw('count(*) as y'))
                    ->groupBy('Usia.RangeUsia')
                    ->get();
    }

    public static function get_gender(){
        return DB::table('Prospect')
                    ->join('Gender','Gender.GenderID','=','Prospect.GenderID')
                    ->join('PT','PT.KodePT','=','Prospect.KodePT')
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                    ->select('Gender.JenisKelamin as name',DB::raw('count(*) as y'))
                    ->groupBy('Gender.JenisKelamin')
                    ->get();
    }

    public static function get_penghasilan(){
        return DB::table('Prospect')
                    ->join('Penghasilan','Penghasilan.PenghasilanID','=','Prospect.PenghasilanID')
                    ->join('PT','PT.KodePT','=','Prospect.KodePT')
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                    ->select('Penghasilan.RangePenghasilan as name',DB::raw('count(*) as y'))
                    ->groupBy('Penghasilan.RangePenghasilan')
                    ->orderBy('Penghasilan.PenghasilanID')
                    ->get();
    }

    public static function get_tempat_tinggal(){
        return DB::table('Prospect')
                    ->join('Kota','Kota.id','=','Prospect.TempatTinggalID')
                    ->join('PT','PT.KodePT','=','Prospect.KodePT')
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                    ->select('Kota.city',DB::raw('count(Prospect.ProspectID) as prospect'))
                    ->groupBy('Kota.id')
                    ->orderBy('Kota.city','asc')
                    ->get();
    }

    public static function get_prospectTinggal(){
        return DB::table('Prospect')
                    ->join('PT','PT.KodePT','Prospect.KodePT')
                    ->join('Kota','Prospect.TempatTinggalID','=','Kota.id')
                    ->select(DB::raw('count(Prospect.ProspectID) as prospect'))
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                    ->get();
    }

    public static function get_tempat_kerja(){
        return DB::table('Prospect')
                    ->join('Kota','Kota.id','=','Prospect.TempatKerjaID')
                    ->join('PT','PT.KodePT','=','Prospect.KodePT')
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                    ->select('Kota.city',DB::raw('count(Prospect.ProspectID) as prospect'))
                    ->groupBy('Kota.id')
                    ->orderBy('Kota.city','asc')
                    ->get();
    }


    public static function get_prospectKerja(){
        return DB::table('Prospect')
                    ->join('PT','PT.KodePT','Prospect.KodePT')
                    ->join('Kota','Prospect.TempatKerjaID','=','Kota.id')
                    ->select(DB::raw('count(Prospect.ProspectID) as prospect'))
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                    ->get();
    }

    public static function get_pekerjaan(){
        return DB::table('Prospect')
                    ->join('Pekerjaan','Pekerjaan.PekerjaanID','=','Prospect.PekerjaanID')
                    ->join('PT','PT.KodePT','=','Prospect.KodePT')
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                    ->select('Pekerjaan.TipePekerjaan',DB::raw('count(Prospect.ProspectID) as prospect'))
                    ->groupBy('Pekerjaan.PekerjaanID')
                    ->get();
    }


    public static function get_prospectPekerjaan(){
        return DB::table('Prospect')
                    ->join('PT','PT.KodePT','Prospect.KodePT')
                    ->join('Pekerjaan','Prospect.PekerjaanID','=','Pekerjaan.PekerjaanID')
                    ->select(DB::raw('count(Prospect.ProspectID) as prospect'))
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                    ->get();
    }

    public static function getkota($id){
        return DB::table('Kota')
                    ->select('*')
                    ->where('province_id','=',$id)
                    ->get();
    }

    public static function getIDPRov($id){
        return DB::table('Kota')
                    ->join('Provinsi','Provinsi.id','=','Kota.province_id')
                    ->select('Kota.province_id','Provinsi.province')
                    ->where('Kota.id','=',$id)
                    ->get();

    }

    public static function get_city($id){
        return DB::table('Kota')
                    ->select('*')
                    ->where('id','=',$id)
                    ->get();
    }


}
