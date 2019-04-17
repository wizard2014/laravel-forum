<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    /**
     * Guarded fields
     *
     * @var array
     */
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });
    }

    /**
     * Returns a thread path
     *
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * Returns a thread replies
     *
     * @return HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Returns a thread creator
     *
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Returns threads channel
     *
     * @return BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Add new reply
     *
     * @param  array|Reply $reply
     * @return void
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    /**
     * Apply filters
     *
     * @param  $query
     * @param  $filters
     * @return mixed
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
