<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class historysales extends Model
{
    use HasFactory;
    protected $table = 'HistorySales';
    protected $fillable = ['KodeSales','Notes','NotesDev','Subject','SubjectDev','KodeProject','HistoryBy'];

    public static function history(){
        return DB::table('HistorySales')
                ->join('Project','Project.KodeProject','=','HistorySales.KodeProject')
                ->join('PT','PT.KodePT','Project.KodePT')
                ->select('HistorySales.*',DB::raw('MonthName(HistorySales.created_at) month, day(HistorySales.created_at) day, Hour(HistorySales.created_at) hour, minute(HistorySales.created_at) minute'))
                ->where('HistorySales.HistoryBy','=','Sales')
                ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                ->orderBy('HistorySales.id','desc')
                ->get();
    }
    
    public static function history_sales($KodeSales){
        return DB::table('HistorySales')
                ->join('Project','Project.KodeProject','=','HistorySales.KodeProject')
                ->join('PT','PT.KodePT','Project.KodePT')
                ->select('HistorySales.*',DB::raw('MonthName(HistorySales.created_at) month, day(HistorySales.created_at) day, Hour(HistorySales.created_at) hour, minute(HistorySales.created_at) minute'))
                ->whereRaw('HistorySales.HistoryBy = "Sales" && HistorySales.KodeSales ='.'"'.$KodeSales.'"')
                ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                ->orderBy('HistorySales.id','desc')
                ->get();
    }
}