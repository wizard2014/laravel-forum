<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\RedirectResponse;
use function request;

class RepliesController extends Controller
{
    /**
     * RepliesController constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Add new reply to a thread
     *
     * @param  $channelId
     * @param  Thread $thread
     * @return RedirectResponse
     */
    public function store($channelId, Thread $thread)
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back();
    }
}
