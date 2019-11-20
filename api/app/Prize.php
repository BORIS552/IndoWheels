<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'info', 'start_date', 'end_date', 'lottery_id', 'user_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['invoice_photo_url', 'selfie_url', 'product_photo_url'];

    /**
     * Get computed attribute invoice_photo_url
     *
     * @return float
     */
    public function getInvoicePhotoUrlAttribute()
    {
        if (empty($this->attributes['invoice_photo'])) {
            return '';
        }
        return asset('storage/' . $this->attributes['invoice_photo']);
    }

    /**
     * Get computed attribute selfie_url
     *
     * @return float
     */
    public function getSelfieUrlAttribute()
    {
        if (empty($this->attributes['selfie'])) {
            return '';
        }
        return asset('storage/' . $this->attributes['selfie']);
    }

    /**
     * Get computed attribute product_photo_url
     *
     * @return float
     */
    public function getProductPhotoUrlAttribute()
    {
        if (empty($this->attributes['product_photo'])) {
            return '';
        }
        return asset('storage/' . $this->attributes['product_photo']);
    }

    public function lottery()
    {
    	return $this->belongsTo('App\Lottery');
    }

    public function winner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
