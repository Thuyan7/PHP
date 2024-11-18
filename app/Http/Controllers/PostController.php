<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Location;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function create()
    {
        $amenities = Amenity::all();
        return view('create-post', compact('amenities'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'streetAddress' => 'required|string',
            'ward' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $post = Post::create([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'location_id' => $this->storeLocation($request),
            'user_id' => Auth::id(),
            'approved' => 0,
        ]);


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('posts', 'public');
                Image::create([
                    'url' => $path,
                    'post_id' => $post->id,
                ]);
            }
        }

        if ($request->has('amenities')) {
            $post->amenities()->sync($request->input('amenities'));
        }

        return redirect()->route('post.create')->with('success', 'Bài viết đã được đăng');
    }

    private function storeLocation($request)
    {

        $address = $request->input('streetAddress') . ', ' .
            $request->input('ward') . ', ' .
            $request->input('district') . ', ' .
            $request->input('city');


        $location = Location::create([
            'address' => $address,
        ]);

        return $location->id;
    }

    public function showDetailPost($id)
    {
        $post = Post::find($id);
        $posts = Post::all();
        $user = Auth::user();
        $comments = Comment::where('approved', 1)->get();
        $amenities = Amenity::all();
        return view('postdetail', compact('post','user','amenities','posts','comments'));
    }

}
