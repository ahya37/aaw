<?php

namespace App\Http\Controllers;

use App\Providers\GlobalProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        #jika data profil belum dilengkapi
        $id_user   = Auth::user()->id;
        $userModel = new User();
        $user    = $userModel->with(['reveral'])->select('nik','user_id')->where('id', $id_user)->first();

        // jika user_id null,  atau belum konek ke reveral
        if ($user->user_id == null) {
            return redirect()->route('user-create-reveral');
        }
        
        if ($user->nik == null) {
            # code...
            return redirect()->route('user-create-profile');
        }

        $profile = $userModel->with(['village','education'])->where('id', $id_user)->first();
        $member = $userModel->getDataByTotalReferalDirect($id_user); // berfungsi juga untuk menampilkan data total referal

          // referal
        $referal_undirect = $userModel->getReferalUnDirect($id_user);
        $referal_undirect = $referal_undirect->total == NULL ? 0 : $referal_undirect->total;
        $referal_direct = $userModel->getReferalDirect($id_user);
        $referal_direct = $referal_direct->total == NULL ? 0 : $referal_direct->total; 
        $total_referal = $referal_direct + $referal_undirect;

        if (request()->ajax()) 
        {
            return DataTables::of($member)
                    ->addColumn('action', function($item){
                        return '
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-sc-primary text-white dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">...</button>
                                    <div class="dropdown-menu">
                                         <button type="button" class="dropdown-item" onclick="saved('.$item->id.')" id="'.$item->id.'" member="'.$item->name.'">
                                                Sudah Tersimpan di Nasdem
                                            </button>
                                            <button type="button" class="dropdown-item text-danger" onclick="registered('.$item->id.')" id="'.$item->id.'" member="'.$item->name.'">
                                                Sudah Terdaftar di Nasdem
                                            </button>
                                    </div>
                                </div>
                            </div>
                        ';
                    })
                    ->addColumn('photo', function($item){
                        return '
                        <a href="'.route('member-mymember', encrypt($item->id)).'">
                            <img  class="rounded" width="40" src="'.asset('storage/'.$item->photo).'">
                            '.$item->name.'
                        </a>
                        ';
                    })
                    ->addColumn('referal', function($item){
                        return $item->referal;
                    })
                    // ->addColumn('saved_nasdem', function($item){
                    //    if ($item->saved_nasdem == 1) {
                    //        return '<img src="'.asset('assets/images/check-saved.svg').'">';
                    //    }elseif ($item->saved_nasdem == 2) {
                    //        return '<img src="'.asset('assets/images/check-registered.svg').'">';
                    //    }else{

                    //    }
                    // })
                    ->rawColumns(['action','photo','saved_nasdem','referal'])
                    ->make();
        }

        $gF = new GlobalProvider();
        
        return view('home', compact('gF','profile','member','total_referal','referal_undirect','referal_direct'));
    }
}
