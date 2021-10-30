<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Http\Requests\Posts\CreatePostsRequest;

class PostsController extends Controller
{
    // apply custom middleware that prevents creating posts without a category
    // *** NOTE *** custom middleware must be added to Kernel.php file
    public function __construct()
    {
        $this->middleware('verifyCategoryCount')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // fetch all posts from DB and pass with 'posts' variable
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        // upload image
        // filesystems.php defaults FILESYSTEM_DRIVER to local
        // update .env file to FILESYSTEM_DRIVER=public for public access to uploaded files
        $image = $request->image->store('posts');

        // create the post
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $image,
            'category_id' => $request->category,
            'published_at' => $request->published_at
        ]);

        if ($request->tags) {
            // attach is available because of many-to-many relationship
            // attaches tags to post that was created
            $post->tags()->attach($request->tags);
        }

        // flash message
            session()->flash('success', 'Post Successfuly Created');

        // redirect user
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // $request->only for security reasons
        $data = $request->only(['title', 'description', 'published_at', 'content']);

        // check if new image
        if ($request->hasFile('image')) {
            // upload the new image
            $image = $request->image->store('posts');

            // delete old image from method we created in Post Model
            $post->deleteImage();

            $data['image'] = $image;
        }

        if ($request->tags) {
            // sync() available because of many-to-many relationship
            // checks if tags were already attached to post, adds new tags, detaches unselected tags
            $post->tags()->sync($request->tags);
        }

        // update attributes
        $post->update($data);

        // flash message
        session()->flash('success', 'Post Successfully Updated');

        // redirect user
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // route/model binding will not work because we are retrieving trashed posts (id will not be found)
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        $sessionMessage = null;

        if ($post->trashed()) {
            // delete uploaded files from storage/app/public/posts
            $post->deleteImage();
            $post->forceDelete();
            $sessionMessage = 'Post Successfully Deleted';
        } else {
            $post->delete();
            $sessionMessage = 'Post Successfully Trashed';
        }

        session()->flash('success', $sessionMessage);

        return redirect(route('posts.index'));
    }

    /**
     * Display a list of all deleted posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashed = Post::onlyTrashed()->get();

        return view('posts.index')->withPosts($trashed);
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        // built-in function that restores posts
        $post->restore();

        session()->flash('success', 'Post Successfully Restored');

        return redirect()->back();
    }
}
