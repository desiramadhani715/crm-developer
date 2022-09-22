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

    public static function get_leads_project($KodeProject){
        return DB::table('Prospect')
                    ->leftJoin('SumberData','SumberData.SumberDataID','=','Prospect.SumberDataID')
                    ->leftJoin('SumberPlatform','SumberPlatform.KodePlatform','=','Prospect.KodePlatform')
                    ->join('Project','Project.KodeProject','=','Prospect.KodeProject')
                    ->join('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                    ->leftJoin('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                    ->select('Prospect.*','SumberData.NamaSumber','SumberPlatform.NamaPlatform','Sales.NamaSales','HistoryProspect.*',DB::raw('DATE(Prospect.AddDate) AddDate'),DB::raw('DATE(HistoryProspect.AcceptDate) AcceptDate'))
                    ->where('HistoryProspect.KodeProject','=',$KodeProject)
                    ->orderBy('Prospect.ProspectID','desc')
                    ->get();
    }

    public static function leads_filter($KodeAgent,$KodeSales,$status){
        return DB::table('Prospect')
                    ->leftJoin('SumberData','SumberData.SumberDataID','=','Prospect.SumberDataID')
                    ->leftJoin('SumberPlatform','SumberPlatform.KodePlatform','=','Prospect.KodePlatform')
                    ->join('Project','Project.KodeProject','=','Prospect.KodeProject')
                    ->join('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                    ->leftJoin('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                    ->select('Prospect.*','SumberData.NamaSumber','SumberPlatform.NamaPlatform','Sales.NamaSales','HistoryProspect.*',DB::raw('DATE(Prospect.AddDate) AddDate'),DB::raw('DATE(HistoryProspect.AcceptDate) AcceptDate'))
                    ->where('HistoryProspect.KodeAgent','like','%'.$KodeAgent.'%')
                    ->where('HistoryProspect.KodeSales','like','%'.$KodeSales.'%')
                    ->where('Prospect.Status','like','%'.$status.'%')
                    ->orderBy('Prospect.ProspectID','desc')
                    ->get();
    }

}
