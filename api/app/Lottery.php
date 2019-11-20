<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['date_formatted', 'updated_at_formatted', 'created_at_formatted'];

    /**
     * Get the total amount spent by the user
     *
     * @return float
     */
    public function getDateFormattedAttribute()
    {
        return date('D dS M Y', strtotime($this->attributes['date']));
    }

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
     * Get the total amount spent by the user
     *
     * @return float
     */
    public function getCreatedAtFormattedAttribute()
    {
        return date(config('app.prize_date_format'), strtotime($this->attributes['created_at']));
    }

    public function author()
    {
        return $this->belongsTo('App\User');
    }

    public function prizes()
    {
        return $this->hasMany('App\Prize');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'lottery_users');
    }

    public function participants()
    {
        return $this->belongsToMany('App\User', 'participants')
            ->withPivot(['invoice_no', 'invoice_photo', 'product_photo']);
    }
}
