<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    protected $user;

    public function __invoke(Request $request)
    {
        $this->check($request);
        if ($this->matchOtp($request)) {
            return $this->login($request)->user;
        }
        return response()->json([], 422);
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
            'phone' => ['string', 'exists:users'],
            'otp' => ['required', 'numeric'],
        ];
        $request->validate($rules);
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
     * Login user
     *
     * @param Request $request
     * @return this
     */
    private function login(Request $request)
    {
        $this->user = User::where('phone', $request->phone)->firstOrFail();
        $this->user->makeVisible('api_token');
        return $this;
    }
}
