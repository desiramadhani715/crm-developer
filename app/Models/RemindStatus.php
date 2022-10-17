<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemindStatus extends Model
{
    use HasFactory;
    protected $table = 'RemindStatus';
    protected $primaryKey = 'id';
    protected $fillable = [
        'KodeSales',
        'ProspectID',
        'ColdDay3',
        'ColdDay6',
        'WarmDay5',
        'WarmDay10',
        'WarmDay15',
        'WarmDay19',
        'HotDay5',
        'HotDay10',
        'HotDay15',
        'HotDay19',
    ];
    public $timestamps = ["created_at"];
    const UPDATED_AT = NULL;
}
