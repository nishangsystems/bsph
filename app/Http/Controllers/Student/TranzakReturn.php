<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\PendingTranzakTransaction;
use Illuminate\Http\Request;

class TranzakReturn extends Controller
{
    //

    public function callback(Request $request){
        if(($response_data = $request->resource) != null){
            $record = PendingTranzakTransaction::where('request_id', $response_data['requestId'])->first();
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
                if(\App\Models\TranzakTransaction::where('request_id', $response_data['requestId'])->count() == 0){
                    $transaction_instance = new \App\Models\TranzakTransaction($transaction);
                    $transaction_instance->save();
                }else{
                    $transaction_instance = \App\Models\TranzakTransaction::where('request_id', $response_data['requestId'])->first();
                }


                // Assuming all tranzak transactions in BSPH university are platform charges payment transactions
                $data = ['student_id'=>$record->student_id, 'year_id'=>$record->batch_id, 'type'=>'PLATFORM', 'item_id'=>$record->payment_id, 'amount'=>$transaction_instance->amount, 'financialTransactionId'=>$transaction_instance->transaction_id, 'used'=>1];
                $instance = new \App\Models\Charge($data);
                $instance->save();
                $student = \App\Models\Students::find($record->student_id);
                $message = "Hello ".($student->name??'').", You have successfully paid a sum of ".($transaction_instance->amount??'')." as ".($record->description??'')." for ".($transaction_instance->year->name??'')." BSPH UNIVERSITY INSTITUTE.";
                $this->sendSmsNotificaition($message, [$student->phone]);
            }
            elseif($response_data['status'] != "FAILED"){
                $record->delete();
            }
        }
    }
}
