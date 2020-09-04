<?php

namespace App\Providers;

use DB;
use App;
use Log;
use Event;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Database\Events\TransactionRolledBack;

class DataBaseQueryServiceProvider extends ServiceProvider
{
    const CHANNEL = 'dblog';
    const ENABLE_ENVIRONMENT = [
        'local',
        'develop',
        'staging',
        'production',
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if (config('app.debug') === false) {
            return;
        }

        if (in_array(App::environment(), self::ENABLE_ENVIRONMENT, true) === false) {
            return;
        }

        DB::listen(function ($query) {
            $sql = $query->sql;
            foreach ($query->bindings as $binding) {
                if (is_string($binding)) {
                    $binding = "'{$binding}'";
                } elseif ($binding === null) {
                    $binding = 'NULL';
                } elseif ($binding instanceof Carbon) {
                    $binding = "'{$binding->toDateTimeString()}'";
                } elseif ($binding instanceof DateTime) {
                    $binding = "'{$binding->format('Y-m-d H:i:s')}'";
                }

                $sql = preg_replace("/\?/", $binding, $sql, 1);
            }

            // $sql = str_replace("\"", "", $sql);

            Log::channel($this::CHANNEL)->debug('SQL', ['sql' => $sql, 'time' => "$query->time ms"]);
        });

        Event::listen(TransactionBeginning::class, function (TransactionBeginning $event) {
            Log::channel($this::CHANNEL)->debug('START TRANSACTION');
        });

        Event::listen(TransactionCommitted::class, function (TransactionCommitted $event) {
            Log::channel($this::CHANNEL)->debug('COMMIT');
        });

        Event::listen(TransactionRolledBack::class, function (TransactionRolledBack $event) {
            Log::channel($this::CHANNEL)->debug('ROLLBACK');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
