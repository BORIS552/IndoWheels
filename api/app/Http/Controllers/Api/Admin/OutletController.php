<?php

namespace App\Http\Controllers\Api\Admin;

use App\Outlet;
use App\App\Policies\OutletPolicy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class OutletController extends Controller
{
    protected $outlet;

    public function __construct()
    {
        $this->authorizeResource(Outlet::class, 'outlet');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Outlet::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->outlet = new Outlet;
        $this->check($request)->setProps($request);
        $this->outlet->save();
        return $this->outlet;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function show(Outlet $outlet)
    {
        return $outlet;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Outlet $outlet)
    {
        $this->outlet = $outlet;
        $this->check($request)->setProps($request);
        $this->outlet->save();
        return $this->outlet;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Outlet $outlet)
    {
        $outlet->delete();
    }

    /**
     * Check incoming request
     *
     * @param Request $request
     * @return this or Response
     */
    private function check(Request $request)
    {
        $id = $this->outlet->id ?? null;
        $rules = [
            'name' => ['required', Rule::unique('outlets')->ignore($id)],
            'is_active' => ['nullable', 'boolean'],
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
        $outlet = $this->outlet;
        $outlet->name = $request->name;
        $outlet->is_active = !empty($request->is_active) ? true : null;
        return $this;
    }
}
