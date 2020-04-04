<?php

namespace Imp\Framework\Monitor;

/**
 * Class MMTMonitor
 * @package Imp\Monitor
 */
class MMTMonitor
{

    /**
     * @var integer
     */
    private static $startMemory;

    /**
     * @var integer
     */
    private static $startPeakMemory;

    /**
     * @var integer
     */
    private static $currentMemory;

    /**
     * @var integer
     */
    private static $currentPeakMemory;

    /**
     * @var array
     */
    private static $points;

    /**
     * @var int
     */
    private static $pointKey = 0;


    /**
     * initialize
     * @param bool $realUsage
     */
    public static function initialize($realUsage = false)
    {
        self::$startMemory     = memory_get_usage($realUsage);
        self::$startPeakMemory = memory_get_peak_usage($realUsage);

        $trace = self::getDebugBackTrace();
        self::$points[self::$pointKey] = array(
            'memory'        => self::$startMemory,
            'peakMemory'    => self::$startPeakMemory,
            'point'         => $trace['point'],
            'time'          => microtime(true),
        );
    }

    /**
     * @param null $name
     * @return int|null
     */
    public static function tracePoint($name = null)
    {
        $name  = $name && !isset(self::$points[$name]) ? $name : self::$pointKey + 1;
        $trace = self::getDebugBackTrace();

        self::$points[$name] = array(
            'memory'        => memory_get_usage(),
            'peakMemory'    => memory_get_peak_usage(),
            'point'         => $trace['point'],
            'time'          => microtime(true),
        );

        self::$pointKey++;
    }

    /**
     * @return string
     */
    public static function trace()
    {
        $info = "\r\n";
        $eof  = (php_sapi_name() != 'cli') ? "<Br>" : "\r\n";
        $lastTime = 0;
        $firstTime = 0;
        foreach (self::$points as $name => $point) {
            if ($lastTime == 0) {
                $firstTime = $lastTime = $point['time'];
            }
            $timeCost   = ($point['time'] - $lastTime) * 1000;
            $memory     = round($point['memory'] / 1024, 3) . 'KB';
            $peakMemory = round($point['peakMemory'] / 1024, 3) . 'KB';
            $info .= "[imp-monitor] name#{$name} ----- memory: {$memory} - peakMemory: {$peakMemory} - time: {$point['time']} - timeCost: {$timeCost} - point: {$point['point']}" . $eof;

            $lastTime  = $point['time'];
        }

        $totalTime = ($lastTime - $firstTime) * 1000;
        $info .= "[imp-monitor] TOTAL ----- time: {$totalTime}";

        if (php_sapi_name() != 'cli') {
            $info = "<div style='background: #F1F1F1; border-radius: 4px; border: 5px dashed #ccc; padding: 10px;'>" . $info . "</div>";
        }

        return $info;
    }

    /**
     * getDebugBackTrace
     * @return array
     */
    public static function getDebugBackTrace()
    {
        // $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 3);
        $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        $count  = count($traces);
        $trace  = isset($traces[$count - 1]) ? $traces[$count - 1] : array();
        $point  = '';
        if (isset($trace['file'])) {
            $point = $trace["file"] . "#line: " . $trace['line'];
            if ($count > 2 && isset($trace['function'])) {
                $point .= " #function: " . $trace['function'];
            }
        } elseif (isset($trace['class'])) {
            $point = $trace["class"] . "::" . $trace['function'];
        }

        $data = array(
            'point' => $point,
            'type'  => isset($trace['type']) ? $trace['type'] : "",
        );

        return $data;
    }

    /**
     * destory
     */
    public static function destory()
    {
        self::$startMemory          = 0;
        self::$startPeakMemory      = 0;
        self::$currentMemory        = 0;
        self::$currentPeakMemory    = 0;
        self::$points               = array();
        self::$pointKey             = 0;
    }
}