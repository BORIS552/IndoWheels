<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;

class TermsController extends Controller
{
    /**
     * Get terms and conditions
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return Setting::where('slug', 'terms')->firstOrFail();
    }

    /**
     * Accept terms and conditions
     *
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function accept(Request $request)
    {
        $user = $request->user();
        $user->is_terms_accepted = true;
        $user->save();
        return $user;
    }
}
