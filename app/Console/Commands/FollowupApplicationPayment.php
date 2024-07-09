<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Illuminate\Console\Command;

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
        $transactions = Transaction::where('status', 'pending')->get();
        foreach ($transactions as $key => $trans) {
            # code...
            try {
                $response = \Illuminate\Support\Facades\Http::get(env('TRANSACTION_STATUS_URL').'transaction_id='.$trans->transaction_id)->collect();
                if($response['status'] == 200){
                    $data = $response['data'];
                    if($data['status'] == "SUCCESSFUL")
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
}
