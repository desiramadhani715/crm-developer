<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class prospect extends Model
{
    protected $table = 'Prospect';
    protected $primaryKey = 'ProspectID';
    protected $fillable = ['NamaProspect', 'Hp','EmailProspect', 'Message', 'SumberDataID', 'LevelInputID', 'Status', 'KodeProject', 'KodePT', 'KodeAds', 'KodePlatform','Campaign','KodeNegara','NoteSumberData'];
    const CREATED_AT = 'AddDate';
    const UPDATED_AT = 'EditDate';

    public static function get_prospect(){
        return DB::table('Prospect')
                    ->leftJoin('SumberData','SumberData.SumberDataID','=','Prospect.SumberDataID')
                    ->leftJoin('SumberPlatform','SumberPlatform.KodePlatform','=','Prospect.KodePlatform')
                    ->join('Project','Project.KodeProject','=','Prospect.KodeProject')
                    ->join('PT','PT.KodePT','=','Prospect.KodePT')
                    ->join('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                    ->leftJoin('tipe_unit','HistoryProspect.UnitID','=','tipe_unit.UnitID')
                    ->leftJoin('NotInterested','NotInterested.NotInterestedID','=','Prospect.NotInterestedID')
                    ->leftJoin('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                    ->select('Prospect.*','SumberData.NamaSumber','SumberPlatform.NamaPlatform','HistoryProspect.*','tipe_unit.UnitName','Sales.NamaSales',DB::raw('DATE(HistoryProspect.AcceptDate) AcceptDate'),'NotInterested.Alasan')
                    ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->orderBy('Prospect.ProspectID','desc')
                    ->get();
    }
    //FILTER

    public static function filter($Project,$agent,$status,$SumberDataID,$KodePlatform,$hot,$KodeSales,$level,$since,$To,$statusBetween){
        $query = DB::table('Prospect')
                    ->leftJoin('SumberData','SumberData.SumberDataID','=','Prospect.SumberDataID')
                    ->leftJoin('SumberPlatform','SumberPlatform.KodePlatform','=','Prospect.KodePlatform')
                    ->leftJoin('LevelInput','LevelInput.LevelInputID','=','Prospect.LevelInputID')
                    ->join('Project','Project.KodeProject','=','Prospect.KodeProject')
                    ->join('PT','PT.KodePT','=','Prospect.KodePT')
                    ->join('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                    ->leftJoin('tipe_unit','HistoryProspect.UnitID','=','tipe_unit.UnitID')
                    ->leftJoin('NotInterested','NotInterested.NotInterestedID','=','Prospect.NotInterestedID')
                    ->join('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                    ->where('HistoryProspect.KodeSales','like','%'.$KodeSales.'%')
                    ->where('HistoryProspect.KodeAgent','like','%'.$agent.'%')
                    ->where('Prospect.KodeProject','like','%'.$Project.'%')
                    ->where('Prospect.KodeProject','like','%'.$Project.'%')
                    ->where('Prospect.Status','like','%'.$status.'%')
                    ->where('Prospect.Hot','like','%'.$hot.'%')
                    ->where(DB::raw('COALESCE(Prospect.SumberDataID,\'\')'),'like','%'.$SumberDataID.'%')
                    ->where(DB::raw('COALESCE(Prospect.KodePlatform,\'\')'),'like','%'.$KodePlatform.'%')
                    ->where('LevelInput.Level','like','%'.$level.'%');
        if($statusBetween){
            $query->whereBetween('Prospect.AddDate',[$since, $To]);
        }
        $query->select('Prospect.*','NotInterested.Alasan','SumberData.NamaSumber','SumberPlatform.NamaPlatform','HistoryProspect.*','tipe_unit.UnitName','Sales.NamaSales',DB::raw('DATE(Prospect.AddDate) AddDate'),DB::raw('DATE(Prospect.EditDate) EditDate'));
        $query->where('PT.UsernameKP','=',Auth::User()->UsernameKP);
       return $query->get();

    }

    public static function download($Project,$status,$SumberDataID,$KodePlatform,$hot,$KodeSales,$level,$since,$To,$statusBetween){
        $query = DB::table('Prospect')
                    ->leftJoin('SumberData','SumberData.SumberDataID','=','Prospect.SumberDataID')
                    ->leftJoin('Usia','Usia.UsiaID','=','Prospect.UsiaID')
                    ->leftJoin('Gender','Gender.GenderID','=','Prospect.GenderID')
                    ->leftJoin('SumberPlatform','SumberPlatform.KodePlatform','=','Prospect.KodePlatform')
                    ->leftJoin('LevelInput','LevelInput.LevelInputID','=','Prospect.LevelInputID')
                    ->leftJoin('Kota','Kota.id','Prospect.TempatTinggalID')
                    ->leftJoin('Pekerjaan','Pekerjaan.PekerjaanID','=','Prospect.PekerjaanID')
                    ->leftJoin('Project','Project.KodeProject','=','Prospect.KodeProject')
                    ->leftJoin('PT','PT.KodePT','=','Prospect.KodePT')
                    ->leftJoin('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                    ->leftJoin('Agent','Agent.KodeAgent','=','HistoryProspect.KodeAgent')
                    ->leftJoin('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                    ->leftJoin('Hot','Hot.id','=','Prospect.Hot')
                    ->where('HistoryProspect.KodeSales','like','%'.$KodeSales.'%')
                    ->where('Prospect.KodeProject','like','%'.$Project.'%')
                    ->where('Prospect.Status','like','%'.$status.'%')
                    ->where('Prospect.Hot','like','%'.$hot.'%')
                    ->where(DB::raw('COALESCE(Prospect.SumberDataID,\'\')'),'like','%'.$SumberDataID.'%')
                    ->where(DB::raw('COALESCE(Prospect.KodePlatform,\'\')'),'like','%'.$KodePlatform.'%')
                    ->where('LevelInput.Level','like','%'.$level.'%');
        if($statusBetween){
            $query->whereBetween('Prospect.AddDate',[$since, $To]);
        }
        $query->select('Prospect.NamaProspect','Prospect.Hp','Prospect.EmailProspect','Prospect.Message','Gender.JenisKelamin','Usia.RangeUsia','Kota.city','Pekerjaan.TipePekerjaan','SumberData.NamaSumber','SumberPlatform.NamaPlatform','Prospect.LevelInputID','Prospect.InputBy',DB::raw('DATE(Prospect.AddDate) AddDate'),'Sales.KodeSales','Sales.NamaSales','HistoryProspect.KodeAgent','Agent.NamaAgent','Prospect.KodeProject','HistoryProspect.ClosingAmount','Prospect.CatatanSales','Prospect.Status','Hot.ket');
        $query->where('PT.UsernameKP','=',Auth::User()->UsernameKP);
       return $query->get();

    }

    //PROSPECT SALES

    public static function prospect_sales($UsernameKP){
        return DB::table('Prospect')
                    ->leftJoin('SumberData','SumberData.SumberDataID','=','Prospect.SumberDataID')
                    ->leftJoin('SumberPlatform','SumberPlatform.KodePlatform','=','Prospect.KodePlatform')
                    ->join('Project','Project.KodeProject','=','Prospect.KodeProject')
                    ->join('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                    ->leftJoin('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                    ->select('Prospect.*','SumberData.NamaSumber','SumberPlatform.NamaPlatform','HistoryProspect.*','Sales.NamaSales',DB::raw('DATE(Prospect.AddDate) AddDate'),DB::raw('DATE(HistoryProspect.AcceptDate) AcceptDate'))
                    ->where('Sales.UsernameKP','=',$UsernameKP)
                    ->orderBy('Prospect.ProspectID','desc')
                    ->get();
    }

    public static function prospect_sales2($KodeSales){
        return DB::table('Prospect')
                    ->leftJoin('SumberData','SumberData.SumberDataID','=','Prospect.SumberDataID')
                    ->leftJoin('SumberPlatform','SumberPlatform.KodePlatform','=','Prospect.KodePlatform')
                    ->join('Project','Project.KodeProject','=','Prospect.KodeProject')
                    ->join('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                    ->leftJoin('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                    ->select('Prospect.*','SumberData.NamaSumber','SumberPlatform.NamaPlatform','HistoryProspect.*','Sales.NamaSales',DB::raw('DATE(Prospect.AddDate) AddDate'),DB::raw('DATE(HistoryProspect.AcceptDate) AcceptDate'))
                    ->where('HistoryProspect.KodeSales','=',$KodeSales)
                    ->orderBy('Prospect.ProspectID','desc')
                    ->get();
    }

    public static function get_project(){
        return DB::table('Project')
                    ->join('PT','PT.KodePT','Project.KodePT')
                    ->select('Project.*')
                    ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->get();

    }

    public static function get_status(){
        return DB::table('Status')->select('*')->get();
    }

    //CHART PLATFORM AND SOURCE
    public static function get_platform(){
        return DB::table('Prospect')
                ->leftJoin('SumberData','SumberData.SumberDataID','=','Prospect.SumberDataID')
                ->join('SumberPlatform','SumberPlatform.KodePlatform','=','Prospect.KodePlatform')
                ->join('PT','PT.KodePT','=','Prospect.KodePT')
                ->join('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                ->join('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                ->select(DB::raw('count(Prospect.ProspectID) as total'),'SumberPlatform.NamaPlatform')
                ->groupBy('SumberPlatform.NamaPlatform')
                ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                ->orderBy('Prospect.ProspectID','desc')
                ->get();
    }

    public static function get_source(){
        return DB::table('Prospect')
                ->join('SumberData','SumberData.SumberDataID','=','Prospect.SumberDataID')
                ->leftJoin('SumberPlatform','SumberPlatform.KodePlatform','=','Prospect.KodePlatform')
                ->join('PT','PT.KodePT','=','Prospect.KodePT')
                ->join('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                ->join('Sales','Sales.KodeSales','=','HistoryProspect.KodeSales')
                ->select(DB::raw('count(Prospect.ProspectID) as total'),'SumberData.NamaSumber')
                ->groupBy('SumberData.NamaSumber')
                ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                ->orderBy('Prospect.ProspectID','desc')
                ->get();
    }

    //GET REPORT Prospect

    public static function get_total_prospect($bulan,$year){
        $query =  DB::table('Prospect')
                    ->join('PT', 'PT.KodePT','=','Prospect.KodePT')
                    ->select(DB::raw('count(*) as total_prospect'),DB::raw('YEAR(Prospect.AddDate) year, MONTHNAME(Prospect.AddDate) month, DAY(Prospect.AddDate) day, DATE(Prospect.AddDate) date'))
                    ->where('PT.UsernameKP','=',Auth::User()->UsernameKP);
                    if($bulan!=null && $year!=null){
                        $query->whereRaw('Month(Prospect.AddDate) ='.$bulan)
                            ->whereRaw('Year(Prospect.AddDate) ='.$year);
                    }else{
                        $query->whereRaw('Prospect.AddDate >= DATE_ADD(NOW(), INTERVAL -14 DAY)');
                    }
                    $query->groupBy('year','month','day')
                    ->orderBy('Prospect.ProspectID');
        return $query->get();

    }
    // get prospect dengan level input makuta dan sales

    public static function prospect_level($date,$level){
        $query = DB::table('Prospect')
                    ->join('PT', 'PT.KodePT','=','Prospect.KodePT')
                    ->select(DB::raw('count(*) as total_prospect'));
                if($level == 'Makuta'){
                    $query->whereRaw('(Prospect.LevelInputID = "admin_int" || Prospect.LevelInputID = "admin_mkt" || Prospect.LevelInputID = "system") && date(Prospect.AddDate) ='.'"'.$date.'"');
                }elseif($level == 'Sales'){
                    $query->whereRaw('(Prospect.LevelInputID = "system_ws" || Prospect.LevelInputID = "sales") && date(Prospect.AddDate) ='.'"'.$date.'"');
                }
                    $query->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->orderBy('Prospect.ProspectID');
        return $query->get();

    }

    public static function total_prospect($level,$bulan,$year){
        $query = DB::table('Prospect')
                    ->join('PT', 'PT.KodePT','=','Prospect.KodePT')
                    ->select(DB::raw('count(*) as total_prospect'));
                    if($bulan!=null && $year!=null){
                        $query->whereRaw('Month(Prospect.AddDate) ='.$bulan)
                            ->whereRaw('Year(Prospect.AddDate) ='.$year);
                        if($level == 'Makuta'){
                            $query->whereRaw('(Prospect.LevelInputID = "admin_int" || Prospect.LevelInputID = "admin_mkt" || Prospect.LevelInputID = "system") && month(Prospect.AddDate) = '.'"'.$bulan.'" && year(AddDate) = '.'"'.$year.'"');
                        }elseif($level == 'Sales'){
                            $query->whereRaw('(Prospect.LevelInputID = "system_ws" || Prospect.LevelInputID = "sales") && month(Prospect.AddDate) = '.'"'.$bulan.'" && year(AddDate) = '.'"'.$year.'"');
                        }elseif($level == 'All'){
                            $query->whereRaw('month(Prospect.AddDate) = '.'"'.$bulan.'" && year(AddDate) = '.'"'.$year.'"');
                        }
                    }elseif($bulan==null && $year == null){
                        if($level == 'Makuta'){
                            $query->whereRaw('(Prospect.LevelInputID = "admin_int" || Prospect.LevelInputID = "admin_mkt" || Prospect.LevelInputID = "system") && Prospect.AddDate >= DATE_ADD(NOW(), INTERVAL -14 DAY)');
                        }elseif($level == 'Sales'){
                            $query->whereRaw('(Prospect.LevelInputID = "system_ws" || Prospect.LevelInputID = "sales") && Prospect.AddDate >= DATE_ADD(NOW(), INTERVAL -14 DAY)');
                        }elseif($level == 'All'){
                            $query->whereRaw('Prospect.AddDate >= DATE_ADD(NOW(), INTERVAL -14 DAY)');
                        }
                    }
                    $query->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->orderBy('Prospect.ProspectID');
        return $query->get();
    }

    public static function total($bulan,$year){
        return DB::table('Prospect')
                    ->join('PT', 'PT.KodePT','=','Prospect.KodePT')
                    ->select(DB::raw('count(*) as total_prospect'))
                    ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->whereRaw('Month(Prospect.AddDate) ='.$bulan)
                    ->whereRaw('Year(Prospect.AddDate) ='.$year)
                    ->orderBy('Prospect.ProspectID')
                    ->get();

    }


    public static function get_total_prospect2(){
        return DB::table('Prospect')
                    ->join('PT', 'PT.KodePT','=','Prospect.KodePT')
                    ->select(DB::raw('count(*) as total_prospect'),DB::raw('YEAR(Prospect.AddDate) year, MONTHNAME(Prospect.AddDate) month, DAY(Prospect.AddDate) day'))
                    ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->whereRaw('Prospect.AddDate >= DATE_ADD(NOW(), INTERVAL -7 DAY)')
                    ->groupBy('year','month','day')
                    ->orderBy('Prospect.ProspectID')
                    ->get();

    }



    public static function data($data){
        return DB::table($data)->select('*')->get();
    }

     public static function data_prospect($ProspectID){
        return DB::table('Prospect')
                    ->join('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                    ->leftJoin('Usia','Usia.UsiaID','=','Prospect.UsiaID')
                    ->leftJoin('Gender','Gender.GenderID','=','Prospect.GenderID')
                    ->leftJoin('SumberData','SumberData.SumberDataID','=','Prospect.SumberDataID')
                    ->leftJoin('SumberAds','SumberAds.KodeAds','=','Prospect.KodeAds')
                    ->leftJoin('LevelInput','LevelInput.LevelInputID','=','Prospect.LevelInputID')
                    ->leftJoin('Pekerjaan','Pekerjaan.PekerjaanID','=','Prospect.PekerjaanID')
                    ->leftJoin('Penghasilan','Penghasilan.PenghasilanID','=','Prospect.PenghasilanID')
                    ->select('Prospect.*','Gender.JenisKelamin','Usia.RangeUsia','Pekerjaan.TipePekerjaan','Penghasilan.RangePenghasilan','SumberData.NamaSumber','SumberAds.JenisAds','HistoryProspect.KodeSales')
                    ->where('Prospect.ProspectID','=',$ProspectID)
                    ->get();
    }



    public static function max_prospectID(){
        return DB::table('Prospect')
                    ->join('PT','PT.KodePT','=','Prospect.KodePT')
                    ->select(DB::raw('MAX(Prospect.ProspectID) as ProspectID'))
                    ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->get();
    }

    public static function last_prospect($ProspectID){
        return DB::table('Prospect')
                ->join('HistoryProspect','HistoryProspect.ProspectID','Prospect.ProspectID')
                ->select('HistoryProspect.MoveDate','Prospect.Status','Prospect.ProspectID','Prospect.AddDate','Prospect.KodeProject','Prospect.NamaProspect')->where('Prospect.ProspectID','=',$ProspectID)->get();
    }


    public static function get_new(){
        return DB::table('Prospect')
                    ->join('PT','PT.KodePT','=','Prospect.KodePT')
                    ->select('Prospect.*')
                    ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->where('Prospect.Status','=','New')
                    ->where('Prospect.VerifiedStatus','=',1)
                    ->get();
    }


    public static function get_new_prospect(){
        return DB::table('Prospect')
                    ->join('PT','PT.KodePT','=','Prospect.KodePT')
                    ->join('HistoryProspect','HistoryProspect.ProspectID','Prospect.ProspectID')
                    ->select('Prospect.*','HistoryProspect.MoveDate')
                    ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->where('Prospect.Status','=','New')
                    ->where('Prospect.VerifiedStatus','=',1)
                    ->get();
    }

    // SPARKLINE CHART
    public static function get_proses(){
        return DB::table('Prospect')
                    ->join('PT', 'PT.KodePT','=','Prospect.KodePT')
                    ->select(DB::raw('count(*) as total_prospect'),DB::raw('YEAR(Prospect.AddDate) year, MONTHNAME(Prospect.AddDate) month, DAY(Prospect.AddDate) day'))
                    ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->whereRaw('Prospect.AddDate >= DATE_ADD(NOW(), INTERVAL -7 DAY)')
                    ->where('Prospect.Status','=','Process')
                    ->groupBy('year','month','day')
                    ->orderBy('Prospect.ProspectID')
                    ->get();

    }

    public static function get_closing(){
        return DB::table('Prospect')
                    ->join('PT', 'PT.KodePT','=','Prospect.KodePT')
                    ->select(DB::raw('count(*) as total_prospect'),DB::raw('YEAR(Prospect.AddDate) year, MONTHNAME(Prospect.AddDate) month, DAY(Prospect.AddDate) day'))
                    ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->whereRaw('Prospect.AddDate >= DATE_ADD(NOW(), INTERVAL -7 DAY)')
                    ->where('Prospect.Status','=','Closing')
                    ->groupBy('year','month','day')
                    ->orderBy('Prospect.ProspectID')
                    ->get();

    }

    public static function get_notInterested(){
        return DB::table('Prospect')
                    ->join('PT', 'PT.KodePT','=','Prospect.KodePT')
                    ->select(DB::raw('count(*) as total_prospect'),DB::raw('YEAR(Prospect.AddDate) year, MONTHNAME(Prospect.AddDate) month, DAY(Prospect.AddDate) day'))
                    ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                    ->whereRaw('Prospect.AddDate >= DATE_ADD(NOW(), INTERVAL -7 DAY)')
                    ->where('Prospect.Status','=','Not Interested')
                    ->groupBy('year','month','day')
                    ->orderBy('Prospect.ProspectID')
                    ->get();

    }


    // HISTORY FU
    public static function history_fu($ProspectID){
        return DB::table('Fu')
                ->join('Prospect','Prospect.ProspectID','=','Fu.ProspectID')
                ->join('PT', 'PT.KodePT','=','Prospect.KodePT')
                ->join('MediaFu','MediaFu.MediaFuID','=','Fu.MediaFuID')
                ->join('Sales','Sales.KodeSales','=','Fu.KodeSales')
                ->select('MediaFu.NamaMedia','Fu.*','Sales.NamaSales',DB::raw('MonthName(Fu.FuDate) month, day(Fu.FuDate) day, Hour(Fu.FuDate) hour, minute(Fu.FuDate) minute'))
                ->where('Fu.ProspectID','=',$ProspectID)
                ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                ->get();
    }

    // HISTORY MOVE
    public static function history_prospect_move($ProspectID){
        return DB::table('HistoryProspectMove')
                ->join('Prospect','Prospect.ProspectID','=','HistoryProspectMove.ProspectID')
                ->join('PT', 'PT.KodePT','=','Prospect.KodePT')
                ->join('Sales','Sales.KodeSales','=','HistoryProspectMove.KodeSalesPrev')
                ->select('Sales.NamaSales',DB::raw('MonthName(HistoryProspectMove.MoveDate) month, day(HistoryProspectMove.MoveDate) day, Hour(HistoryProspectMove.MoveDate) hour, minute(HistoryProspectMove.MoveDate) minute'))
                ->where('HistoryProspectMove.ProspectID','=',$ProspectID)
                ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
                ->orderBy('HistoryProspectMove.MoveID','desc')
                ->get();
    }


    // verifikasi prospect
    public static function data_verifikasi($ProspectID){
        return DB::table('Prospect')
                    ->join('HistoryProspect','HistoryProspect.ProspectID','=','Prospect.ProspectID')
                    ->select('Prospect.NamaProspect','HistoryProspect.KodeSales','HistoryProspect.KodeProject')
                    ->where('Prospect.ProspectID','=',$ProspectID)
                    ->get();
    }


}
