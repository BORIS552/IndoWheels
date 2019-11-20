<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Twilio\Rest\Client;

class ContactController extends Controller
{
    protected $user;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->user = $request->user();
        $this->check($request)->notify($request);
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
            'name' => ['required'],
            'email' => ['required'],
            'phone_no' => ['required'],
            'message' => ['required'],
        ];
        $this->validate($request, $rules);
        return $this;
    }

    /**
     * Send notification email
     *
     * @return this
     */
    public function notify()
    {
        Mail::to('admin@yashreekishanganj.org')->send(new ContactMail);
        return $this;
    }


    public function sendMail(Request $request) {
        $name = $request->name;
        $emailID = $request->email;
        $phone = $request->phone;
        $message = $request->msg;
        
    }

    public function sendWhatsappMessage() {
       
        $sid    = getenv("TWILIO_ACCOUNT_SID");
        $token  = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);

        $codes = ["chocolate", "vanilla", "strawberry", "mint-chocolate-chip", "cookies-n-cream"];
        
        $message = $twilio->messages
            ->create("whatsapp:".getenv("MY_WHATSAPP_NUMBER"),
            [
                "body" => "Your ice-cream code is ".$codes[rand(0,4)],
                "from" => "whatsapp:".getenv("TWILIO_WHATSAPP_NUMBER")
            ]
        );

        print($message->sid);

    }

}
