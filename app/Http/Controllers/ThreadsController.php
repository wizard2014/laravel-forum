<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function request;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
             ->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return Response
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);
        $attributes['user_id'] = auth()->id();

        $thread = Thread::create($attributes);

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  $channelId
     * @param  Thread $thread
     * @return Response
     */
    public function show($channelId, Thread $thread)
    {
        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(25)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Thread $thread
     * @return Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Thread $thread
     * @return Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Thread $thread
     * @return Response
     */
    public function destroy(Thread $thread)
    {
        //
    }

    /**
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    private function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        $threads = $threads->get();
        return $threads;
    }
}
