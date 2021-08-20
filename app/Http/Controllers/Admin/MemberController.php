<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class MemberController extends Controller
{
    public function index()
    {
        $member = User::with(['village','reveral'])
                    ->whereNotNull('nik')
                    // ->whereNotIn('level',[1])
                    ->orderBy('created_at','DESC')->get();
        return view('pages.admin.member.index', compact('member'));
    }

    public function profileMember($id)
    {
        $id_user = decrypt($id);
        $userModel = new User();
        $profile = $userModel->with(['village'])->where('id', $id_user)->first();
        $member  = $userModel->with(['village','reveral'])->where('user_id', $id_user)->whereNotIn('id', [$id_user])->get();
        $total_member = count($member);
        return view('pages.admin.member.profile', compact('profile','member','total_member'));


    }
}
