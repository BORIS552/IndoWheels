<?php

namespace App\Http\Controllers\Api\Admin;

use Image;
use App\Ad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class AdController extends Controller
{
    protected $ad;

    public function __construct()
    {
        $this->authorizeResource(Ad::class, 'ad');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ad::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->ad = new Ad;
        $this->check($request)
            ->saveProps($request)
            ->saveAdImage($request)
            ->resizeAdImage();
        $this->ad->save();
        return $this->ad;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        return $ad;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ad $ad)
    {
        $this->ad = $ad;
        $this->check($request)
            ->saveProps($request)
            ->saveAdImage($request)
            ->resizeAdImage();
        $this->ad->save();
        return $this->ad;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        $ad->delete();
    }

    /**
     * Check incoming request
     *
     * @param Request $request
     * @return this or Response
     */
    private function check(Request $request)
    {
        $id = $this->ad->id ?? null;
        $rules = [
            'name' => ['required', Rule::unique('ads')->ignore($id)],
            'ad' => ['sometimes', 'file', 'image'],
        ];
        $this->validate($request, $rules);
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
        $ad = $this->ad;
        $ad->name = $request->name;
        return $this;
    }

    /**
     * Save invoice image
     *
     * @param Request $request
     * @return this
     */
    private function saveAdImage(Request $request)
    {
        if (!empty($request->ad) && $request->hasFile('ad')) {
            $this->ad->source = $request->ad->store('ads', 'public');
        }
        return $this;
    }

    /**
     * Resize uploaded ad image
     *
     * @return this
     */
    private function resizeAdImage()
    {
        if (!empty($this->ad->source)) {
            $path = public_path('storage/' . $this->ad->source);
            Image::make($path)->resize(720, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save();
        }
        return $this;
    }
}
