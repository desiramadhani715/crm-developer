<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class historyprospectmove extends Model
{
    use HasFactory;
    protected $table = 'HistoryProspectMove';
    protected $primaryKey = 'MoveID';
    protected $fillable = ['ProspectID','KodeProject','MoveAgentID','KodeAgent','MoveAgentIDPrev','KodeAgentPrev','MoveSalesID','KodeSales','MoveSalesIDPrev','KodeSalesPrev'];
    public $timestamps = false;
    const CREATED_AT = 'MoveDate';

    public static function moveID($prospectID){
        return DB::table('HistoryProspectMove')
                    ->select(DB::raw('max(MoveID) as MoveID'))
                    ->where('ProspectID','=',$prospectID)
                    ->get();
    }
}
