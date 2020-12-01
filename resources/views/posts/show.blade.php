@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            <img src="/storage/{{ $post->image }}" class="w-100" alt="">
        </div>
        <div class="col-4">
            <div>
                <div class="d-flex align-items-center">
                    <div class="pr-3">
                        <!-- a little bit different getting image, with post method than with get method -->
                        <!-- also we don;t need /storage/ here, becaue it's inside profileImage() func -->
                        <img src="{{ $post->user->profile->profileImage() }}" alt="" class="w-100 rounded-circle" style="max-width: 40px;">
                    </div>
                    <div>
                        <div class="font-weight-bold"> 
                            <a href="/profile/{{$post->user->id}}">
                                <span class="text-dark">{{ $post->user->username }}</span>
                            </a> 
                            <a href="#" class="pl-2">Follow</a>
                        </div>
                    </div>
                </div>

                <hr>
                
                <p> 
                    <span class="font-weight-bold"> 
                        <a href="/profile/{{$post->user->id}}"> 
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a> 
                    </span> {{ $post->caption }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
