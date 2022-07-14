<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class unit extends Model
{
    use HasFactory;
    protected $table = 'tipe_unit';
    protected $primaryKey = 'UnitID';
    protected $fillable = ['UnitName','ProjectCode'];
    const CREATED_AT = 'DateCreated';
    const UPDATED_AT = 'DateUpdated';

    public static function get_unit(){
        return DB::table('tipe_unit')
                    ->join('Project','Project.KodeProject','=','tipe_unit.ProjectCode')
                    ->join('PT','PT.KodePT','=','Project.KodePT')
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                    ->select('tipe_unit.UnitID','tipe_unit.UnitName','tipe_unit.ProjectCode','Project.NamaProject')
                    ->get();
    }
}