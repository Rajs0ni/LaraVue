<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('api', function ($data) {
            $error = null;
            if ($data instanceof \Exception) {
                $e = $data;

                $error = new \stdClass();
                $error->title = $e->title ?? 'Error !';
                $error->type = class_basename($data);
                $error->message = $e->getMessage();
                $error->code = $e->getCode();
                $error->remedy =
                    $e->remedy ?? 'Please Retry (or) Report to Support Team !';
                $error->validation = $e->validation ?? null;

                if (config('app.debug')) {
                    $error->details = "File:{$e->getFile()} | Line:{$e->getLine()}";
                    $error->trace = explode("\n", $e->getTraceAsString());
                }
            }

            $customFormat = [
                'data' => $error ? [] : $data,
                'error' => $error ?? null
            ];
            return Response::make($customFormat);
        });
    }
}
