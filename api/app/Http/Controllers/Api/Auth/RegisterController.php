<?php

namespace App\Http\Controllers\Api\Auth;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;

class RegisterController extends Controller
{
    protected $user;

    public function __invoke(Request $request)
    {
        $this->check($request)
            ->getUser($request)
            ->sendOtp($request);
    }

    /**
     * Validate incoming request
     *
     * @param Request $request
     * @return this
     */
    private function check(Request $request)
    {
        $id = !empty($this->user) ? $this->user->id : null;
        $rules = [
            'phone' => ['required', 'string', 'size:10'],
        ];
        $this->validate($request, $rules);
        return $this;
    }

    /**
     * Get existing user or create a new user
     *
     * @param Request $request
     * @return this
     */
    public function getUser(Request $request)
    {
        $this->user = User::firstOrCreate([
            'phone' => $request->phone,
        ]);
        if (empty($this->user->api_token)) {
            $this->user->api_token = bcrypt($request->phone);
            $this->user->save();
        }
        return $this;
    }

    /**
     * Save props
     *
     * @param Request $request
     * @return this
     */
    private function saveProps(Request $request)
    {
        $user = $this->user;
        $user->type = 'user';
        $user->invoice_no = $request->invoice_no;
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->pin = $request->pin;
        $user->password = bcrypt($request->password);
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
        if (!empty($request->invoice)) {
            $this->user->invoice = $request->invoice->store('invoices', 'public');
        }
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
        return $this;
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
        $response = $client->request('GET', "http://sub.smsrider.com/submitsms.jsp?user=tradetrn&key=e4a29f0b6cXX&mobile=+91{$number}&message={$msg}&senderid=INFOSM&accusage=1");
        return $response->getBody();
    }
}
