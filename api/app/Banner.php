<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['updated_at_formatted', 'banner_url'];

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
    public function getBannerUrlAttribute()
    {
        if (empty($this->attributes['source'])) {
            return '';
        }
        return asset('storage/' . $this->attributes['source']);
    }
}
