<?php

namespace App\Http\Controllers\Admin;

use App\Charts\InputerChart;
use App\Job;
use App\User;
use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use PDF;
use Maatwebsite\Excel\Excel;
use App\Exports\MemberExportRegency;
use App\Http\Controllers\Controller;
use App\Exports\MemberExportDistrict;
use App\Exports\MemberExportProvince;
use App\Referal;
use Yajra\DataTables\Facades\DataTables;
use App\Charts\JobChart;
use App\Charts\MemberVsTargetChart;

class DashboardController extends Controller
{
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }
    public function index()
    {
        $province_id = 36;
        $gF   = app('GlobalProvider'); // global function

        $userModel        = new User();
        $member           = $userModel->getMemberProvince($province_id);
        $total_member     = count($member); // total anggota terdaftar

        $regencyModel     = new Regency();
        $target_member    = $regencyModel->getRegencyProvince($province_id)->total_district * 5000;
        $persentage_target_member = ($total_member / $target_member) * 100; // persentai terdata

        $villageModel   = new Village();
        $total_village  = $villageModel->getVillagesProvince($province_id)->total_village; // fungsi total desa di provinsi banten
        $village_filled = $villageModel->getVillageFillProvince($province_id); // fungsi total desa di provinsi banten
        $total_village_filled      = count($village_filled);
        $presentage_village_filled = ($total_village_filled / $total_village) * 100; // persentasi jumlah desa terisi

        // Grfaik Data member
        $regency = $regencyModel->getGrafikTotalMemberRegencyProvince($province_id);
        // dd($regency);
        $cat_regency      = [];
        $cat_regency_data = [];
        foreach ($regency as $val) {
            $cat_regency[] = $val->regency; 
            $cat_regency_data[] = [
                "y" => $val->total_member,
                "url" => route('admin-dashboard-regency', $val->regency_id)
            ];
        }
        
        // grafik data anggota terdaftar vs target
        $member_registered  = $userModel->getMemberRegistered($province_id);
        $cat_member_registered = [];
        foreach($member_registered as $val){
            $cat_member_registered['label'][] = $val->name;
            $cat_member_registered['data'][]  = $gF->persen(($val->realisasi_member / $val->target_member)*100);
        }
        $data_cat_member_registered = collect($cat_member_registered);
        $label_member_registered    = collect($cat_member_registered['label']);
        $data_member_registered     = $cat_member_registered['data'];
        $colors           = $label_member_registered->map(function($item){return $rand_color = '#' . substr(md5(mt_rand()),0,6);});
        $chart_member_registered    = new MemberVsTargetChart();
        $chart_member_registered->labels($label_member_registered);
        $chart_member_registered->dataset('Persen','bar', $data_member_registered)->backgroundColor($colors);
        $chart_member_registered->options([
                'legend' => false,
                'title' => [
                    'display' => true,
                ]
            ]);

        // grafik data job
        $jobModel = new Job();
        $most_jobs = $jobModel->getMostJobsProvince($province_id);
        $jobs     = $jobModel->getJobProvince($province_id);
        $cat_jobs =[];
        $sum_jobs = collect($jobs)->sum(function($q){return $q->total_job; }); // fungsi untuk menjumlahkan total job
        foreach ($jobs as  $val) {
            $cat_jobs['label'][] = $val->name;
            $cat_jobs['data'][] = $gF->persen(($val->total_job / $sum_jobs)*100);
        }

        $data_cat_jobs = collect($cat_jobs);
        $labels_jobs = collect($cat_jobs['label']);
        $data_jobs   = $cat_jobs['data'];
        $colors = $labels_jobs->map(function($item){
            return $rand_color = '#' . substr(md5(mt_rand()),0,6);
        });
        $chart_jobs = new JobChart();
        $chart_jobs->labels($labels_jobs);
        $chart_jobs->dataset('Anggota Berdasarkan Pekerjaan','pie', $data_jobs)->backgroundColor($colors);
        $chart_jobs->options([
            'tooltip' => false,
            'legend' => [
                'position' => 'right',
                'display' => true,
            ],
            'title' => [
                'display' => true,
                ]
            ]);

        // grafik data jenis kelamin
        $gender = $userModel->getGenderProvince($province_id);
        $cat_gender = [];
        $all_gender  = [];

        // untuk menghitung jumlah keseluruhan jenis kelamin L/P
        $total_gender = 0;
        foreach ($gender as $key => $value) {
            $total_gender += $value->total;
        }

        foreach ($gender as  $val) {
            $all_gender[]  = $val->total;

            $cat_gender[] = [
                "label" => $val->gender == 0 ? 'Laki-laki' : 'Perempuan',
                "value"    => $gF->persen(($val->total/$total_gender)*100),
            ];
        }
        
        $total_male_gender   =empty($all_gender[0]) ?  0 :  $all_gender[0];; // total gender pria
        $total_female_gender = empty($all_gender[1]) ?  0 :  $all_gender[1]; // total gender wanita

        // range umur
        $range_age     = $userModel->rangeAgeProvince($province_id);
        $cat_range_age = [];
        $cat_range_age_data = [];
        foreach ($range_age as $val) {
            $cat_range_age[]      = $val->range_age;
            $cat_range_age_data[] = [
                'y'    => $val->total
            ];
        }

        // generasi umur
        $gen_age     = $userModel->generationAgeProvince($province_id);
        $cat_gen_age = [];
        $cat_gen_age_data = [];
        foreach ($gen_age as $val) {
            if (isset($val->gen_age) != null) {
                # code...
                $cat_gen_age[]      = $val->gen_age;
                $cat_gen_age_data[] = [
                    'y'    => $val->total
                ];
            }
        }

        // Daftar pencapaian lokasi / daerah
        $achievments   = $regencyModel->achievementProvince($province_id);
        if (request()->ajax()) {
            return DataTables::of($achievments)
                    ->addColumn('persentage', function($item){
                        $gF   = app('GlobalProvider'); // global function
                        $persentage = ($item->realisasi_member / $item->target_member)*100;
                        $persentage = $gF->persen($persentage);
                        $persentageWidth = $persentage + 30;
                        return '
                        <div class="mt-3 progress" style="width:100%;">
                            <span class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: '.$persentageWidth.'%" aria-valuenow="'.$persentage.'" aria-valuemin="'.$persentage.'" aria-valuemax="'.$persentage.'"><strong>'.$persentage.'%</strong></span>
                        </div>
                        ';
                    })
                    ->rawColumns(['persentage'])
                    ->make();
        }

        $referalModel = new Referal();
        // input admin terbanyak
        $inputer      = $referalModel->getInputerProvince($province_id);
        $cat_inputer = [];
        foreach($inputer as $val){
            $cat_inputer['label'][] = $val->name;
            $cat_inputer['data'][]  = $val->total_data;
        }
        $data_cat_inputer = collect($cat_inputer);
        $label_inputer    = collect($cat_inputer['label']);
        $data_inputer     = $cat_inputer['data'];
        $colors           = $label_inputer->map(function($item){return $rand_color = '#' . substr(md5(mt_rand()),0,6);});
        $chart_inputer    = new InputerChart();
        $chart_inputer->labels($label_inputer);
        $chart_inputer->dataset('Jumlah','bar', $data_inputer)->backgroundColor($colors);
        $chart_inputer->options([
            'legend' => false,
            'title' => [
                'display' => true,
                // 'text' => 'Admin Dengan Input Terbanyak'
            ]
            ]);
        // anggota dengan referal terbanyak
        $referal      = $referalModel->getReferalProvince($province_id);
        $cat_referal      = [];
        $cat_referal_data = [];
        foreach ($referal as $val) {
            $cat_referal[] = $val->name; 
            $cat_referal_data[] = [
                "y" => $val->total_referal,
                "url" => route('admin-dashboard')
            ];
        }

        return view('pages.admin.dashboard.index', compact('chart_member_registered','cat_gen_age_data','cat_gen_age','chart_inputer','most_jobs','colors','chart_jobs','cat_referal_data','cat_referal','cat_range_age','cat_range_age_data','total_male_gender','total_female_gender','regency','cat_gender','cat_jobs','cat_regency_data','cat_regency','gF','total_member','persentage_target_member','target_member','total_village_filled','presentage_village_filled','total_village'));
    }

    public function regency($regency_id)
    {
        $regency          = Regency::select('id','name')->where('id', $regency_id)->first();
        $userModel        = new User();
        $member           = $userModel->getMemberRegency($regency_id);   
        $total_member     = count($member); // total anggota terdaftar

        $districtModel    = new District();
        $target_member    = $districtModel->where('regency_id',$regency_id)->get()->count() * 5000; // target anggota tercapai, per kecamatan 1000 target
        $persentage_target_member = ($total_member / $target_member) * 100; // persentai terdata
        
        $villageModel   = new Village();
        $villages       = $villageModel->getVillagesRegency($regency_id); // fungsi total desa di kab
        $total_village  = count($villages);
        $village_filled = $villageModel->getVillageFilledRegency($regency_id); //fungsi total desa yang terisi 
        $total_village_filled      = count($village_filled); // total desa yang terisi
        $presentage_village_filled = ($total_village_filled / $total_village) * 100; // persentasi jumlah desa terisi

        // Grfaik Data member
        $districts = $districtModel->getGrafikTotalMemberDistrictRegency($regency_id);
        $cat_districts      = [];
        $cat_districts_data = [];
        foreach ($districts as $val) {
            $cat_districts[] = $val->district; 
            $cat_districts_data[] = [
                "y" => $val->total_member,
                "url" => route('admin-dashboard-district', $val->distric_id)
            ];
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
        $gender = $userModel->getGenderRegency($regency_id);
        $cat_gender =[];
        $all_gender = [];

        // untuk menghitung jumlah keseluruhan jenis kelamin L/P
        $total_gender = 0;
        foreach ($gender as $key => $value) {
            $total_gender += $value->total;
        }

        foreach ($gender as  $val) {
            $all_gender[]  = $val->total;
            $cat_gender[] = [
                "name" => $val->gender == 0 ? 'Pria' : 'Wanita',
                "y"    => ($val->total/$total_gender)*100
            ];
        }

        $total_male_gender   =empty($all_gender[0]) ?  0 :  $all_gender[0];; // total gender pria
        $total_female_gender = empty($all_gender[1]) ?  0 :  $all_gender[1]; // total gender wanita

        // range umur
        $range_age     = $userModel->rangeAgeRegency($regency_id);
        $cat_range_age = [];
        $cat_range_age_data = [];
        foreach ($range_age as $val) {
            $cat_range_age[]      = $val->range_age;
            $cat_range_age_data[] = [
                'y'    => $val->total
            ];
        }

        $gF   = app('GlobalProvider'); // global function

        // Daftar pencapaian lokasi / daerah
        $achievments   = $districtModel->achievementDistrict($regency_id);
        if (request()->ajax()) {
            return DataTables::of($achievments)
                    ->addColumn('persentage', function($item){
                        $gF   = app('GlobalProvider'); // global function
                        $persentage = ($item->realisasi_member / $item->total_target_member)*100;
                        $persentage = $gF->persen($persentage);
                        $persentageWidth = $persentage + 30;
                        return '
                        <div class="mt-3 progress" style="width:100%;">
                            <span class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: '.$persentageWidth.'%" aria-valuenow="'.$persentage.'" aria-valuemin="'.$persentage.'" aria-valuemax="'.$persentage.'"><strong>'.$persentage.'%</strong></span>
                        </div>
                        ';
                    })
                    ->rawColumns(['persentage'])
                    ->make();
        }

         // anggota dengan referal terbanyak
        $referalModel = new Referal();
        $referal      = $referalModel->getReferalRegency($regency_id);
        $cat_referal      = [];
        $cat_referal_data = [];
        foreach ($referal as $val) {
            $cat_referal[] = $val->name; 
            $cat_referal_data[] = [
                "y" => $val->total_referal,
                "url" => route('admin-dashboard')
            ];
        }

        return view('pages.admin.dashboard.regency', compact('cat_referal_data','cat_referal','cat_range_age_data','cat_range_age','total_male_gender','total_female_gender','regency','gender','cat_gender','cat_jobs','total_member','target_member','persentage_target_member','gF','total_village','total_village_filled','presentage_village_filled','cat_districts','cat_districts_data'));
    }

    public function district($district_id)
    {
        $district   = District::with(['regency'])->where('id', $district_id)->first();
        // jumlah anggota di kecamatan
        $userModel  = new User();
        $member     = $userModel->getMemberDistrict($district_id);
        $total_member = count($member);

        // perentasi anggot  di kecamatan
        $districtModel    = new District();
        $target_member    = $districtModel->where('id',$district_id)->get()->count() * 5000; // target anggota tercapai, per kecamatan 1000 target
        $persentage_target_member = ($total_member / $target_member) * 100; // persentai terdata

        $villageModel   = new Village();
        $villages       = $villageModel->getVillagesDistrct($district_id); // fungsi total desa di kab
        $total_village  = count($villages);

        $village_filled = $villageModel->getVillageFilledDistrict($district_id); //fungsi total desa yang terisi 
        $total_village_filled      = count($village_filled); // total desa yang terisi
        $presentage_village_filled = ($total_village_filled / $total_village) * 100; // persentasi jumlah desa terisi

        // Grfaik Data member
        $districts = $districtModel->getGrafikTotalMemberDistrict($district_id);
        $cat_districts      = [];
        $cat_districts_data = [];
        foreach ($districts as $val) {
            $cat_districts[] = $val->district; 
            $cat_districts_data[] = [
                "y" => $val->total_member,
                "url" => route('admin-dashboard-district', $val->distric_id)
            ];
        }

        // grafik data job
        $jobModel = new Job();
        $jobs     = $jobModel->getJobDistrict($district_id);
        $cat_jobs =[];
        foreach ($jobs as  $val) {
            $cat_jobs[] = [
                "name" => $val->name,
                "y"    => $val->total_job
            ];
        }
        
        // grafik data jenis kelamin
        $gender = $userModel->getGenderDistrict($district_id);
        $cat_gender =[];
        $all_gender = [];

        // untuk menghitung jumlah keseluruhan jenis kelamin L/P
        $total_gender = 0;
        foreach ($gender as $key => $value) {
            $total_gender += $value->total;
        }
        
        foreach ($gender as  $val) {
            $all_gender[]  = $val->total;
            $cat_gender[] = [
                "name" => $val->gender == 0 ? 'Pria' : 'Wanita',
                "y"    => ($val->total/$total_gender)*100
            ];
        }

        $total_male_gender   =empty($all_gender[0]) ?  0 :  $all_gender[0];; // total gender pria
        $total_female_gender = empty($all_gender[1]) ?  0 :  $all_gender[1]; // total gender wanita
        
        // range umur
        $range_age     = $userModel->rangeAgeDistrict($district_id);
        $cat_range_age = [];
        $cat_range_age_data = [];
        foreach ($range_age as $val) {
            $cat_range_age[]      = $val->range_age;
            $cat_range_age_data[] = [
                'y'    => $val->total
            ];
        }

        $gF   = app('GlobalProvider'); // global function

         // Daftar pencapaian lokasi / daerah
        $achievments   = $villageModel->achievementVillage($district_id);
        if (request()->ajax()) {
            return DataTables::of($achievments)->make();
        }

        // anggota dengan referal terbanyak
        $referalModel = new Referal();
        $referal      = $referalModel->getReferalDistrict($district_id);
        $cat_referal      = [];
        $cat_referal_data = [];
        foreach ($referal as $val) {
            $cat_referal[] = $val->name; 
            $cat_referal_data[] = [
                "y" => $val->total_referal
            ];
        }
        return view('pages.admin.dashboard.district', compact('cat_referal_data','cat_referal','cat_range_age_data','cat_range_age','total_male_gender','total_female_gender','cat_gender','cat_jobs','cat_districts','cat_districts_data','total_village_filled','presentage_village_filled','total_village','target_member','persentage_target_member','district','gF','total_member'));
    }

    public function exportDataProvinceExcel()
    {
      $province_id  = 36;
      $province     = Province::select('name')->where('id', $province_id)->first();
      return $this->excel->download(new MemberExportProvince($province_id),'Anggota-'.$province->name.'.xls');
    }

    public function exportDataRegencyExcel($regency_id)
    {
      $regency  = Regency::select('name')->where('id', $regency_id)->first();
      return $this->excel->download(new MemberExportRegency($regency_id),'Anggota-'.$regency->name.'.xls');
    }

    public function exportDataDistrictExcel($district_id)
    {
      $district = District::select('name')->where('id', $district_id)->first();
      return $this->excel->download(new MemberExportDistrict($district_id),'Anggota-'.$district->name.'.xls');
    }

    public function downloadKTA($id)
    {
        $profile = User::with(['village'])->where('id', $id)->first();
        $pdf = PDF::loadView('pages.admin.member.card', compact('profile'))->setPaper('a4');
        return $pdf->stream('kta.pdf');

    }
}
