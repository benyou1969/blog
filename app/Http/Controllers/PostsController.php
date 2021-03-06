<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Community;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    public function index(Community $community)
    {
        if ($community->exists) {
            $posts = $community->post()->latest()->get();
        } else {
            $posts = Post::latest()->get();
        }
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Community $community)
    {
        return view('post.create', compact('community'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required|',
            'community_id' => 'required',
        ]);
        $post = Post::create([
            'user_id' => auth()->id(),
            'community_id' => request('community_id'),
            'title' => request('title'),
            'body' => request('body'),
        ]);
        return redirect($post->path())->with("success", "Your post has been created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($communityId, Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($communityId, Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update($communityId, Request $request, Post $post)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required|min:5',
            'community_id' => 'required',
        ]);
        $post->title = request('title');
        $post->community_id = request('community_id');
        $post->body = request('body');
        $post->save();
        return redirect($post->path())->with("success", "This post “{$post->title}”- has been updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($communityId, Post $post)
    {
        $post->delete();
        return redirect("/posts")->with("success", "This post “{$post->title}”- has been deleted successfully");
    }
}
