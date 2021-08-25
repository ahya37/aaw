<?php

namespace App\Http\Controllers;

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
        $member  = $userModel->with(['village.district.regency','education'])->where('user_id', $id_user)->whereNotIn('id', [$id_user])->get();
        if (request()->ajax()) 
        {
            return DataTables::of($member)
                    ->addColumn('action', function($item){
                        return '
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-sc-primary text-white dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">...</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="">
                                           Tandai Tersimpan di Nasdem
                                        </a>
                                        <form action="" method="POST">
                                            '. method_field('delete') . csrf_field() .'
                                            <button type="submit" class="dropdown-item text-danger">
                                                Sudah Terdaftar di Nasdem
                                            </button>
                                        </form>
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
                    ->rawColumns(['action','photo'])
                    ->make();
        }
        $total_member = count($member);
        return view('home', compact('profile','member','total_member'));
    }
}
