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

    public function getAutoNumberOptions()
    {
        return [
            'number' => [
                'length' => 8
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

    public function getMember($regency_id)
    {
        $sql = "SELECT a.name
                from users as a 
                join villages as b on a.village_id = b.id 
                join districts as c on b.district_id = c.id 
                where c.regency_id = $regency_id";
        return DB::select($sql);
    }

    public function getGender($regency_id)
    {
        $sql = "SELECT a.gender, count(a.id) as total
                from users as a 
                join villages as b on a.village_id = b.id 
                join districts as c on b.district_id = c.id 
                where c.regency_id = $regency_id  group by a.gender";
        return DB::select($sql);
    }

    public function getGenderFemale($regency_id)
    {
        $sql = "SELECT count(a.id) as female
                from users as a 
                join villages as b on a.village_id = b.id 
                join districts as c on b.district_id = c.id 
                where c.regency_id = $regency_id and a.gender = 1  group by a.gender";
        return collect(\DB::select($sql))->first();

    }
}
