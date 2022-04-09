<?php
namespace App\Helpers;

use App\Models\Log;

class Logger
{
    public static function info($subject, $action)
    {
        $log['level'] = 'info';
        $log['url'] = request()->fullUrl();
        $log['method'] = request()->method();
        $log['ip'] = request()->ip();
        $log['agent'] = request()->header('user-agent');
        $log['subject'] = get_class($subject);
        $log['subject_id'] = $subject->getOriginal('id');
        $log['causer_id'] = auth()->user()->id;
        $log['description'] = get_class($subject)." is ".$action;

        Log::create($log);
    }
}
