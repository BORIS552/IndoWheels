<?php

namespace App\Http\Controllers\Api\Admin;

use App\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    protected $review;

    public function __construct()
    {
        $this->authorizeResource(Review::class, 'review');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Review::with(['author', 'lottery'])->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->review = new Review;
        $this->check($request)->setProps($request)->savePhoto($request)->saveVideo($request);
        $this->review->save();
        $this->saveScreenshot();
        $this->review->load(['author', 'lottery']);
        return $this->review;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return $review;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        $this->review = $review;
        $this->check($request)->setProps($request)->savePhoto($request)->saveVideo($request);
        $this->review->save();
        $this->saveScreenshot();
        $this->review->load(['author', 'lottery']);
        return $this->review;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->delete();
    }

    /**
     * Check incoming request
     *
     * @param Request $request
     * @return this or Response
     */
    private function check(Request $request)
    {
        $id = $this->review->id ?? null;
        $rules = [
            'title' => ['required'],
            'lottery' => ['sometimes', 'exists:lotteries,id'],
            'user' => ['sometimes', 'exists:users,id'],
            'review' => ['required'],
            'photo' => ['sometimes', 'file', 'image'],
            'video' => ['sometimes', 'file', 'mimes:mp4'],
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
        $review = $this->review;
        $review->title = $request->title;

        // set author
        if ($request->user) {
            $review->author_id = $request->user;
        } else {
            $review->author_id = $request->user()->id;
        }

        $review->lottery_id = $request->lottery;
        $review->content = $request->review;

        if ($request->user()->is_admin) {
            $review->is_active = !empty($request->is_active) ? true : null;
        }

        return $this;
    }

    /**
     * Save invoice image
     *
     * @param Request $request
     * @return this
     */
    private function savePhoto(Request $request)
    {
        if (!empty($request->photo)) {
            $this->review->photo = $request->photo->store('reviews/images', 'public');
        }
        return $this;
    }

    /**
     * Save video
     *
     * @param Request $request
     * @return this
     */
    private function saveVideo(Request $request)
    {
        if (!empty($request->video)) {
            $this->review->video = $request->video->store('reviews/videos', 'public');
        }
        return $this;
    }

    /**
     * Save video screenshot
     *
     * @return this
     */
    private function saveScreenshot()
    {
        if (empty($this->review->video)) {
            return;
        }

        $ffmpeg = \FFMpeg\FFMpeg::create($this->getBinaryPath());
        $video = $ffmpeg->open(public_path('storage/' . $this->review->video));

        $this->review->screenshot = null;
        $screenshot = 'reviews/screenshots/' . hash('sha1', $this->review->id) . '.jpg';

        try {
            $video
                ->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(10))
                ->save(public_path('storage/' . $screenshot));
            $this->review->screenshot = $screenshot;
        } catch (\Exception $e) {
            //
        } finally {
            $this->review->save();
        }

        return $this;
    }

    private function getBinaryPath()
    {
        $path = base_path('bin/');

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return [
                'ffmpeg.binaries'  => $path . 'ffmpeg.exe',
                'ffprobe.binaries' => $path . 'ffprobe.exe',
            ];
        }

        return [
            'ffmpeg.binaries'  => $path . 'ffmpeg',
            'ffprobe.binaries' => $path . 'ffprobe',
        ];
    }
}
