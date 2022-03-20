<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Requests\PostCommentStoreRequest;
use Spatie\Tags\Tag;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except([
            'index', 'show'
        ]);

        $this->authorizeResource(Post::class, 'post', [
            'except' => ['index', 'show'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('author')->withCount('comments')->latest('id')->paginate(2);

        return view('welcome', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::latest('id')->get();
        return view('posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        $post = new Post;
        $post->user_id      = auth()->id();
        $post->title        = $request->title;
        $post->description  = $request->description;
        $post->save();

        // Add tags
        if($request->tags) {
            $post->syncTags($request->tags);
        }

        return redirect()->route('welcome')->with('status', 'Post created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('tags', 'author');

        $comments = Comment::with('user')->where('post_id', $post->id)->latest('id')->paginate(10);

        $badgeColors = [
            "bg-primary",
            "bg-secondary",
            "bg-success",
            "bg-danger",
            "bg-warning text-dark",
            "bg-info text-dark",
            "bg-light text-dark",
            "bg-dark",
        ];

        return view('posts.show', compact('post', 'badgeColors', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::latest('id')->get();

        $post->load('tags', 'author');

        $postTags = $post->tags->pluck('name')->toArray();

        return view('posts.edit', compact('post', 'postTags', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $post->title        = $request->title;
        $post->description  = $request->description;
        $post->save();

        // Add tags
        if($request->tags) {
            $post->syncTags($request->tags);
        }

        return redirect()->route('welcome')->with('status', 'Post updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // Check for comment count
        if ( $post->comments->count() ) {

            return back()->with('error', 'Unable to delete comments exists!');

        }

        $post->delete();

        return redirect()->route('welcome')->with('status', 'Post deleted!');

    }

    public function commentStore(PostCommentStoreRequest $request, Post $post)
    {
        $comment = new Comment;
        $comment->post_id = $post->id;
        $comment->user_id = auth()->id();
        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('posts.show', $post->id)->with('status', 'Comment added!');
    }
}
