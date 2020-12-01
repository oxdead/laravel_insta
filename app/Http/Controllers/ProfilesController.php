<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;


class ProfilesController extends Controller
{
    
    // public function index($user)
    // {
    //     //$user = User::find($user);
    //     $user = User::findOrFail($user); // on wrong url will not break site, but instead will show 404 page

    //     return view('profiles.index', [
    //         'user' => $user,
    //     ]);
    // }
    // new refactored function of above func
    public function index(User $user) // \App\Models\User, but we use "use App\Models\User;" so can be just "User"
    {
        // determine is user follows profile. (is autenticated user's following contains user passed in).
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        //without caching:
        //$postCount = $user->posts->count();
        //$followersCount = $user->profile->followers->count();
        //$followingCount = $user->following->count();

        //with 30 sec caching:
        $postCount = Cache::remember('count.posts.'.$user->id, //cache identifier
                                    now()->addSeconds(30), //store it for 30 seconds
                                    function() use ($user) { // if cache is absent, then run this command
                                        return $user->posts->count();
                                    });

        $followersCount = Cache::remember('count.followers.'.$user->id,
                                    now()->addSeconds(30), 
                                    function() use ($user) { 
                                        return $user->profile->followers->count();
                                    });

        $followingCount = Cache::remember('count.following.'.$user->id,
                                    now()->addSeconds(30), 
                                    function() use ($user) { 
                                        return $user->following->count();
                                    });



        return view('profiles.index', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile); // to prevent visiting page for editing profile by outside user, uses Policies/ProfilePolicy.php

        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        
        if(request('image')) // if user put new image to update
        {
            $imagePath = request('image')->store('profile', 'public'); // in this case save img to local storage as (storage\app\public\profile\)
            
            //wrap our image with intervention class, then fit into square block
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000); // in pixels max size to which it will be cropped centered and if needed will be resized
            $image->save();

            $imageArray = ['image' => $imagePath ];
        }

        //$user->profile->update($data); // is incorrect as it allows to edit even if not logged in
        //auth()->user()->profile->update($data); // correct, only logged in user can edit his profile
        //same as above, but add also and avatar image wrapped in array and merge it with data array, and 2nd array with 'image' key overwrites data at 'image' key in 1st array 
        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []

        ));
        

        return redirect("/profile/{$user->id}");

    }

}
