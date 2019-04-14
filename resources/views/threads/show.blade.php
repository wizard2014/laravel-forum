@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row justify-content-center">
            @foreach($thread->replies as $reply)
                @include('threads.reply')
            @endforeach
        </div>

        @if(auth()->check())
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form action="{{ $thread->path() . '/replies' }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="body" class="sr-only">Body:</label>
                            <textarea name="body" id="body" rows="5" class="form-control" placeholder="Have something to say?"></textarea>
                        </div>

                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                </div>
            </div>
        @else
            <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
        @endif
    </div>
@endsection
