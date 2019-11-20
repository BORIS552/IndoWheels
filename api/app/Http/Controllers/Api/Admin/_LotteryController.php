<?php

namespace App\Http\Controllers\Api\Admin;

use App\Lottery;
use App\Prize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class LotteryController extends Controller
{
    protected $lottery;

    public function __construct()
    {
        $this->authorizeResource(Lottery::class, 'lottery');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Lottery::with(['prizes'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->lottery = new Lottery;
        $this->check($request)->setProps($request);
        $this->lottery->save();
        $this->savePrizes($request);
        $this->lottery->load(['prizes']);
        return $this->lottery;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function show(Lottery $lottery)
    {
        return $lottery;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lottery $lottery)
    {
        $this->lottery = $lottery;
        $this->check($request)->setProps($request);
        $this->lottery->save();
        $this->savePrizes($request);
        $this->lottery->load(['prizes']);
        return $this->lottery;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lottery $lottery)
    {
        $lottery->delete();
    }

    /**
     * Check incoming request
     *
     * @param Request $request
     * @return this or Response
     */
    private function check(Request $request)
    {
        $id = $this->lottery->id ?? null;
        $rules = [
            'name' => ['required', Rule::unique('lotteries')->ignore($id)],
            // 'start_date' => ['required', 'date'],
            // 'end_date' => ['required', 'date'],
            // 'is_active' => ['nullable', 'boolean'],
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
        $lottery = $this->lottery;
        $lottery->name = $request->name;
        $lottery->is_active = true;
        // $lottery->start_date = date('Y-m-d', strtotime($request->start_date));
        // $lottery->end_date = date('Y-m-d', strtotime($request->end_date));
        // $lottery->is_active = !empty($request->is_active) ? true : null;
        return $this;
    }

    /**
     * Save lottery prizes
     *
     * @param Request $request
     * @return this
     */
    private function savePrizes(Request $request)
    {
        if (empty($request->prizes)) {
            return;
        }

        $this->lottery->prizes()->delete();

        foreach ($request->prizes as $_prize) {
            $this->lottery->prizes()->save(Prize::create([
                'name' => $_prize['name'],
                'info' => $_prize['info'],
            ]));
        }
        return $this;
    }
}
