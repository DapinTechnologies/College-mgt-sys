<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
  
    public function studentEnroll()
    {
        return $this->belongsTo(StudentEnroll::class, 'student_enroll_id');
    }
  
    public function category()
    {
        return $this->belongsTo(FeesCategory::class, 'category_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function mpesaTransactions()
    {
        return $this->hasMany(MpesaTransaction::class);
    }


     // Total paid amount
     public function getTotalPaidAttribute()
     {
         return $this->transactions()->where('type', 1)->sum('amount');
     }
 
     // Remaining balance
     public function getRemainingBalanceAttribute()
     {
         return $this->fee_amount - $this->total_paid;
     }



public function transactions()
{
    return $this->hasMany(Transaction::class, 'fee_id', 'id');
}

public function student()
{
    return $this->belongsTo(Student::class, 'student_id');
}


public function stkpushes()
{
    return $this->hasMany(Stkpush::class);
}








}
