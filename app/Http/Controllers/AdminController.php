<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function home()
    {
        if(Auth::check()){
            $user = Auth::user();

            if($user->role_id ===2){
                return view('admin-home',['user'=>$user]);
            }else{
                return redirect()->route('login')->withErrors(['msg'=>'Unauthorized']);
            }
        }

        return redirect()->route('login');
    }
}
