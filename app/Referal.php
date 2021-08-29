<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Referal extends Model
{
    public function getReferalProvince($province_id)
    {
        $sql = "SELECT b.id, b.name , count(b.id) as total_referal
                from users as a
                join users as b on a.user_id = b.id
                left join villages as c on b.village_id = c.id
                left join districts as   d on c.district_id = d.id 
                left join regencies as e on d.regency_id = e.id
                where e.province_id = 36 
                and  not b.`level` = $province_id
                group by b.name, b.id
                limit 10";
        return DB::select($sql);
    }

    public function getReferalRegency($regency_id)
    {
        $sql = "SELECT b.id, b.name , count(b.id) as total_referal
                from users as a
                join users as b on a.user_id = b.id
                left join villages as c on b.village_id = c.id
                left join districts as d on c.district_id = d.id 
                where d.regency_id = $regency_id
                and  not b.`level` = 1 
                group by b.name, b.id 
                limit 10";
        return DB::select($sql);
    }

    public function getReferalDistrict($district_id)
    {
        $sql = "SELECT b.id, b.name , count(b.id) as total_referal
                from users as a
                join users as b on a.user_id = b.id
                left join villages as c on b.village_id = c.id
                where c.district_id = $district_id
                and  not b.`level` = 1 
                group by b.name, b.id 
                limit 10";
        return DB::select($sql);
    }
}