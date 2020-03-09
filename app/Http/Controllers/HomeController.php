<?php

namespace App\Http\Controllers;

use App\UsersPhoneNumber;
use App\Content;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\Reply;


class HomeController extends Controller
{
    /**
     * Show the forms with users phone number details.
     *
     * @return Response
     */
    public $from_num;

    public function __construct()

    {
        $this->from_num = getenv("TWILIO_NUMBER");
    }
    public function show(Request $request)
    {
        $users = UsersPhoneNumber::all();
        $current_lists = $this->read($this->from_num);
        return view('welcome')->with("users",$users)->with('current_lists',$current_lists);
    }
    /**
     * Store a new user phone number.
     *
     * @param  Request  $request
     * @return Response
     */
    public function storePhoneNumber(Request $request)
    {
        //run validation on data sent in
        $this->sendMessage('User registration successful!!', $request->phone_number);
        $validatedData = $request->validate([
            'phone_number' => 'required|unique:users_phone_number|numeric',
        ]);
        $user_phone_number_model = new UsersPhoneNumber($request->all());
        $user_phone_number_model->save();
        return back()->with(['success' => "{$request->phone_number} registered"]);
    }
    /**
     * Send message to a selected users
     */
    public function sendCustomMessage(Request $request)
    {
        $validatedData = $request->validate([
            'users' => 'required|array',
            'body' => 'required',
        ]);

        // // iterate over the array of recipients and send a twilio request for each

        $recipients = $validatedData["users"];
        foreach ($recipients as $recipient) {
            $msg = $this->sendMessage($validatedData["body"], $recipient);

            $content = [
                'from_number' => $this->from_num,
                'to_number'   => $recipient,
                'content'     => $request->body,
                'sid'         => $msg->sid,
                'status'      => $msg->status
            ];
            Content::create($content);
            // $this->storeContent($request, $msg);

        }
        return back()->with(['success' => "Messages on their way!"]);
    }
    /**
     * Sends sms to user using Twilio's programmable sms client
     * @param String $message Body of sms
     * @param Number $recipients Number of recipient
     *
     * @return MessageInstance
     */
    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $msg = $client->messages->create('whatsapp:' . $recipients, ['from' => 'whatsapp:' . $twilio_number, 'body' => $message, 'statusCallback' => 'http://d4e3e5ff.ngrok.io/SentSmsStatus']);

        return $msg;
    }
    Public function updateStatus(Request $request)
    {
        \Log::info('RD: ' . json_encode($request->all()));

    }
    Public function storeContent(Request $request, $msg = null)
    {
        $content = new Content();
        $content->from_number = $this->from_num;
        $content->to_number = $request->users[0];
        $content->content = $request->body;
        $content->sid = $msg->sid;
        $content->status =
        $content->save();
    }
    Public function read($sender)
    {
        $model = new Content();
        $res = $model::where('from_number', '=', $sender)
                       ->orderBy('id', 'asc')
                       ->get();
        return $res;
    }

    /**
     * Update sms status
     *
     */
    public function SmsStatus(Request $request) {

        \Log::info('INCOMMING: ' . json_encode($request->all()));

        if($request->SmsSid) {
            $content = Content::where('sid', $request->SmsSid)->first();
            if($content) {
                // if already we have a R status, we do change not anything
                if ($content->status == 'R') {

                } else { // other wise, we change the satus
                    $content->status = strtoupper(substr($request->SmsStatus, 0, 1));
                    $content->save();
                    \Log::info('UPDATED ' . $content->status);
                }

            } else {
                // It seems to be a new recieved sms
                $content = Content::where('to_number', $request->To)->latest()->first();

                if($content) {

                    $content->status = strtoupper(substr($request->SmsStatus, 0, 1));
                    $content->save();

                    $request['content_id'] = $content->id;
                    Reply::create($request->all());
                    \Log::info('CREATED ' . $content->status);
                }
            }

        }

    }
    /**
     * I have created 2 methods as you see
     */
    public function SentSmsStatus(Request $request) {
        if($request->SmsSid) {
            $content = Content::where('sid', $request->SmsSid)->first();
            if($content) {
                $content->status = $request->SmsStatus;
                $content->save();
                \Log::info('SentSmsStatus ' . $content->status);
            }
        }
    }

    /**
     *
     */
    public function IncommingSmsStatus(Request $request) {
        \Log::info('IncommingSmsStatus: ' . json_encode($request->all()));
        $content = Content::where('from_number', explode(':', $request->To)[1])->latest()->first();

        if($content) {
            $content->status = $request->SmsStatus;
            $content->save();

            $request['content_id'] = $content->id;
            $request['To'] = explode(':', $request->To)[1];
            $request['From'] = explode(':', $request->From)[1];
            Reply::create($request->all());
            \Log::info('CREATED ' . $content->status);
        }
    }
}
