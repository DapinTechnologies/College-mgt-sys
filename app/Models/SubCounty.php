<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCounty extends Model
{
    use HasFactory;

    protected $table = 'subcounties'; // Explicitly define the table name

    protected $fillable = [
        'SubCountyName', 'CountyID'
    ];

    public function county()
    {
        return $this->belongsTo(County::class, 'CountyID');
    }
}

