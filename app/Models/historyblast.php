<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class historyblast extends Model
{
    use HasFactory;

    protected $table = 'HistoryBlast';
    protected $fillable = ['KodeProject','ProspectID','KodeAgent','KodeSales','BlastAgentID','BlastSalesID','Email','AcceptStatus','LevelInputID'];
    protected $primaryKey = 'BlastID';
    public $timestamps = false;

    public static function last_blastID($NamaKode,$Kode){
        return DB::table('HistoryBlast')
                    ->select(DB::raw('MAX(BlastID) as BlastID'))
                    ->where($NamaKode,'=',$Kode)
                    ->get();
    }

    public static function last_blast($BlastID){
        return DB::table('HistoryBlast')
                    ->select('HistoryBlast.*')
                    ->where('HistoryBlast.BlastID','=',$BlastID)
                    ->get();
    }

    public static function agent($KodeProject){
        return DB::table('ProjectAgent')
                    ->select('*')
                    ->where('ProjectAgent.KodeProject','=',$KodeProject)
                    ->get();
    }

    public static function sales($KodeAgent){
        return DB::table('Sales')
                    ->join('User','User.UsernameKP','=','Sales.UsernameKP')
                    ->select('*')
                    ->where('Sales.KodeAgent','=',$KodeAgent)
                    ->where('User.Active','=', 1)
                    ->get();
    }

    public static function next_agent($UrutProjectAgent,$KodeProject){
        return DB::table('ProjectAgent')
                    ->leftJoin('Sales','Sales.KodeAgent','=','ProjectAgent.KodeAgent')
                    ->leftJoin('User','User.UsernameKP','=','Sales.UsernameKP')
                    ->select('ProjectAgent.KodeAgent','ProjectAgent.UrutProjectAgent')
                    ->where('ProjectAgent.UrutProjectAgent','=',$UrutProjectAgent)
                    ->where('ProjectAgent.KodeProject','=',$KodeProject)
                    ->where('User.Active','=',1)
                    ->get();
    }

    public static function next_sales($UrutAgentSales,$KodeAgent){
        return DB::table('Sales')
                    ->select('*')
                    ->where('Sales.UrutAgentSales','=',$UrutAgentSales)
                    ->where('Sales.KodeAgent','=',$KodeAgent)
                    ->get();
    }

    public static function prospectID(){
        return DB::table('Prospect')
                    ->select(DB::raw('MAX(ProspectID) as ProspectID'))
                    ->get();
    }

    public static function get_sales($KodeSales){
        return DB::table('Sales')
                    ->select('Sales.*')
                    ->where('Sales.KodeSales','=',$KodeSales)
                    ->get();
    }

    public static function get_agent($KodeAgent){
        return DB::table('Agent')
                    ->select('Agent.*')
                    ->where('Agent.KodeAgent','=',$KodeAgent)
                    ->get();
    }

    public static function sendby($KodeProject){
        return DB::table('Project')
                    ->select('Project.SendBy')
                    ->where('Project.KodeProject','=',$KodeProject)
                    ->get();
    }
}
