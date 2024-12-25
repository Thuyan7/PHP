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
        $user = Auth::user();
        $amenities = Amenity::all();
        return view('create-post', compact('amenities','user'));
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
            'images' => 'required|min:1|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.string' => 'Tiêu đề phải là một chuỗi ký tự.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'price.required' => 'Vui lòng nhập giá.',
            'price.numeric' => 'Giá phải là một số.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'streetAddress.required' => 'Vui lòng nhập địa chỉ chi tiết.',
            'ward.required' => 'Vui lòng nhập phường/xã.',
            'district.required' => 'Vui lòng nhập quận/huyện.',
            'city.required' => 'Vui lòng nhập tỉnh/thành phố.',
            'images.*.image' => 'Tệp tải lên phải là hình ảnh.',
            'images.required' => 'Phải tải lên ít nhất một ảnh.',
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

    public function showPost()
    {
        $posts = Post::with(['listImages', 'location'])
            ->where('approved', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        $user = Auth::user();

        return view('post', compact('posts', 'user'));
    }

    public function showDetailPost($id)
    {
        $post = Post::find($id);
        $posts = Post::with(['listImages', 'location'])
            ->where('approved', 1)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        $user = Auth::user();
        $comments = Comment::where('post_id',$id)->get();
        $amenities = Amenity::all();
        return view('postdetail', compact('post','user','amenities','posts','comments'));
    }

    public function search(Request $request)
    {
        $address = $request->input('address');
        $priceRange = $request->input('priceRange');

        if (!$address && !$priceRange) {
            return redirect()->route('post');
        }

        $posts = Post::query()->where('approved', 1);

        if ($address) {
            $posts->join('locations', 'posts.location_id', '=', 'locations.id')
                ->where('locations.address', 'like', '%' . $address . '%');  // Tìm kiếm trong bảng locations
        }

        if ($priceRange) {
            $priceRangeArray = explode('-', $priceRange);
            $minPrice = $priceRangeArray[0];
            $maxPrice = $priceRangeArray[1];

            if ($maxPrice == 0) {
                $posts->where('posts.price', '>', $minPrice);
            } else {
                $posts->whereBetween('posts.price', [$minPrice, $maxPrice]);
            }
        }

        $posts = $posts->get();

        return view('post', compact('posts'));
    }





}
