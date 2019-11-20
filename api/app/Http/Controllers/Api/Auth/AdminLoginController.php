<?php

namespace App\Http\Controllers\Api\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminLoginController extends Controller
{
	public function __invoke(Request $request)
	{
		$this->check($request);
        Auth::once([
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if (Auth::check()) {
            return Auth::user()->makeVisible(['api_token']);
        }
        abort(422);
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
            'email' => ['required', 'exists:users,email'],
            'password' => ['required'],
        ];
        $request->validate($rules);
        return $this;
    }
}
