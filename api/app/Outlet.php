<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['updated_at_formatted'];

    /**
     * Get the total amount spent by the user
     *
     * @return float
     */
    public function getUpdatedAtFormattedAttribute()
    {
        return 'Last Edited ' . date('g:iA M d Y', strtotime($this->attributes['updated_at']));
    }

    public function author()
    {
        return $this->belongsTo('App\User');
    }
}
