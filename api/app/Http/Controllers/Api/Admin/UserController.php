<?php

namespace App\Http\Controllers\Api\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use GuzzleHttp\Client;

class UserController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::where('type', 'user')->get();
    }

    public function getUsers() 
    {
        return User::all();
    }

    public function addFCMToken(Request $request) {
        $user = User::find($request->id);
        $user->fcm_token = $request->fcm_token;
        $user->save();  
        return $user;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->user = new User;
        $this->check($request)->saveProps($request)->saveInvoice($request);
        $this->user->save();
        $this->user->api_token = bcrypt($this->user->id);
        $this->user->save();
        return $this->user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->user = $user;
        $this->check($request)->saveProps($request)->saveInvoice($request);
        $this->user->save();
        return $this->user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }

    /**
     * Check User form
     *
     * @param Request $request
     * @return this
     */
    private function check(Request $request)
    {
        $id = !empty($this->user) ? $this->user->id : null;
        $rules = [
            // 'invoice_no' => ['required', Rule::unique('users')->ignore($id)],
            'phone' => ['required', Rule::unique('users')->ignore($id)],
            // 'email' => ['nullable', 'email', Rule::unique('users')->ignore($id)],
            'name' => ['required'],
        ];
        // if (empty($id)) {
        //     $rules['invoice'] = ['required', 'file', 'image'];
        // } else {
        //     $rules['invoice'] = ['sometimes', 'file', 'image'];
        // }
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
        $user = $this->user;
        $user->type = 'user';
        $user->invoice_no = $request->invoice_no;
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->pin = $request->pin;
        return $this;
    }

    /**
     * Save invoice image
     *
     * @param Request $request
     * @return this
     */
    private function saveInvoice(Request $request)
    {
        if (!empty($request->invoice)) {
            $this->user->invoice = $request->invoice->store('invoices', 'public');
        }
        return $this;
    }
}
