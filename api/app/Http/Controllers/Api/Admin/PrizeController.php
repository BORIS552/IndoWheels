<?php

namespace App\Http\Controllers\Api\Admin;

use App\Prize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrizeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Prize::class, 'prize');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return Prize::with(['lottery', 'winner'])
    		->whereHas('lottery')
    		->whereHas('winner')
    		->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prize $prize)
    {
    	$prize->delete();
    }
}
