<?php

namespace App\Console\Commands;

use App\Models\ApplicationForm;
use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FollowupApplicationPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'followupApplicationPayment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // For application Fee Payment
        // ------------------------------------
        $transactions = Transaction::where('status', 'pending')->get();
        foreach ($transactions as $key => $trans) {
            # code...
            try {
                $response = \Illuminate\Support\Facades\Http::get(env('TRANSACTION_STATUS_URL').'transaction_id='.$trans->transaction_id)->collect();
                if($response['status'] == 200){
                    $data = $response['data'];
                    if($data['status'] == "SUCCESSFUL"){
                        $trans->status = "SUCCESSFUL";
                        $trans->financialTransactionId = $response->collect('financialTransactionId');
                        $trans->save();

                        $form = ApplicationForm::where(['year_id'=>$trans->year_id, 'student_id'=>$trans->student_id])->first();
                        if($form == null){
                            return redirect(route('student.home'))->with('error', "Application form could not be found");
                        }
                        $form->update(['transaction_id'=>$trans->id]);
                    }elseif($data['status'] != "PENDING"){
                        $trans->delete();
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                Log::info($th->getTraceAsString());
                continue;
            }
        }



        // For Platform Charges payment
        // ---------------------------------------

        $tranzak_credentials = \App\Models\TranzakCredential::where('campus_id', 0)->first();
        \App\Models\PendingTranzakTransaction::each(function($record)use($tranzak_credentials){
            try {
                //code...

                goto PAYMENT;
                $tranzak_credentials = \App\Models\TranzakCredential::where('campus_id', 0)->first();
                if(cache($tranzak_credentials->cache_token_key) == null or now()->parse(cache($tranzak_credentials->cache_token_expiry_key))->isAfter(now())){
                    GEN_TOKEN:
                    $response = Http::post(config('tranzak.tranzak.base').config('tranzak.tranzak.token'), ['appId'=>$tranzak_credentials->app_id, 'appKey'=>$tranzak_credentials->api_key]);
                    if($response->status() == 200){
                        cache([$tranzak_credentials->cache_token_key => json_decode($response->body())->data->token]);
                        cache([$tranzak_credentials->cache_token_expiry_key=>now()->createFromTimestamp(time() + json_decode($response->body())->data->expiresIn)]);
                    }
                }

                PAYMENT:
                // Log::info(json_encode($record->toArray()));
                if(cache($tranzak_credentials->cache_token_key) == null){
                    goto GEN_TOKEN;
                }
                $url = config('tranzak.tranzak.base').config('tranzak.tranzak.transaction_details').$record->request_id;
                $headers = ['Authorization'=>'Bearer '.cache($tranzak_credentials->cache_token_key)];
                $response = Http::withHeaders($headers)->get($url);
                if($response->status() == 200){
                    if(($response_data = $response->collect('data')) != null){
                        Log::info("Debugger: P2");
                        if($response_data['status'] == "SUCCESSFUL"){
                            $transaction = [
                                'request_id'=>$response_data['requestId']??'', 'amount'=>$response_data['amount']??'', 
                                'currency_code'=>$response_data['currencyCode']??'', 'purpose'=>$response_data['payment_purpose']??'', 
                                'mobile_wallet_number'=>$response_data['mobileWalletNumber']??'', 
                                'transaction_ref'=>$response_data['mchTransactionRef']??'', 'app_id'=>$response_data['appId']??'', 
                                'transaction_id'=>$response_data['transactionId']??'', 'transaction_time'=>$response_data['transactionTime']??'', 
                                'payment_method'=>$response_data['payer']['paymentMethod']??'', 'payer_user_id'=>$response_data['payer']['userId']??'', 
                                'payer_name'=>$response_data['payer']['name']??'', 'payer_account_id'=>$response_data['payer']['accountId']??'', 
                                'merchant_fee'=>$response_data['merchant']['fee']??'', 'merchant_account_id'=>$response_data['merchant']['accountId']??'', 
                                'net_amount_recieved'=>$response_data['merchant']['netAmountReceived']??''
                            ];
                            
                            \App\Models\TranzakTransaction::updateOrInsert(['request_id'=> $response_data['requestId']], $transaction);
                            $transaction_instance = \App\Models\TranzakTransaction::where(['request_id'=> $response_data['requestId']])->first();
                            
                            Log::info("Debugger: P3");
                            // Assuming all tranzak transactions in BIAKA university are platform charges payment transactions
                            $data = ['student_id'=>$record->student_id, 'year_id'=>$record->batch_id, 'type'=>'PLATFORM', 'item_id'=>$record->payment_id, 'amount'=>$transaction_instance->amount, 'financialTransactionId'=>$transaction_instance->transaction_id, 'used'=>1];
                            $instance = new \App\Models\Charge($data);
                            $instance->save();
                            $student = \App\Models\Students::find($record->student_id);
                            $message = "Hello ".($student->name??'').", You have successfully paid a sum of ".($transaction_instance->amount??'')." as ".($record->description??'')." for ".($transaction_instance->year->name??'')." BIAKA UNIVERSITY INSTITUTE.";
                            \App\Http\Controllers\Controller::sendSmsNotificaition($message, [$student->phone]);
                        }
                        elseif($response_data['status'] != "PAYMENT_IN_PROGRESS"){
                            Log::info("Debugger: P4");
                            $record->delete();
                        }
                    }
                }
            } catch (\Throwable $th) {
                // throw $th;
                Log::info($th->getMessage());
                return;
            }

        });
    }
}
