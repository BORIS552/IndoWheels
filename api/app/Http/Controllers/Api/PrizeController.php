<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Prize;
use App\LotteryParticipation;

class PrizeController extends Controller
{
    protected $prize;

    /**
     * Get all prizes won by current user
     *
     * @return Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user()
            ->prizes()
            ->with(['lottery'])
            ->whereHas('lottery')
            ->latest()
            ->get();
    }

    /**
     * Update prize - add prize info
     *
     * @param Request $request
     * @param Prize $prize
     */
    public function update(Request $request, Prize $prize)
    {
        $this->prize = $prize;
    	$this->check($request)
            ->save($request)
            ->saveParticipation($request)
            // ->saveInvoice($request)
            ->saveSelfie($request);
    	return $this->prize;
    }

    /**
     * Check form data for prize
     *
     * @param Request $request
     * @param Prize $prize
     */
    private function check(Request $request)
    {
    	$rules = [
    		// 'invoice_no' => ['required'],
    		// 'invoice_photo' => ['required', 'image'],
            // 'selfie' => ['required', 'image'],
    		'address' => ['required'],
    		'pin_no' => ['required'],
            'email' => ['required'],
            'car_make' => ['required'],
            'car_reg_no' => ['required'],
            'dob' => ['sometimes', 'nullable', 'date'],
            'review' => ['required'],
            'rating' => ['required'],
    	];
    	$request->validate($rules);
    	return $this;
    }

    /**
     * Update prize props
     *
     * @param Request $request
     * @param Prize $prize
     */
    private function save(Request $request)
    {
        $prize = $this->prize;
    	$prize->invoice_no = $request->invoice_no;
    	$prize->address = $request->address;
    	$prize->pin_no = $request->pin_no;
        $prize->email = $request->email;
        $prize->car_make = $request->car_make;
        $prize->car_reg_no = $request->car_reg_no;
        $prize->dob = $request->dob;
        $prize->review = $request->review;
        $prize->rating = $request->rating;
    	$prize->save();
    	return $this;
    }

    /**
     * Save participation
     *
     * @param Request $request
     * @return this
     */
    private function saveParticipation(Request $request)
    {
        $participation = LotteryParticipation::where('lottery_id', $this->prize->lottery_id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (empty($participation)) {
            return;
        }

        $this->prize->invoice_no = $participation->invoice_no;
        $this->prize->invoice_photo = $participation->invoice_photo;
        $this->prize->product_photo  = $participation->product_photo;
        $this->prize->save();

        return $this;
    }

    /**
     * Save invoice image
     *
     * @param Request $request
     * @return this
     */
    private function saveInvoice(Request $request)
    {
        $prize = $this->prize;
        if ($request->hasFile('invoice_photo')) {
            $prize->invoice_photo = $request->invoice_photo->store('invoices', 'public');
            $prize->save();
        }
        return $this;
    }

    /**
     * Save selfie image
     *
     * @param Request $request
     * @param Prize $prize
     * @return this
     */
    private function saveSelfie(Request $request)
    {
        $prize = $this->prize;
        if ($request->hasFile('selfie')) {
            $prize->selfie = $request->selfie->store('selfies', 'public');
            $prize->save();
        }
        return $this;
    }

    public function uploadSelfie(Request $request) {
        return $request->selfie->store('selfies', 'public');
    }
}
