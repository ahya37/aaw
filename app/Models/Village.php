<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

namespace App\Models;

use AzisHapidin\IndoRegion\Traits\VillageTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
use Illuminate\Support\Facades\DB;
/**
 * Village Model.
 */
class Village extends Model
{
    use VillageTrait;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'villages';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'district_id'
    ];

	/**
     * Village belongs to District.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function getVillages($regency_id)
    {
        $sql = "SELECT a.name as village from villages as a
                join districts as b on a.district_id = b.id
                join regencies as c on b.regency_id = c.id
                where c.id = $regency_id";
        return DB::select($sql);
    }

    public function getVillageFilled($regency_id)
    {
        $sql = "SELECT COUNT(a.village_id) as total_village FROM  users as a
                join villages as b on a.village_id = b.id 
                join districts as c on b.district_id = c.id
                where c.regency_id = $regency_id";
        return collect(\DB::select($sql))->first();
    }
}
