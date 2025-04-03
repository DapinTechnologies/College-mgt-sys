<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stkpush extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function fee()
{
    return $this->belongsTo(Fee::class);  // Assuming the 'fees' table has a 'fee_id' column
}





}
