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
        $description = "Program Change From ".(optional($track->former_program($this->apiService))->name??"__PROG-NULL__")." To ".(optional($track->current_program($this->apiService))->name??"__PROG-NULL__")." BY ".($track->user->name??"__USER-NULL__").". On Applicant: ".($track->form->matric??'')."[".($track->form->name??'')."]";
        $log_message = "____________________".json_encode($data)."_________________________".$description."______________________";
        Log::channel('program_change')->info($log_message);
    }
}
