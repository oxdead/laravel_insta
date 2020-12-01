<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    public function __construct()
    {
        //when not signed in user tries to click follow, error 500 get caught, to prevent unauthorized user from followoing use this middleware    
        // now we get 401 error: Unauthorized, which is as it should be  and next we will catch this error in vue component in followUser method and redirect user to login page  
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        return auth()->user()->following()->toggle($user->profile);
    }
}
