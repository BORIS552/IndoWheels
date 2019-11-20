<?php

namespace App\Http\Controllers\Api;
use App\User;
use App\Lottery;
use App\LotteryParticipation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParticipationController extends Controller
{
    protected $lottery;

    public function index(Request $request)
    {
    	return Lottery::whereDate('date', '>', date('Y-m-d'))
    		->with(['participants' => function($query) use ($request) {
    			$query->where('user_id', $request->user()->id);
    		}])
            ->get();
    }

    public function store(Request $request, Lottery $lottery)
    {
        $this->lottery = $lottery;
        $this->check($request)
            ->save($request);
        return $this->lottery;
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
            'invoice_no' => ['required'],
            'invoice_photo' => ['required', 'image'],
            'product_photo' => ['required', 'image'],
        ];
        $request->validate($rules);
        return $this;
    }

    /**
     * Save invoice image
     *
     * @param Request $request
     * @return this
     */
    private function save(Request $request)
    {
        $this->lottery->participants()->detach($request->user()->id);
        $this->lottery->participants()->attach($request->user()->id, [
            'invoice_no' => $request->invoice_no,
            'invoice_photo' => $request->invoice_photo->store('invoices', 'public'),
            'product_photo' => $request->product_photo->store('products', 'public'),
        ]);
        return $this;
    }


    public function manipulation(Request $request)
    {
        $invoice_no = $request->invoice;
        $lottery_id = $request->lottery;
        $manipulated_phone = $request->phone;
        $new_user_id = User::where('phone',$manipulated_phone)->value('id');
        $lottery_update_status = LotteryParticipation::where('lottery_id',$lottery_id)->where('invoice_no',$invoice_no)->update(['user_id'=>$new_user_id]);
        return $lottery_update_status;
    }
}
