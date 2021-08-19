<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use AzisHapidin\IndoRegion\Traits\RegencyTrait;

/**
 * Regency Model.
 */
class Regency extends Model
{
    use RegencyTrait;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'regencies';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'province_id'
    ];

    /**
     * Regency belongs to Province.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Regency has many districts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function getRegencyProvince($province_id)
    {
        $sql = "SELECT COUNT(a.name) as total_village from villages as a
                join districts as b on a.district_id = b.id
                join regencies as c on b.regency_id = c.id 
                where c.province_id = $province_id";
        return collect(\DB::select($sql))->first();
    }

    public function getGrafikTotalMemberRegencyProvince($province_id)
    {
         $sql = "SELECT d.id  as regency_id, d.name as regency,
                count(a.name) as total_member
                from users as a 
                right join villages as b on a.village_id = b.id 
                right join districts as c on b.district_id = c.id
                right join regencies as d on c.regency_id = d.id
                where d.province_id = $province_id
                GROUP by d.id, d.name";
        return DB::select($sql);
    }
    
}