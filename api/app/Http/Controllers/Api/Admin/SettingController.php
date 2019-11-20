<?php

namespace App\Http\Controllers\Api\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    protected $setting;

    public function __construct()
    {
        $this->authorizeResource(Setting::class, 'setting');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Setting::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        return $setting;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        return $setting->delete();
    }

    /**
     * Check incoming request
     *
     * @param Request $request
     * @return this or Response
     */
    private function check(Request $request)
    {
        $rules = [
            //
        ];
        $this->validate($request, $rules);
        return $this;
    }

    /**
     * Set props
     *
     * @param Request $request
     * @return this
     */
    private function setProps(Request $request)
    {
        $setting = $this->setting;
        return $this;
    }
}
