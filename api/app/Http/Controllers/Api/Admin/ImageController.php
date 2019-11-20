<?php

namespace App\Http\Controllers\Api\Admin;

use App\Image;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ImageController extends Controller
{
    protected $image;

    public function __construct()
    {
        $this->authorizeResource(Image::class, 'image');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        return $user->images;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->image = new Image;
        $this->check($request)->saveProps($request)->saveImage($request);
        $request->user->images()->save($this->image);
        return $this->image;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Image $image)
    {
        return $image;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Image $image)
    {
        $this->image = $image;
        $this->check($request)->saveProps($request)->saveImage($request);
        $this->image->save();
        return $this->image;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Image $image)
    {
        $image->delete();
    }

    /**
     * Check incoming request
     *
     * @param Request $request
     * @return this or Response
     */
    private function check(Request $request)
    {
        $id = $this->image->id ?? null;
        $rules = [
            'name' => ['required'],
            'image' => ['sometimes', 'file', 'image'],
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
        $image = $this->image;
        $image->name = $request->name;
        return $this;
    }

    /**
     * Save invoice image
     *
     * @param Request $request
     * @return this
     */
    private function saveImage(Request $request)
    {
        if (!empty($request->image) && $request->hasFile('image')) {
            $this->image->path = $request->image->store('images', 'public');
        }
        return $this;
    }
}
