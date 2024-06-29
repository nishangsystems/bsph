<?php

namespace App\Listeners;

use App\Http\Services\ApiService;
use App\Models\ProgramChangeTrack;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProgramChangeListener 
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $apiService;
    public function __construct(ApiService $apiService)
    {
        //
        $this->apiService = $apiService;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        
        $data = ['former_program'=>$event->former_program, 'current_program'=>$event->current_program, 'form_id'=>$event->form_id, 'user_id'=>$event->user_id, 'created_at'=>now()];
        $track = new ProgramChangeTrack($data);
        $track->save();
        $cprog = json_decode($this->apiService->programs($event->current_program))->data??null;
        $fprog = json_decode($this->apiService->programs($event->former_program))->data??null;
        $current_program_name = $cprog == null ? "" : $cprog->name??'';
        $former_program_name = $fprog == null ? "" : $fprog->name??'';
        $description = "Program Change From ".$former_program_name." To ".$current_program_name." BY ".($track->user->name??"__USER-NULL__").". On Applicant: ".($track->form->matric??'')."[".($track->form->name??'')."]";
        $log_message = "____________________".json_encode($data)."_________________________".$description."______________________";
        Log::channel('program_change')->info($log_message);
    }
}
