<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone','fcm_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['is_admin', 'updated_at_formatted', 'invoice_url'];

    /**
     * Get computed attribute is_admin
     *
     * @return float
     */
    public function getIsAdminAttribute()
    {
        return !empty($this->attributes['type']) && 'admin' == $this->attributes['type'];
    }

    /**
     * Get the total amount spent by the user
     *
     * @return float
     */
    public function getUpdatedAtFormattedAttribute()
    {
        if (empty($this->attributes['updated_at'])) {
            return '';
        }
        return 'Last Edited ' . date(config('app.updated_at_format'), strtotime($this->attributes['updated_at']));
    }

    /**
     * Get computed attribute is_admin
     *
     * @return float
     */
    public function getInvoiceUrlAttribute()
    {
        if (empty($this->attributes['invoice'])) {
            return '';
        }
        return asset('storage/' . $this->attributes['invoice']);
    }

    public function images()
    {
        return $this->hasMany('App\Image', 'author_id');
    }

    public function prizes()
    {
        return $this->hasMany('App\Prize');
    }

    public function participations()
    {
        return $this->belongsToMany('App\Lottery', 'participants')
            ->withPivot(['invoice_no', 'invoice_photo', 'product_photo']);
    }

}
