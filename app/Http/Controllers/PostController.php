<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $posts = Post::latest()->paginate(5);
        return view("post.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view("post.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $data = $request->validate([
         "title"=> "required|max:255",
         "content"=> "required",
         "image"=> "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
         "category_id" => "required|exists:categories,id",
         "published_at" => "nullable|date",
       ]);
       
       $image = $data['image'];
       unset($data['image']);
       $data['user_id'] = auth()->id();
       $data['slug'] = Str::slug($data['title']);

       $imagePath = $image->store('posts', 'public');
       $data['image'] = $imagePath;


       Post::create($data);

       return redirect()->route('dashboard')->with('success','Post Saved Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
