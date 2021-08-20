<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

namespace App\Models;

use AzisHapidin\IndoRegion\Traits\DistrictTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Support\Facades\DB;
/**
 * District Model.
 */
class District extends Model
{
    use DistrictTrait;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'districts';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'regency_id'
    ];

    /**
     * District belongs to Regency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    /**
     * District has many villages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function villages()
    {
        return $this->hasMany(Village::class);
    }

    public function getGrafikTotalMemberDistrictRegency($regency_id)
    {
        $sql = "SELECT c.id as distric_id, c.name as district,
                count(a.name) as total_member
                from users as a 
                right join villages as b on a.village_id = b.id 
                right join districts as c on b.district_id = c.id 
                where c.regency_id = $regency_id
                GROUP by  c.name, c.id";
        return DB::select($sql);
    }

    public function getGrafikTotalMemberDistrict($district_id)
    {
        $sql = "SELECT b.id as distric_id, b.name as district,
                count(a.name) as total_member
                from users as a 
                right join villages as b on a.village_id = b.id 
                right join districts as c on b.district_id = c.id 
                where c.id = $district_id
                GROUP by  b.name, b.id";
        return DB::select($sql);
    }
}
