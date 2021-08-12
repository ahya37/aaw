<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user    = $userModel->select('nik')->where('id', $id_user)->first();
        if ($user->nik == null) {
            return redirect()->route('user-create-profile');
        }

        $profile = $userModel->with(['village','education'])->where('id', $id_user)->first();
        $member  = $userModel->with(['village','education'])->where('user_id', $id_user)->whereNotIn('id', [$id_user])->get();
        $total_member = count($member);
        return view('home', compact('profile','member','total_member'));
    }
}
