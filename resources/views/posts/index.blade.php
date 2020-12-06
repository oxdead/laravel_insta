@extends('layouts.app')

@section('content')
<div class="container">

    @if (count($posts) > 0)
        @foreach($posts as $post)
            <div class="row">
                <div class="col-6 offset-3">
                    <a href="/profile/{{$post->user->id}}">
                        <img src="/storage/{{ $post->image }}" class="w-100" alt="">
                    </a>
                </div>
            </div>
            <div class="row pt-2 pb-4">
                <div class="col-3 offset-3">
                    <div>
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
        @endforeach

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <!-- gets added if we use in controller paginate() func -->
                {{$posts->links()}}
            </div>
        </div>
    @else
        <div class="d-flex align-items-center justify-content-center">
            <div class="my-5">
                <h3 class="text-secondary"><em>Nobody posted yet.</em></h3>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center">
            <div class="row">
                <a href="/profile/{{$user->id}}"> 
                    <span class="pt-2 pb-2 pl-3 pr-3 bg-primary rounded text-white">Go to my profile page</span>
                </a> 
            </div>
        </div>

    @endif

</div>
@endsection
