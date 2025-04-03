<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
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




}
