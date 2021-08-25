<?php

namespace App;

use App\Models\Village;
use Illuminate\Support\Facades\DB;
use Alfa6661\AutoNumber\AutoNumberTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use AutoNumberTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $append  = ['saved_nasdem'];

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

    public function getSavedNasdemAttribute()
    {
        if ($this->saved_nasdem == 1) {
            return '<span class="badge badge-secondary"><i clas="fa fa-check"></i></span>';
        }elseif ($this->saved_nasdem == 2) {
            return '<span class="badge badge-danger"><i clas="fa fa-check"></i></span>';
        }else{
            
        }
    }

    public function getAutoNumberOptions()
    {
        return [
            'number' => [
                'length' => 7
            ]
        ];
    }

    

    public function village()
    {
        return $this->belongsTo(Village::class,'village_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class,'job_id');
    }

    public function education()
    {
        return $this->belongsTo(Education::class,'education_id');
    }

    public function reveral()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getMemberProvince($province_id)
    {
        $sql = "SELECT a.name
                from users as a 
                join villages as b on a.village_id = b.id 
                join districts as c on b.district_id = c.id
                join regencies as d on c.regency_id = d.id 
                WHERE  d.province_id = $province_id";
        return DB::select($sql);
    }

    public function getMemberRegency($regency_id)
    {
        $sql = "SELECT a.name
                from users as a 
                join villages as b on a.village_id = b.id 
                join districts as c on b.district_id = c.id 
                where c.regency_id = $regency_id";
        return DB::select($sql);
    }

    public function getMemberDistrict($district_id)
    {
        $sql = "SELECT a.name
                from users as a 
                join villages as b on a.village_id = b.id 
                join districts as c on b.district_id = c.id 
                where c.id = $district_id";
        return DB::select($sql);
    }

    public function getGenderRegency($regency_id)
    {
        $sql = "SELECT a.gender, count(a.id) as total
                from users as a 
                join villages as b on a.village_id = b.id 
                join districts as c on b.district_id = c.id 
                where c.regency_id = $regency_id  group by a.gender";
        return DB::select($sql);
    }

    public function getGenderProvince($regency_id)
    {
        $sql = "SELECT a.gender, count(a.id) as total
                from users as a 
                join villages as b on a.village_id = b.id 
                join districts as c on b.district_id = c.id 
                join regencies as d on c.regency_id = d.id
                where d.province_id = $regency_id  group by a.gender";
        return DB::select($sql);
    }

    public function getGenderDistrict($district_id)
    {
        $sql = "SELECT a.gender, count(a.id) as total
                from users as a 
                join villages as b on a.village_id = b.id
                where  b.district_id = $district_id  group by a.gender";
        return DB::select($sql);
    }

    public function getMemberByUser($id_user)
    {
        $result = DB::table('users as a')
                ->leftJoin('villages as b','a.village_id','=','b.id')
                ->leftJoin('districts as c','b.district_id','=','c.id')
                ->leftJoin('regencies as d','c.regency_id','=','d.id')
                ->select('a.*','b.name as village','c.name as district','d.name as regency')
                ->where('a.user_id', $id_user)
                ->whereNotIn('a.id', [$id_user])
                ->get();
        return $result;
    }
}
