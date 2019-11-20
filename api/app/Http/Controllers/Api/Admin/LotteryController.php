<?php

namespace App\Http\Controllers\Api\Admin;
use App\Events\NewNotification;

use App\Lottery;
use App\Prize;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use App\Events\MobilePushNotification;
// use Twilio\Rest\Client;

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
        $lotteries = Lottery::latest()
            ->with(['prizes', 'prizes.winner', 'users', 'prizes.winner', 'participants'])
            ->get();

        $lotteries = $lotteries->map(function($_lottery) {
            $user_ids = $_lottery->users->pluck('lottery_users.user_id')->toArray();
            $users = $_lottery->participants()->get()->values();

            foreach ($users as $_user) {
                if (!empty($_user->pivot->invoice_photo)) {
                    $_user->pivot->invoice_photo = asset('storage/' . $_user->pivot->invoice_photo);
                }
                if (!empty($_user->pivot->product_photo)) {
                    $_user->pivot->product_photo = asset('storage/' . $_user->pivot->product_photo);
                }
            }

            unset($_lottery->users);
            $_lottery->users = $users;
            return $_lottery;
        });

        return $lotteries;
    }


    public function getAllLottery() {
        return Lottyer::all();
    }
     
    /**
     * Get all users within a specified date range
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request, Lottery $lottery)
    {
        $request->validate([
            // 'name' => ['required'],
            // 'start_date' => ['required', 'date'],
            // 'end_date' => ['required', 'date'],
            'selection_type' => ['required'],
            'selection_value' => ['required'],
        ]);

        // $users = User::orderBy('name', 'asc')
        //     ->whereDate('created_at', '>=', $request->start_date)
        //     ->whereDate('created_at', '<=', $request->end_date)
        //     ->get();
        $users = $lottery->participants()
            ->withPivot(['invoice_no', 'invoice_photo', 'product_photo'])
            ->get()
            ->values();

        if ('division' == $request->selection_type) {
            $users = $users->random($users->count() / $request->selection_value);
        }

        $users = $users->random(min($users->count(), $request->selection_value));

        foreach ($users as $_user) {
            if (!empty($_user->pivot->invoice_photo)) {
                $_user->pivot->invoice_photo = asset('storage/' . $_user->pivot->invoice_photo);
            }
            if (!empty($_user->pivot->product_photo)) {
                $_user->pivot->product_photo = asset('storage/' . $_user->pivot->product_photo);
            }
        }

        return $users;
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
        $this->saveUsers($request);
        $this->lottery->load(['prizes', 'prizes.winner', 'users', 'prizes.winner']);
        $this->notifyUsers();
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
        $lottery->load(['prizes', 'prizes.winner', 'users', 'prizes.winner']);
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
        $this->saveUsers($request);
        $this->lottery->load(['prizes', 'prizes.winner', 'users', 'prizes.winner']);
        $this->notifyUsers();
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

    // public function disableLottery(Lottery $lottery)
    // {
    //     $lottery->is_active = false;
    // }

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
            // 'name' => ['required', Rule::unique('lotteries')->ignore($id)],
            'name' => ['required'],
            'date' => ['required', 'date'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'selection_type' => ['nullable', 'in:division,number'],
            'selection_value' => ['nullable', 'numeric'],
            'prizes.*.name' => ['required', 'string'],
            'prizes.*.info' => ['required', 'string'],
            'prizes.*.user' => ['sometimes', 'nullable', 'exists:users,id'],
        ];
        $request->validate($rules);
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
        $lottery->selection_type = $request->selection_type;
        $lottery->selection_value = $request->selection_value;
        $lottery->is_active = true;
        $lottery->date = $request->date;
        $lottery->start_date = $request->start_date;
        $lottery->end_date = $request->end_date;
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
        $this->lottery->is_active = false;
        $this->lottery->save();
        foreach ($request->prizes as $_prize) {
            $this->lottery->prizes()->save(Prize::create([
                'name' => $_prize['name'],
                'info' => $_prize['info'],
                'user_id' => $_prize['user'] ?? null,
            ]));
        }
        return $this;
    }


    /**
     * Save lottery users
     *
     * @param Request $request
     * @return this
     */
    private function saveUsers(Request $request)
    {
        if (empty($request->users)) {
            return;
        }
        $this->lottery->users()->sync($request->users);
        return $this;
    }


    /**
     * Notify all related users about the prize they have won
     *
     * @return promises
     */
    private function notifyUsers()
    {
        $client = new Client();
        $promises = [];
        $msg = "Winner,Open IndoWheels App for claim.";
        //$app_name = config('app.name');
        foreach ($this->lottery->prizes as $_prize) {
            if(empty($_prize->winner->phone)) {
                continue;
            }
            $promises[] = $client->getAsync("http://sub.smsrider.com/submitsms.jsp?user=tradetrn&key=e4a29f0b6cXX&mobile=+91{$_prize->winner->phone}&message={$msg}&senderid=INFOSM&accusage=1")->then(
                function ($response) {
                    echo $response;
                }, function ($exception) {
                    echo $exception;
                }
                );


        }
            
        return Promise\settle($promises)->wait();
    }


    public function notifyUsersPushNotification(Request $request){
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'key=AAAAhTTIyfs:APA91bGVQhIBVu88IavJHwS5hafQQbGeJRxZM8PMC8x_dl75fAVdba70r5wmAlqsN_RsNOPy1zRB1XpILYUD3onBkWn3Jc-byVDlxsWYLQGpnkSdoST8rNZmCQ4_gA7eUVJYmnJYYPA-',
        ];

        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);

        $promises = [];
        
            $user_fcm = User::select('fcm_token')->where('phone',$request->phone)->first();
            $out->writeln($user_fcm->fcm_token);
            $url = 'https://fcm.googleapis.com/fcm/send';

            $promises[] = $client->postAsync($url,[
            'json' => [
                'to' => $user_fcm->fcm_token,
                'notification' => [
                    'body' => 'Congratulations! You won Indowheels Lottery, open app for claim',
                    'title' => 'Lottery!!!'
                ]
            ]
        ])->then(
                function($response) {
                    $out->writeln($response);
                }, function($exception) {
                    $out->writeln($exception);;
                }
            );
        

        return Promise\settle($promises)->wait();
        }


    public function sendSMS(Request $request) {
        $number = $request->phone;
        $msg = $request->msg;
        $client = new \GuzzleHttp\Client();
        $msg = urlencode($msg);
        $response = $client->request('GET', "http://sub.smsrider.com/submitsms.jsp?user=tradetrn&key=e4a29f0b6cXX&mobile=+91{$number}&message={$msg}&senderid=INFOSM&accusage=1");
        return $response->getBody();
    }

    // public function sendWhatsappMessage() {
       
    //     $sid    = getenv("TWILIO_ACCOUNT_SID");
    //     $token  = getenv("TWILIO_AUTH_TOKEN");
    //     $twilio = new Client($sid, $token);
    //     $codes = ["chocolate", "vanilla", "strawberry", "mint-chocolate-chip", "cookies-n-cream"];

    //     $message = $twilio->messages
    //         ->create("whatsapp:".getenv("MY_WHATSAPP_NUMBER"),
    //         [
    //             "body" => "Your ice-cream code is ".$codes[rand(0,4)],
    //             "from" => "whatsapp:".getenv("TWILIO_WHATSAPP_NUMBER")
    //         ]
    //     );

    //     print($message->sid);

    // }

    public function sendNotification() 
    {
        $user = User::find(686);
        broadcast(new NewNotification($user))->toOthers();
    }



    //POST fcm notifications.
    public function sendfcmPushNotification(Request $request) {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'key=AAAAhTTIyfs:APA91bGVQhIBVu88IavJHwS5hafQQbGeJRxZM8PMC8x_dl75fAVdba70r5wmAlqsN_RsNOPy1zRB1XpILYUD3onBkWn3Jc-byVDlxsWYLQGpnkSdoST8rNZmCQ4_gA7eUVJYmnJYYPA-',
        ];

        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);

        // $body = '{
        //     "to": '.$request->fcm.',

        //     "notification": {

        //     "body": '.$request->body.',
        //     "title": '.$request->title.'
        //     }
        // }';

        $user_fcm = User::select('fcm_token')->where('phone',$request->phone)->first();
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln($user_fcm->fcm_token);
        $res = $client->request('POST','https://fcm.googleapis.com/fcm/send', [
            'json' => [
                'to' => $user_fcm->fcm_token,
                'notification' => [
                    'body' => $request->body,
                    'title' => $request->title
                ]
            ]
        ]);

        return $res->getBody()->getContents();

    }

}
