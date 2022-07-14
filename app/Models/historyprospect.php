<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class historyprospect extends Model
{

    protected $table = 'HistoryProspect';
    protected $fillable = ['KodePT','KodeProject','ProspectID','KodeAgent','KodeSales','BlastAgentID','BlastSalesID','Email','LevelInputID','MoveID','NumberMove','MoveDate'];
    protected $primaryKey = 'HistoryProsID';
    public $timestamps = false;

     // TOTAL DARI TOTAL LEADS, IN PROCESS, CLOSING, NOT INTERESTED

     public static function get_total_leads(){
        $total_leads = DB::table('HistoryProspect')
                             ->join('Project','Project.KodeProject','=','HistoryProspect.KodeProject')
                             ->join('PT','PT.KodePT','=','Project.KodePT')
                             ->select(DB::raw('count(*) as total_leads'))
                             ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                             ->get();
         return $total_leads;
     }

     public static function get_inprocess(){
         $data = DB::table('HistoryProspect')
                     ->leftJoin('Prospect','Prospect.ProspectID','=','HistoryProspect.ProspectID')
                     ->join('PT','HistoryProspect.KodePT','=','PT.KodePT')
                     ->select(DB::raw('count(*) as inprocess'))
                     ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                     ->where('Prospect.status','=','Process')
                     ->get();
         return $data;
     }

     public static function process(){
        return DB::table('Prospect')
                ->leftJoin('SumberData','SumberData.SumberDataID','=','Prospect.SumberDataID')
                ->leftJoin('SumberPlatform','SumberPlatform.KodePlatform','=','Prospect.KodePlatform')
                ->join('PT','PT.KodePT','=','Prospect.KodePT')
                ->join('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                ->join('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                ->leftJoin('tipe_unit','HistoryProspect.UnitID','=','tipe_unit.UnitID')
                ->where('Prospect.Status','=','Process')
                ->select('Prospect.*','SumberData.NamaSumber','SumberPlatform.NamaPlatform','HistoryProspect.*','tipe_unit.UnitName','Sales.NamaSales',DB::raw('DATE(Prospect.AddDate) AddDate'),DB::raw('DATE(Prospect.EditDate) EditDate'))
                ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                ->get();
     }

     public static function get_closing(){
         $data = DB::table('HistoryProspect')
                     ->leftJoin('Prospect','Prospect.ProspectID','=','HistoryProspect.ProspectID')
                     ->join('PT','HistoryProspect.KodePT','=','PT.KodePT')
                     ->select(DB::raw('count(*) as closing'))
                     ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                     ->where('Prospect.status','=','Closing')
                     ->get();
         return $data;
     }

     public static function closing(){
         return DB::table('Prospect')
                    ->leftJoin('SumberData','SumberData.SumberDataID','=','Prospect.SumberDataID')
                    ->leftJoin('SumberPlatform','SumberPlatform.KodePlatform','=','Prospect.KodePlatform')
                    ->join('PT','PT.KodePT','=','Prospect.KodePT')
                    ->join('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                    ->leftJoin('tipe_unit','HistoryProspect.UnitID','=','tipe_unit.UnitID')
                    ->join('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                    ->where('Prospect.Status','=','Closing')
                    ->select('Prospect.*','SumberData.NamaSumber','SumberPlatform.NamaPlatform','HistoryProspect.*','tipe_unit.UnitName','Sales.NamaSales',DB::raw('DATE(Prospect.AddDate) AddDate'),DB::raw('DATE(Prospect.EditDate) EditDate'))
                    ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->get();
     }

     public static function get_notInterested(){
         $data = DB::table('HistoryProspect')
                     ->leftJoin('Prospect','Prospect.ProspectID','=','HistoryProspect.ProspectID')
                     ->join('PT','HistoryProspect.KodePT','=','PT.KodePT')
                     ->select(DB::raw('count(*) as notinterested'))
                     ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                     ->where('Prospect.status','=','Not Interested')
                     ->get();
         return $data;
     }

    public static function notInterested(){
        return DB::table('Prospect')
                    ->leftJoin('SumberData','SumberData.SumberDataID','=','Prospect.SumberDataID')
                    ->leftJoin('SumberPlatform','SumberPlatform.KodePlatform','=','Prospect.KodePlatform')
                    ->join('PT','PT.KodePT','=','Prospect.KodePT')
                    ->join('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                    ->join('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                    ->leftJoin('tipe_unit','HistoryProspect.UnitID','=','tipe_unit.UnitID')
                    ->leftJoin('NotInterested','NotInterested.NotInterestedID','=','Prospect.NotInterestedID')
                    ->where('Prospect.Status','=','Not Interested')
                    ->select('Prospect.*','NotInterested.Alasan','SumberData.NamaSumber','SumberPlatform.NamaPlatform','HistoryProspect.*','Sales.NamaSales',DB::raw('DATE(Prospect.AddDate) AddDate'),DB::raw('DATE(Prospect.EditDate) EditDate'),'tipe_unit.UnitName')
                    ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->get();
     }

    public static function get_expired(){
        $inProcess = DB::table('HistoryProspect')
                    ->leftJoin('Prospect','Prospect.ProspectID','=','HistoryProspect.ProspectID')
                    ->join('PT','HistoryProspect.KodePT','=','PT.KodePT')
                    ->select(DB::raw('count(*) as total'))
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                    ->where('Prospect.status','=','Expired')
                    ->get();
        return $inProcess;
    }



    // MENAMPILKAN PROJECT PER PT

    public static function get_project(){
        return DB::table('Project')
                    ->join('PT','PT.KodePT','=','Project.KodePT')
                    ->select('Project.*')
                    ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                    ->get();
    }

    // MENAMPILKAN KODE AGEN DAN TOTAL LEADS PER AGENT
    public static function get_agent($KodeProject){
        return DB::table('ProjectAgent')
                    ->join('HistoryProspect','HistoryProspect.KodeAgent','=','ProjectAgent.KodeAgent')
                    ->select(DB::raw('count(HistoryProspect.ProspectID) as total_leads'),'ProjectAgent.KodeAgent')
                    ->where('ProjectAgent.KodeProject','=',$KodeProject)
                    ->groupBy('ProjectAgent.KodeAgent')
                    ->get();
    }
    
    public static function get_project_agent($KodeProject){
        return DB::table('ProjectAgent')
                    ->where('ProjectAgent.KodeProject','=',$KodeProject)
                    ->groupBy('ProjectAgent.KodeAgent')
                    ->get();
    }

    // MENAMPILKAN Prospect  PER AGENT
    public static function get_Prospect($KodeAgent,$status){
        return DB::table('HistoryProspect')
                    ->join('Prospect','Prospect.ProspectID','HistoryProspect.ProspectID')
                    ->select(DB::raw('count(Prospect.ProspectID) as status'))
                    ->where('Prospect.Status','=',$status)
                    ->where('HistoryProspect.KodeAgent','=',$KodeAgent)
                    ->get();
    }

    //MENAMPILKAN TOTAL PER AGENT
    public static function get_total($KodeProject, $status){
        return DB::table('HistoryProspect')
                    ->join('Prospect','Prospect.ProspectID','HistoryProspect.ProspectID')
                    ->select(DB::raw('count(Prospect.ProspectID) total'))
                    ->where('Prospect.Status','=',$status)
                    ->where('HistoryProspect.KodeProject','=',$KodeProject)
                    ->get();
    }

    // MENGHITUNG PERSENTASE
    public static function get_persentase($total, $total_leads){
        return round($total/$total_leads * 100,2);
    }

    // agent untuk Prospect
    public static function agent($ProspectID){
        return DB::table('HistoryProspect')->select('HistoryProspect.KodeAgent')->where('HistoryProspect.ProspectID','=',$ProspectID)->get();
    }


    //get history
    public static function history($ProspectID){
        return DB::table('HistoryProspect')->select('*')->where('ProspectID','=',$ProspectID)->get();
    }


    
    public static function get_prospect_agent($KodeAgent){
        return DB::table('HistoryProspect')->select(DB::raw('count(ProspectID) as total'))->where('KodeAgent','=',$KodeAgent)->get();
    }
    
    public static function prospect_per_agent($KodeAgent, $Status){
        return DB::table('HistoryProspect')
                ->join('Prospect','Prospect.ProspectID','=','HistoryProspect.ProspectID')
                ->select(DB::raw('count(HistoryProspect.ProspectID) as total'))
                ->where('HistoryProspect.KodeAgent','=',$KodeAgent)
                ->where('Prospect.Status','=',$Status)
                ->get();
    }
    
    public static function prospect_per_project_all($KodeProject){
        return DB::table('Prospect')
                ->select(DB::raw('count(ProspectID) as total'))
                ->where('KodeProject','=',$KodeProject)
                ->get();
    }
    
    public static function prospect_per_project($KodeProject, $Status){
        return DB::table('HistoryProspect')
                ->join('Prospect','Prospect.ProspectID','=','HistoryProspect.ProspectID')
                ->select(DB::raw('count(HistoryProspect.ProspectID) as total'))
                ->where('HistoryProspect.KodeProject','=',$KodeProject)
                ->where('Prospect.Status','=',$Status)
                ->get();
    }
    
}