<?php

namespace App\Http\Controllers\Api\Admin;

use Image;
use App\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class BannerController extends Controller
{
    protected $banner;

    public function __construct()
    {
        $this->authorizeResource(Banner::class, 'banner');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Banner::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->banner = new Banner;
        $this->check($request)
            ->saveProps($request)
            ->saveBannerImage($request)
            ->resizeBannerImage();
        $this->banner->save();
        return $this->banner;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        return $banner;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $this->banner = $banner;
        $this->check($request)
            ->saveProps($request)
            ->saveBannerImage($request)
            ->resizeBannerImage();
        $this->banner->save();
        return $this->banner;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
    }

    /**
     * Check incoming request
     *
     * @param Request $request
     * @return this or Response
     */
    private function check(Request $request)
    {
        $id = $this->banner->id ?? null;
        $rules = [
            'name' => ['required', Rule::unique('banners')->ignore($id)],
            'banner' => ['sometimes', 'file', 'image'],
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
        $banner = $this->banner;
        $banner->name = $request->name;
        return $this;
    }

    /**
     * Save invoice image
     *
     * @param Request $request
     * @return this
     */
    private function saveBannerImage(Request $request)
    {
        if ($request->hasFile('banner')) {
            $this->banner->source = $request->banner->store('banners', 'public');
        }
        return $this;
    }

    /**
     * Resize uploaded banner image
     *
     * @return this
     */
    private function resizeBannerImage()
    {
        if (!empty($this->banner->source)) {
            $path = public_path('storage/' . $this->banner->source);
            Image::make($path)->resize(720, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save();
        }
        return $this;
    }
}
