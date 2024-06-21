<?php

namespace App\Http\Resources;

use App\Helpers\Helpers;
use App\Models\ProgramLevel;
use App\Models\Students;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResourceMain extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $stud = Students::find($this->id);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone'=>$this->phone,
            'show_link' => route('admin.student.show',[$this->id]),
            'edit_link' => route('admin.student.edit', [$this->id]),
            'password_reset' => route('admin.student.password.reset',[$this->id]),
            
        ];
    }
}
