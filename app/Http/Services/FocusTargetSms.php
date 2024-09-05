<?php

namespace App\Http\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;


class FocusTargetSms implements ShouldQueue{
    use Queueable;

    protected $recipients, $message;
    private $api_base = "https://smsvas.com/bulk/public/index.php/api/v1/sendsms";
    private $api_password = '@Letme1n!';
    private $api_user = 'errandia310@gmail.com';
    private $sender_id = 'BUIB';
    
    public function __construct($recipients, string $message)
    {
        # code...
        $this->message = $message;
        $this->recipients = is_array($recipients) ? implode(',', $recipients) : $recipients;
    }

    /**
     * @Annotation sends the SMS message to the specified contacts
     * @return bool|string; 1 if the message is successfully sent or the error message otherwise.
     */
    public function send()
    {
        # code...
        $response = Http::withHeaders(['content-type'=>'application/json', 'accept'=>'application/json'])
            ->post($this->api_base, [
                "user" => $this->api_user, 
                "password" => $this->api_password, 
                "senderid" => $this->sender_id,
                "sms" => $this->message,
                "mobiles" => $this->recipients
       ]);

       if($response->successful()){
        if(json_decode($response->body())->responsecode == 1){
            return true;
        }else{return json_decode($response->body())->responsedescription;}
       }else{
        return $response->body();
       }
    }
}