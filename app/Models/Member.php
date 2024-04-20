<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_UNAPPROVED = 0;

    const STATUS_ACTIVE = 1;

    const STATUS_NONACTIVE = -1;

    const ARR_STATUS = [
        0 => 'Unapproved',
        1 => 'Active',
        -1 => 'Non Active',
    ];

    const ARR_MARITAL_STATUS = [
        'S' => 'Single',
        'M' => 'Married',
        'J' => 'Widdow',
        'D' => 'Widdower',
    ];

    const ARR_GENDER_TYPE = [
        "F" => "Female",
        "M" => "Male"
    ];

    protected $guarded = ["id", "created_at", "updated_at"];


    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class, "family_id");
    }

    public function familyMember(): HasMany
    {
        return $this->hasMany(Member::class, "family_id", "family_id")
            ->where("id", "!=", $this->id);
    }

    public function churchGroups(): BelongsToMany
    {
        return $this->belongsToMany(ChurchGroup::class, "member_church_group", "member_id", "church_group_id");
    }

    public function baptism(): HasOne
    {
        return $this->hasOne(Baptism::class, "member_id");
    }

    public function mortality(): HasOne
    {
        return $this->hasOne(Mortality::class, "member_id");
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->age;
    }

    public function getFrontTitleAttribute()
    {
        if ($this->age <= 11) {
            return 'Adik';
        }

        if ($this->marital_status == 'S') {
            return ($this->gender == 'M')
                ? "Sdr."
                : "Sdri.";
        }

        return ($this->sex == 'L')
            ? "Bpk."
            : "Ibu";
    }

    public function getBirthMonthDayAttribute()
    {
        return Carbon::parse($this->birth_date)->format('m-d'); // Format as 'month-day'
    }
}
