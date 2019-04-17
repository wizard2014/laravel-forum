@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
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

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                <div class="mt-4">
                    {{ $replies->links() }}
                </div>

                <hr>

                @if(auth()->check())
                    <div class="clearfix">
                        <form action="{{ $thread->path() . '/replies' }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="body" class="sr-only">Body:</label>
                                <textarea name="body" id="body" rows="5" class="form-control" placeholder="Have something to say?"></textarea>
                            </div>

                            <button type="submit" class="btn btn-default">Post</button>
                        </form>
                    </div>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="#">{{ $thread->creator->name }}</a>, and currently has {{ $thread->replies_count }} {{ \Illuminate\Support\Str::plural('comment', $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
