<?php

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (QueryException $e) {
            if($e->getCode()==23000){
                $message='Foreign key constraint failed!';
            }else{
                $message=$e->getMessage();
            }
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['message'=>$e->getMessage()])
                ->with('info',$message);
        });
    })->create();
