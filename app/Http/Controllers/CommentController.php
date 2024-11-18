<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để bình luận.');
        }

        // Kiểm tra các dữ liệu gửi lên từ form
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'content' => 'required|string|max:255',
            'postId' => 'required|exists:posts,id',
        ]);

        // Tạo bình luận mới
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->rating = $request->input('rating');
        $comment->post_id = $request->input('postId');
        $comment->user_id = Auth::id();
        $comment->approved = false;


        $comment->save();
        return redirect()->route('post.detail', ['id' => $comment->post_id])
            ->with('success', 'Bình luận của bạn đã được gửi. Chờ duyệt.');
    }
}
