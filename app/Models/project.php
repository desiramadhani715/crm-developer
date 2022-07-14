<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class project extends Model
{
    use HasFactory;
    protected $table = 'Project';
    protected $fillable = ['KodeProject','NamaProject','KodePT'];
    protected $primaryKey = 'KodeProject';
    public $timestamps = false;

    public static function get_project($UsernameKP){
        return DB::table('Project')
                    ->join('PT','PT.KodePT','=','Project.KodePT')
                    ->select('Project.NamaProject','Project.KodeProject','PT.KodePT')
                    ->where('PT.UsernameKP','=',$UsernameKP)
                    ->get();

    }
}
