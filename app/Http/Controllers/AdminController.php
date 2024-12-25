<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
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

            if($user->role_id ===2){
                return view('admin-home',['user'=>$user], compact('posts','comments'));
            }else{
                return redirect()->route('login')->withErrors(['msg'=>'Unauthorized']);
            }
        }

        return redirect()->route('login');
    }

    public function showUserManagementPage()
    {
        $user = Auth::user();
        $users = User::with(['posts', 'comments'])
            ->where('role_id',1)
            ->get();
        return view('user-management',compact('users','user'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        $user->posts()->delete();
        $user->comments()->delete();

        $user->delete();
        return redirect()->route('user.management');
    }

    public function showPostManagementPage()
    {
        $user = Auth::user();
        $posts = Post::with('user','comments')->get();
        return view('post-management', compact('posts', 'user'));
    }


    public function showCommentManagementPage()
    {
        $user = Auth::user();
        $comments = Comment::with('user','post')->get();
        return view('comment-management',compact('comments','user'));
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->route('comment.management');
    }

    public function showProfileAdmin()
    {
        $user = Auth::user();

        $totalPost = Post::count();
        $totalPostApprovedTrue = Post::where('approved', true)->count();
        $totalPostApprovedFalse = Post::where('approved', false)->count();

        $totalComment = Comment::count();

        $totalUser = User::count();

        return view('admin-profile', compact(
            'user',
            'totalPost',
            'totalPostApprovedTrue',
            'totalPostApprovedFalse',
            'totalComment',
            'totalUser'
        ));
    }


    public function updateProfileAdmin(Request $request): \Illuminate\Http\RedirectResponse
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

        return redirect()->route('admin.profile')->with('success', 'Cập nhật thông tin thành công.');
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('post.management');
    }

    public function updateStatusPost(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $approved = $request->input('approved') === 'true';
        $post->update([
            'approved' => $approved,
        ]);
        return redirect()->back()->with('success', 'Trạng thái bài viết đã được cập nhật.');
    }


}
