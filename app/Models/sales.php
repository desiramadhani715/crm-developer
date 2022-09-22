<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class sales extends Model
{
    use HasFactory;
    protected $table = 'Sales';
    protected $fillable = ['UrutKodeSales','KodeSales','ProjectAgentID','UrutAgentSales','KodeAgent','KodeProject','UsernameKP','NamaSales','Hp','PhotoUser','Ktp'];
    // public $timestamps = false;
    const CREATED_AT = 'JoinDate';
    const UPDATED_AT = 'EditDate';

    public static function get_data_sales($KodeAgent){
        return DB::table('Sales')
                    // ->leftJoin('User','User.UsernameKP','=','Sales.UsernameKP')
                    // ->select('Sales.*','User.Email','User.Active')
                    ->select('Sales.*')
                    ->groupBy('Sales.KodeSales')
                    ->where('Sales.KodeAgent','=',$KodeAgent)
                    ->orderBy('Sales.UrutAgentSales','desc')
                    ->get();
    }

    public static function get_data_sales2($KodeAgent,$KodeSales){
        return DB::table('Sales')
                    ->leftJoin('User','User.UsernameKP','=','Sales.UsernameKP')
                    ->select('Sales.*','User.Email','User.Active')
                    ->groupBy('Sales.KodeSales')
                    ->where('Sales.KodeAgent','=',$KodeAgent)
                    ->where('Sales.KodeSales','!=', $KodeSales)
                    ->where('User.Active','=',1)
                    ->orderBy('Sales.UrutAgentSales','desc')
                    ->get();
    }

    public static function prospect($KodeSales){
        return DB::table('Sales')
                    ->leftJoin('HistoryProspect','HistoryProspect.KodeSales','=','Sales.KodeSales')
                    ->leftJoin('User','User.UsernameKP','=','Sales.UsernameKP')
                    ->select('Sales.*','User.Email','User.Active',DB::raw('count(ProspectID) as prospect'))
                    ->where('HistoryProspect.KodeSales','=',$KodeSales)
                    ->get();
    }

    public static function get_sales($KodeAgent, $KodeSales, $UrutAgentSales){
        return DB::table('Sales')
                    ->select('Sales.*')
                    ->where('Sales.KodeAgent','=',$KodeAgent)
                    // ->where('Sales.KodeSales','=',$KodeSales)
                    ->having('Sales.UrutAgentSales','>', $UrutAgentSales)
                    ->get();
    }

    public static function get_closing_amount($KodeSales){
        return DB::table('HistoryProspect')
                    ->join('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                    ->select(DB::raw('sum(HistoryProspect.ClosingAmount) as total'))
                    ->where('Sales.KodeSales','=',$KodeSales)
                    ->get();
    }

    public static function get_kode_sales($KodeAgent){
        return DB::table('Sales')
                    ->select(DB::raw('max(Sales.UrutKodeSales) as UrutKodeSales'))
                    ->where('Sales.KodeAgent', '=', $KodeAgent)
                    ->get();
    }

    public static function get_project_agent($KodeAgent){
        return DB::table('ProjectAgent')
                    ->select('ProjectAgent.*')
                    ->where('ProjectAgent.KodeAgent','=',$KodeAgent)
                    ->get();
    }

    public static function get_urut_agent_sales($KodeAgent){
        return DB::table('Sales')
                    ->select(DB::raw('max(Sales.UrutAgentSales) as UrutAgentSales'))
                    ->where('Sales.KodeAgent','=',$KodeAgent)
                    ->get();
    }

    public static function get_prospect($KodeSales){
        return DB::table('HistoryProspect')
                    ->select(DB::raw('count(ProspectID) as prospect'))
                    ->where('HistoryProspect.KodeSales','=',$KodeSales)
                    ->get();
    }

    public static function get_user($UsernameKP){
        return DB::table('User')
                    ->select('User.Active')
                    ->where('User.UsernameKP','=',$UsernameKP)
                    ->get();
    }
    
    public static function get_all($namaPT){
        return DB::table('Sales')
                    ->join('Project','Project.KodeProject','=','Sales.KodeProject')
                    ->join('PT','PT.KodePT','=','Project.KodePT')
                    ->select('Sales.KodeSales','Sales.NamaSales')
                    ->where('PT.NamaPT','=',$namaPT)
                    ->orderBy('Sales.KodeSales')
                    ->get();
    }
}