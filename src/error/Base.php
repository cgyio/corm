<?php
/**
 * cgyio/resper 错误定义类
 * 系统错误
 * Base error
 */

namespace Cgy\error;

use Cgy\Error;

class Base extends Error
{
    /**
     * error code prefix
     * should be overrided
     */
    protected $codePrefix = "001";

    /**
	 * errors config
	 * should be overrided
	 */
	protected $config = [
        
        "zh-CN" => [
            "unknown"   => ["未知错误",             "发生未知错误"],
            "php"       => ["PHP 系统错误",         "%{1}%"],
            "fatal"     => ["PHP Fatal Error",     "%{1}%"],
            "custom"    => ["发生错误",             "%{1}%"],
            "auth"      => ["权限验证失败",         "%{1}%"],
            "resper"    => ["Resper 框架启动失败",  "%{1}%"],
            "orm"       => ["ORM 错误",             "%{1}%"],
        ]
        
	];
}