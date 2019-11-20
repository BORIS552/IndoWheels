<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LotteryParticipation extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'participants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lottery_id', 'user_id', 'invoice_no', 'invoice_photo', 'product_photo',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'invoice_photo_url', 'product_photo_url',
    ];

    /**
     * Get computed attribute is_admin
     *
     * @return float
     */
    public function getInvoicePhotoUrlAttribute()
    {
        if (empty($this->attributes['source'])) {
            return '';
        }
        return asset('storage/' . $this->attributes['source']);
    }

    /**
     * Get computed attribute is_admin
     *
     * @return float
     */
    public function getProductPhotoUrlAttribute()
    {
        if (empty($this->attributes['source'])) {
            return '';
        }
        return asset('storage/' . $this->attributes['source']);
    }

}
