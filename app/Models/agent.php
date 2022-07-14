<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class agent extends Model
{
    use HasFactory;
    protected $table = 'Agent';
    protected $fillable = ['KodeAgent','UrutAgent','KodeProject','NamaAgent','Pic','Hp','UsernameKP','PhotoUser'];
    // public $timestamps = false;
    const CREATED_AT = 'JoinDate';
    const UPDATED_AT = 'EditDate';

    public static function get_closing_amount($UsernameKP){
        $closingAm = DB::table('HistoryProspect')
                        ->join('PT','PT.KodePT','=','HistoryProspect.KodePT')
                        ->join('Project','Project.KodeProject','=','HistoryProspect.KodeProject')
                        ->join('Agent','Agent.KodeAgent','=','HistoryProspect.KodeAgent')
                        ->select(DB::raw('sum(HistoryProspect.ClosingAmount) as total'),'Agent.KodeAgent')
                        ->where('PT.UsernameKP','=',$UsernameKP)
                        ->groupBy('HistoryProspect.KodeAgent')
                        ->orderBy('HistoryProspect.KodeAgent','asc')
                        ->get();
        return $closingAm;
    }

    public static function get_closing_amount_sales($UsernameKP){
        $closingAm = DB::table('HistoryProspect')
                        ->join('PT','PT.KodePT','=','HistoryProspect.KodePT')
                        ->join('Project','Project.KodeProject','=','HistoryProspect.KodeProject')
                        ->join('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                        ->select(DB::raw('sum(HistoryProspect.ClosingAmount) as total'),'Sales.NamaSales')
                        ->where('PT.UsernameKP','=',$UsernameKP)
                        ->groupBy('HistoryProspect.KodeSales')
                        ->orderBy('HistoryProspect.KodeSales','asc')
                        ->get();
        return $closingAm;
    }

    public static function filter_closing_amount($since, $to){
        $closingAm = DB::table('HistoryProspect')
                        ->join('PT','PT.KodePT','=','HistoryProspect.KodePT')
                        ->join('Project','Project.KodeProject','=','HistoryProspect.KodeProject')
                        ->join('Agent','Agent.KodeAgent','=','HistoryProspect.KodeAgent')
                        ->select(DB::raw('sum(HistoryProspect.ClosingAmount) as total'))
                        ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                        ->whereBetween('HistoryProspect.ClosingDate',[$since, $to])
                        ->groupBy('HistoryProspect.KodeAgent')
                        ->orderBy('HistoryProspect.KodeAgent','asc')
                        ->get();
        return $closingAm;
    }

    public static function get_data_agent(){
        return DB::table('Agent')
                ->join('Project','Project.KodeProject','=','Agent.KodeProject')
                ->join('PT','PT.KodePT','=','Project.KodePT')
                ->join('User', 'User.UsernameKP','Agent.UsernameKP')
                ->select('Agent.*','Project.KodeProject','Project.NamaProject','User.Email','User.UsernameKP','User.PasswordKP','User.Active')
                ->where('PT.UsernameKP','=', Auth::user()->UsernameKP)
                ->get();
    }

    public static function get_data_agent2($KodeAgent){
        return DB::table('Agent')
                ->join('Project','Project.KodeProject','=','Agent.KodeProject')
                ->join('PT','PT.KodePT','=','Project.KodePT')
                ->join('User', 'User.UsernameKP','Agent.UsernameKP')
                ->select('Agent.*','Project.KodeProject','Project.NamaProject','User.Email','User.UsernameKP','User.PasswordKP')
                ->where('Agent.KodeAgent','!=',$KodeAgent)
                ->where('PT.UsernameKP','=', Auth::user()->UsernameKP)
                ->get();
    }
    public static function get_data_sales($KodeAgent){
        return DB::table('Sales')
                    ->leftJoin('User','User.UsernameKP','=','Sales.UsernameKP')
                    ->select('Sales.*')
                    ->where('Sales.KodeAgent','=',$KodeAgent)
                    ->where('User.Active','=',1)
                    ->orderBy('Sales.UrutAgentSales','desc')
                    ->get();
    }

    public static function get_agent_all($KodeProject){
        return DB::table('Agent')
                    ->leftJoin('User','User.UsernameKP','=','Agent.UsernameKP')
                    ->select('Agent.*')
                    ->where('Agent.KodeProject','=',$KodeProject)
                    ->where('User.Active','=',1)
                    ->orderBy('Agent.UrutAgent','desc')
                    ->get();
    }

    public static function get_detail_agent($KodeAgent){
        return DB::table('Agent')
                ->join('Project','Project.KodeProject','=','Agent.KodeProject')
                ->join('PT','PT.KodePT','=','Project.KodePT')
                ->join('User', 'User.UsernameKP','Agent.UsernameKP')
                ->select('Agent.*','Project.KodeProject','Project.NamaProject','User.Email','User.UsernameKP','User.PasswordKP')
                ->where('PT.UsernameKP','=', Auth::user()->UsernameKP)
                ->where('Agent.KodeAgent','=',$KodeAgent)
                ->get();
    }

    public static function get_urut_agent($KodeProject){
        $data = DB::table('ProjectAgent')
                    ->select(DB::raw('count(KodeProject) as UrutAgent'))
                    ->where('KodeProject','=',$KodeProject)
                    ->groupBy('KodeProject')
                    ->get();
        return $data;
    }

    public static function get_prospect($KodeAgent){
        return DB::table('HistoryProspect')
                    ->select(DB::raw('count(ProspectID) as prospect'))
                    ->where('HistoryProspect.KodeAgent','=',$KodeAgent)
                    ->get();
    }

    public static function get_prospect_agent($KodeAgent){
        return DB::table('Prospect')
                    ->leftJoin('SumberData','SumberData.SumberDataID','=','Prospect.SumberDataID')
                    ->leftJoin('SumberPlatform','SumberPlatform.KodePlatform','=','Prospect.KodePlatform')
                    ->join('Project','Project.KodeProject','=','Prospect.KodeProject')
                    ->join('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                    ->leftJoin('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                    ->select('Prospect.*','SumberData.NamaSumber','SumberPlatform.NamaPlatform','Sales.NamaSales','HistoryProspect.*',DB::raw('DATE(Prospect.AddDate) AddDate'),DB::raw('DATE(HistoryProspect.AcceptDate) AcceptDate'))
                    ->where('HistoryProspect.KodeAgent','=',$KodeAgent)
                    ->orderBy('Prospect.ProspectID','desc')
                    ->get();
    }

    public static function max_sort_agent($KodeProject){
        return DB::table('Agent')
                ->join('Project','Project.KodeProject','=','Agent.KodeProject')
                ->join('User','User.UsernameKP','=', 'Agent.UsernameKP')
                ->select(DB::raw('MAX(Agent.UrutAgent) as max'))
                ->where('User.Active','=',1)
                ->where('Project.KodeProject','=',$KodeProject)
                ->get();
    }

    public static function min_sort_agent($KodeProject){
        return DB::table('Agent')
                ->join('Project','Project.KodeProject','=','Agent.KodeProject')
                ->join('User','User.UsernameKP','=', 'Agent.UsernameKP')
                ->select(DB::raw('MIN(Agent.UrutAgent) as min'))
                ->where('User.Active','=',1)
                ->where('Project.KodeProject','=',$KodeProject)
                ->get();
    }

    public static function get_agent($KodeProject){
        return DB::table('Agent')
                ->join('Project','Project.KodeProject','=','Agent.KodeProject')
                ->join('User','User.UsernameKP','=', 'Agent.UsernameKP')
                ->join('PT','PT.KodePT','=','Project.KodePT')
                ->select('Agent.KodeAgent','Agent.NamaAgent','Project.NamaProject','Agent.UrutAgent','User.Active')
                ->where('User.Active','=',1)
                ->where('Project.KodeProject','=',$KodeProject)
                ->get();
    }

    
    public static function agent_data($KodeAgent, $KodeProject, $UrutAgent){
        return DB::table('Agent')
                    ->select('Agent.*')
                    ->where('Agent.KodeProject','=',$KodeProject)
                    ->having('Agent.UrutAgent','>', $UrutAgent)
                    ->get();
    }

}
