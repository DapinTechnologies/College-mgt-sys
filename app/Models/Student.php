<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use App\Notifications\ContentNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Student extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function studentEnrolls()
    {
        return $this->hasMany(StudentEnroll::class, 'student_id');
    }

    public function currentEnroll()
    {
        return $this->hasOne(StudentEnroll::class, 'student_id')->ofMany([
            'id' => 'max',
        ], function ($query) {
            $query->where('status', '1');
        });
    }

    public function firstEnroll()
    {
        // return $this->hasOne(StudentEnroll::class, 'student_id')->oldest();
        return $this->hasOne(StudentEnroll::class, 'student_id')->ofMany([
            'id' => 'min',
        ]);
    }

    public function lastEnroll()
    {
        // return $this->hasOne(StudentEnroll::class, 'student_id')->latest();
        return $this->hasOne(StudentEnroll::class, 'student_id')->ofMany([
            'id' => 'max',
        ]);
    }

    public function relatives()
    {
        return $this->hasMany(StudentRelative::class, 'student_id', 'id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'student_id', 'id');
    }

    public function leaves()
    {
        return $this->hasMany(StudentLeave::class, 'student_id', 'id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'student_id', 'id');
    }

    public function presentProvince()
    {
        return $this->belongsTo(Province::class, 'present_province');
    }

    public function presentDistrict()
    {
        return $this->belongsTo(District::class, 'present_district');
    }

    public function permanentProvince()
    {
        return $this->belongsTo(Province::class, 'permanent_province');
    }

    public function permanentDistrict()
    {
        return $this->belongsTo(District::class, 'permanent_district');
    }

    public function statuses()
    {
        return $this->belongsToMany(StatusType::class, 'status_type_student', 'student_id', 'status_type_id');
    }

    public function studentTransfer()
    {
        return $this->hasOne(StudentTransfer::class, 'student_id');
    }

    public function transferCreadits()
    {
        return $this->hasMany(TransferCreadit::class, 'student_id');
    }
    

    // Polymorphic relations
    public function documents()
    {
        return $this->morphToMany(Document::class, 'docable');
    }

    public function contents()
    {
        return $this->morphToMany(Content::class, 'contentable');
    }

    public function notices()
    {
        return $this->morphToMany(Notice::class, 'noticeable');
    }

    public function member()
    {
        return $this->morphOne(LibraryMember::class, 'memberable');
    }

    public function hostelRoom()
    {
        return $this->morphOne(HostelMember::class, 'hostelable');
    }

    public function transport()
    {
        return $this->morphOne(TransportMember::class, 'transportable');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    // Get Current Enroll
    public static function enroll($id)
    {
        $enroll = StudentEnroll::where('student_id', $id)
                                ->where('status', '1')
                                ->orderBy('id', 'desc')
                                ->first();

        return $enroll;
    }


    public function mpesaTransactions()
{
    return $this->hasMany(MpesaTransaction::class);
}


public function county()
{
    return $this->belongsTo(County::class, 'county_id'); // Assuming 'county_id' is the foreign key
}

public function subCounty()
{
return $this->belongsTo(SubCounty::class, 'sub_county_id'); // Assuming 'sub_county_id' is the foreign key
}



// Relationship to SubCounty
public function sub_county()
{
return $this->belongsTo(SubCounty::class, 'sub_county_id', 'SubCountyID');
}

public function enrollments()
{
    return $this->hasMany(StudentEnroll::class, 'student_id');
}


}
