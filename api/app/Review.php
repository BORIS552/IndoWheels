<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['photo_url', 'video_url', 'screenshot_url', 'updated_at_formatted'];

    /**
     * Get computed attribute photo_url
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        if (empty($this->attributes['photo'])) {
            return '';
        }
        return asset('storage/' . $this->attributes['photo']);
    }

    /**
     * Get computed attribute video_url
     *
     * @return string
     */
    public function getVideoUrlAttribute()
    {
        if (empty($this->attributes['video'])) {
            return '';
        }
        return asset('storage/' . $this->attributes['video']);
    }

    /**
     * Get computed attribute screenshot_url
     *
     * @return string
     */
    public function getScreenshotUrlAttribute()
    {
        if (empty($this->attributes['screenshot'])) {
            return '';
        }
        return asset('storage/' . $this->attributes['screenshot']);
    }

    /**
     * Get computed attribute updated_at_formatted
     *
     * @return string
     */
    public function getUpdatedAtFormattedAttribute()
    {
        if (empty($this->attributes['updated_at'])) {
            return '';
        }
        return 'Last Edited ' . date(config('app.updated_at_format'), strtotime($this->attributes['updated_at']));
    }

    public function author()
    {
        return $this->belongsTo('App\User');
    }

    public function lottery()
    {
        return $this->belongsTo('App\Lottery');
    }
}
