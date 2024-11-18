<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function showPost()
    {
        $posts = Post::with(['listImages','location'])
            ->orderBy('created_at','desc')
            ->get();

        $user = Auth::user();

        return view('post',compact('posts','user'));

    }

    public function showIntroduce()
    {
        $user = Auth::user();
        return view('introduce',compact('user'));
    }

    public function showContact()
    {
        $user = Auth::user();
        return view('contact',compact('user'));
    }

    public function showHome()
    {
        return view('home');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegistrationForm(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('register');
    }

}
