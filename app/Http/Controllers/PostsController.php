<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Post;

class PostsController extends Controller
{
    public function __construct()
    {
        // only authenticated user can create post
        // every single route will require authorization
        $this->middleware('auth'); 
    }

    public function index()
    {
        $user = auth()->user(); // not sure is it compaint with REST, added to be able to return to my profile
        
        $users = auth()->user()->following()->pluck('profiles.user_id');
        //$posts = Post::whereIn('user_id', $users)->latest()->get(); //latest changes order similar to OrderBy('created_at', 'DESC')
        $posts = Post::whereIn('user_id', $users)->latest()->paginate(5); //instead ogf getting and showing all posts, just show last 5
        return view('posts.index', compact('posts', 'user'));
 
    }

    public function create()
    {
        return view('posts.create'); // follows RESTful convention, same as in Routes in web.app, no matter how large project becomes it's always easy to find something
    }


    public function store()
    {
        //validate data, so dataq couldn't be posted without putting Post Caption and adding an image
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image'], /* same as: 'image' => 'required|image', from laravel validation rules at documentation, means only images will get through */
            /* another_field => '', gives to know to Laravel, that if this field won't pass validation, then store it anyway, no rules applied */
        ]);

        //request('image')->store('uploads', 's3'); // means, img file will be uploaded to Amazon S3 (Amazon Simple Storage Service) using credentials and filename will be returned
        $imagePath = request('image')->store('uploads', 'public'); // in this case save img to local storage as (storage\app\public\uploads\mYla5BPUuvpdnGE46enPGbdkZo9Q5TiMpiz3DGkG.png)
            
        //wrap our image with intervention class, then fit into square block
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200); // in pixels max size to which it will be cropped centered and if needed will be resized
        $image->save();
        
        //\App\Models\Post::create($data); // will create an error

        // get authenticated user and add implicitly user_id into storing data, otherwise error 
        // also posts shows error if we not signed in 
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);  

        //dd(request()->all()); // for debugging only, show array data on page after submitting form post

        // redirect to user profile after
        return redirect('/profile/'.(auth()->user()->id));

       
    }

    
    // adding \App\Models\Post allows to fetch our post object, otherwise with just $post as argument it will be getting only id number of image post
    //Restful argument name should be the same as in set in Route in web.app
    public function show(\App\Models\Post $post)
    {
        
        // return view('posts.show', [
        //     'post' => $post,
        // ]);
        //or the same:
        return view('posts.show', compact('post'));
    }



}

