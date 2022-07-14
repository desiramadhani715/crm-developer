<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class projectagent extends Model
{
    protected $table = 'ProjectAgent';
    protected $fillable = ['KodeProject','UrutProjectAgent','KodeAgent'];
    protected $primaryKey = 'ProjectAgentID';
    public $timestamps = false;

    public static function get_project_agent($UsernameKP){
        $agent = DB::table('ProjectAgent')
                        ->join('Project','Project.KodeProject','=','ProjectAgent.KodeProject')
                        ->join('PT','PT.KodePT','=','Project.KodePT')
                        ->select('ProjectAgent.KodeAgent')
                        ->where('PT.UsernameKP','=',$UsernameKP)
                        ->get();
        return $agent;
    }

    public static function get_KodeProject($KodeAgent){
        return DB::table('ProjectAgent')
                    ->select('ProjectAgent.KodeProject')
                    ->where('ProjectAgent.KodeAgent','=',$KodeAgent)
                    ->get();
    }

}
