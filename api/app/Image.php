<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['updated_at_formatted', 'image_url'];

    /**
     * Get the total amount spent by the user
     *
     * @return float
     */
    public function getUpdatedAtFormattedAttribute()
    {
        return 'Last Edited ' . date('g:iA M d Y', strtotime($this->attributes['updated_at']));
    }

    /**
     * Get computed attribute is_admin
     *
     * @return float
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->attributes['path'])) {
            return '';
        }
        return asset('storage/' . $this->attributes['path']);
    }
}
