<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // $this->reportable(function (Throwable $e) {
        //     // catch and return error messages without throwing exceptions
        //     Log::info($e->getMessage());
        //     session()->flash('error', $e->getMessage());
        //     return redirect(route('admin.home'))->withInput();
        // });

        $this->renderable(function (\Exception $e) {
            if ($e->getPrevious() instanceof \Illuminate\Session\TokenMismatchException) {
                return redirect()->route('login');
            };
            if ($e instanceof \GuzzleHttp\Exception\ServerException) {
                # code...
                return redirect(route('admin.home'));
            }
            // return $e;
            session()->flash('error', "F::{$e->getFile()}, L::{$e->getLine()}, M::{$e->getMessage()}");
            return back()->withInput();
        });
        
    }
}
