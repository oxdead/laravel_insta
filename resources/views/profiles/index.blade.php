@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 pt-4">
            <img src="{{$user->profile->profileImage()}}" class="rounded-circle w-100" alt=""> <!-- rounded-circle is bootstrap? but we usee vue? don't get it.. -->
        </div>
        <div class="col-9 pt-4">
            <div class="d-flex justify-content-between align-items-baselineS">
                <div class="d-flex align-items-center pb-3">
                    <div class="h4">{{ $user->username }}</div>

                    <!-- vue component -->
                    <follow-button user-id="{{$user->id}}" follows="{{$follows}}"></follow-button>
                </div>

                @can ('update', $user->profile)
                    <a href="/p/create">Add new post</a> 
                @endcan
            </div>

            <!-- directive to prevent seeing Edit Profile link bu unauthorized/ourside user -->
            @can ('update', $user->profile)
                <a href="/profile/{{ $user->id }}/edit">Edit profile</a> 
            @endcan

            <div class="d-flex">
                <div class="pr-4"><strong>{{$postCount}}</strong>&nbspposts</div>
                <div class="pr-4"><strong>{{$followersCount}}</strong>&nbspfollowers</div>
                <div class="pr-4"><strong>{{$followingCount}}</strong>&nbspfollowing</div>
            </div>
            <div class="pt-2"><strong>{{ $user->profile->title }}</strong></div>
            <div>{{ $user->profile->description }} </div>
            <div><a href="https://www.youtube.com/watch?v=ImtZ5yENzgE&t=1556s">{{ $user->profile->url ?? 'N/A' }}</a></div>
        </div>
    </div>
    <div class="row pt-5">

        <!-- for each post with image that we upload via post/create show each image -->
        @foreach($user->posts as $post)
            <div class="col-4 pb-4">
                <a href="/p/{{ $post->id }}"> <!-- RESTful -->
                    <img src="/storage/{{ $post->image }}" class="w-100" alt="">
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
