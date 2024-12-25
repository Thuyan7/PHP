<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function home()
    {
        if(Auth::check()){
            $user = Auth::user();

            $posts = Post::with(['listImages','location'])
                ->where('approved', 1)
                ->orderBy('created_at','desc')
                ->get();

            $comments = Comment::all();

            if($user->role_id ===1){
                return view('user-home',['user'=>$user],compact('posts','comments'));
            }else{
                return redirect()->route('login')->withErrors(['msg'=>'Unauthorized access']);
            }
        }

        return redirect()->route('login');
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
        $posts = Post::with(['listImages', 'location'])
            ->where('approved', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        $comments = Comment::all();
        return view('home',compact('posts','comments'));
    }


    public function showProfilePage()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->get();
        $comments = Comment::where('user_id', $user->id)->get();
        return view('profile', compact('user', 'posts', 'comments'));
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
        ]);


        $user->update([
            'full_name'=> $request->input('full_name'),
            'phone'=> $request->input('phone'),
        ]);

        return redirect()->route('user.profile')->with('success', 'Cập nhật thông tin thành công.');
    }

    public function showUpdatePostForm($id)
    {
        $user = Auth::user();
        $post = Post::with('amenities', 'location','listImages')->findOrFail($id);
        $amenities = Amenity::all();

        return view('update-post',compact('post','amenities','user'));
    }

    public function updatePost(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string|max:255',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
        ], [
                'title.required' => 'Vui lòng nhập tiêu đề.',
                'title.string' => 'Tiêu đề phải là một chuỗi ký tự.',
                'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
                'price.required' => 'Vui lòng nhập giá.',
                'price.numeric' => 'Giá phải là một số.',
                'description.required' => 'Vui lòng nhập mô tả.',
                'address.required'=>'Vui lòng nhập địa chỉ',
                'images.*.image' => 'Tệp tải lên phải là hình ảnh.',
                'images.required' => 'Phải tải lên ít nhất một ảnh.',
        ]);


        $post->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price'=> $request->input('price'),
        ]);

        $post->location()->update([
            'address' => $request->input('address')
        ]);


        if ($request->hasFile('images')) {
            foreach ($post->images as $image) {
                Storage::disk('public')->delete($image->url);
                $image->delete();
            }
            foreach ($request->file('images') as $image) {
                $path = $image->store('posts', 'public');
                Image::create([
                    'url' => $path,
                    'post_id' => $post->id,
                ]);
            }
        }
        $post->amenities()->sync($request->input('amenities', []));

        return redirect()->route('user.profile', ['id' => $post->id])->with('success', 'Cập nhật bài đăng thành công.');

    }

    public function deletePost($id)
    {
        $post = Post::find($id);
        $post->comments()->delete();
        $post->delete();
        return redirect()->route('user.profile')->with('success', 'Bài đăng đã được xóa thành công.');
    }



}
