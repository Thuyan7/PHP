<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function home()
    {
        if(Auth::check()){
            $user = Auth::user();

            $posts = Post::with(['listImages','location'])
                ->orderBy('created_at','desc')
                ->get();

            if($user->role_id ===1){
                return view('user-home',['user'=>$user],compact('posts'));
            }else{
                return redirect()->route('login')->withErrors(['msg'=>'Unauthorized access']);
            }
        }

        return redirect()->route('login');
    }
}
