<?php namespace App\Config;

class SystemLogPriorityType extends EnumType
{

    public const LOW = "LOW";
    public const NORMAL = "NORMAL";
    public const HIGH = "HIGH";

    protected static string $name = 'system_log_priority';

}