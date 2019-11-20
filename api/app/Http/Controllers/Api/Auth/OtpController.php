<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;


class OtpController extends Controller
{
    protected $user;

    public function index(Request $request)
    {
        $this->check($request)->sendOtp($request);
        return Cache::get($request->phone);
    }

    public function store(Request $request)
    {
        if ($this->check($request, true)->matchOtp($request)) {
            return;
        }
        // abort(422);
        return response()->json([
            'errors' => [
                'otp' => ['Invalid OTP'],
            ],
        ], 422);
    }

    /**
     * Validate incoming request
     *
     * @param Request $request
     * @return this
     */
    private function check(Request $request)
    {
        $rules = [
            'phone' => ['required', 'unique:users'],
            'otp' => ['sometimes'],
        ];
        $this->validate($request, $rules);
        return $this;
    }

    /**
     * Login user
     *
     * @param Request $request
     * @return this
     */
    private function sendOtp(Request $request)
    {
        $otp = mt_rand(1000,9999);
        $msg = "Hi! Your OTP is {$otp}";
        $this->sendSms($request->phone, $msg);
        Cache::put($request->phone, $otp, 2);
        echo $otp;
        return $this;
    }

    /**
     * Login user
     *
     * @param Request $request
     * @return boolean
     */
    private function matchOtp(Request $request)
    {
        return Cache::get($request->phone) == $request->otp;
    }

    /**
     * Send SMS
     *
     * @param int $number mobile numer
     * @param string $msg text message to send
     * @return Response
     **/
    private function sendSms($number, $msg)
    {
        $client = new \GuzzleHttp\Client();
        $msg = urlencode($msg);
        // $response = $client->request('GET', "http://sub.smsrider.com/submitsms.jsp?user=tradetrn&key=e4a29f0b6cXX&mobile=+91{$number}&message={$msg}&senderid=INFOSM&accusage=1");
        // return $response->getBody();
    }
}
