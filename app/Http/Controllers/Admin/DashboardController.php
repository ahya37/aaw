<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Job;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;

class DashboardController extends Controller
{
    public function index()
    {
        
        $regency_id       = 3602;

        $userModel        = new User();
        $member           = $userModel->getMember($regency_id);   
        $total_member     = count($member); // total anggota terdaftar

        $districtModel    = new District();
        $target_member    = $districtModel->where('regency_id',$regency_id)->get()->count() * 1000; // target anggota tercapai, per kecamatan 1000 target
        $persentage_target_member = ($total_member / $target_member) * 100; // persentai terdata
        
        $villageModel   = new Village();
        $villages       = $villageModel->getVillages($regency_id); // fungsi total desa di kab.lebak
        $total_village  = count($villages);
        $village_filled = $villageModel->getVillageFilled($regency_id); //fungsi total desa yang terisi 
        $total_village_filled      = $village_filled->total_village; // total desa yang terisi
        $presentage_village_filled = ($total_village_filled / $total_village) * 100; // persentasi jumlah desa terisi

        // Grfaik Data member
        $districts = $districtModel->getGrafikTotalMemberDistrict($regency_id);
        $cat_districts      = [];
        $cat_districts_data = [];
        foreach ($districts as $val) {
            $cat_districts[] = $val->district; 
            $cat_districts_data[] = $val->total_member;
        }

        // grafik data job
        $jobModel = new Job();
        $jobs     = $jobModel->getJobRegency($regency_id);
        $cat_jobs =[];
        foreach ($jobs as  $val) {
            $cat_jobs[] = [
                "name" => $val->name,
                "y"    => $val->total_job
            ];
        }

        // grafik data jenis kelamin
        $gender = $userModel->getGender($regency_id);
        $cat_gender =[];

        foreach ($gender as  $val) {
            $cat_gender[] = [
                "name" => $val->gender == 0 ? 'Pria' : 'Wanita',
                "y"    => $val->total
            ];
        }
        // dd(json_encode($gender));
        $female = $userModel->getGenderFemale($regency_id);
        $gF   = app('GlobalProvider'); // global function
        return view('pages.admin.dashboard.index', compact('gender','cat_gender','female','cat_jobs','total_member','target_member','persentage_target_member','gF','total_village','total_village_filled','presentage_village_filled','cat_districts','cat_districts_data'));
    }
}
