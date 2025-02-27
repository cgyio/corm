<?php
/**
 * cgyio/resper Response 输出类
 * Code 直接输出 http_response_code 
 */

namespace Cgy\response\exporter;

use Cgy\response\Exporter;
use Cgy\Response;

class Code extends Exporter
{
    //所有可用 HTTP 响应 status
    public static $codes = [
        100 => "Continue", 
        101 => "Switching Protocols", 
        102 => "Processing", 
        200 => "OK", 
        201 => "Created", 
        202 => "Accepted", 
        203 => "Non-Authoritative Information", 
        204 => "No Content", 
        205 => "Reset Content", 
        206 => "Partial Content", 
        207 => "Multi-Status", 
        300 => "Multiple Choices", 
        301 => "Moved Permanently", 
        302 => "Found", 
        303 => "See Other", 
        304 => "Not Modified", 
        305 => "Use Proxy", 
        306 => "(Unused)", 
        307 => "Temporary Redirect", 
        308 => "Permanent Redirect", 
        400 => "Bad Request", 
        401 => "Unauthorized", 
        402 => "Payment Required", 
        403 => "Forbidden", 
        404 => "Not Found", 
        405 => "Method Not Allowed", 
        406 => "Not Acceptable", 
        407 => "Proxy Authentication Required", 
        408 => "Request Timeout", 
        409 => "Conflict", 
        410 => "Gone", 
        411 => "Length Required", 
        412 => "Precondition Failed", 
        413 => "Request Entity Too Large", 
        414 => "Request-URI Too Long", 
        415 => "Unsupported Media Type", 
        416 => "Requested Range Not Satisfiable", 
        417 => "Expectation Failed", 
        418 => "I'm a teapot", 
        419 => "Authentication Timeout", 
        420 => "Enhance Your Calm", 
        422 => "Unprocessable Entity", 
        423 => "Locked", 
        424 => "Failed Dependency", 
        424 => "Method Failure", 
        425 => "Unordered Collection", 
        426 => "Upgrade Required", 
        428 => "Precondition Required", 
        429 => "Too Many Requests", 
        431 => "Request Header Fields Too Large", 
        444 => "No Response", 
        449 => "Retry With", 
        450 => "Blocked by Windows Parental Controls", 
        451 => "Unavailable For Legal Reasons", 
        494 => "Request Header Too Large", 
        495 => "Cert Error", 
        496 => "No Cert", 
        497 => "HTTP to HTTPS", 
        499 => "Client Closed Request", 
        500 => "Internal Server Error", 
        501 => "Not Implemented", 
        502 => "Bad Gateway", 
        503 => "Service Unavailable", 
        504 => "Gateway Timeout", 
        505 => "HTTP Version Not Supported", 
        506 => "Variant Also Negotiates", 
        507 => "Insufficient Storage", 
        508 => "Loop Detected", 
        509 => "Bandwidth Limit Exceeded", 
        510 => "Not Extended", 
        511 => "Network Authentication Required", 
        598 => "Network read timeout error", 
        599 => "Network connect timeout error"
    ];

    public $contentType = "text/plain; charset=utf-8";
    public $status = 200;
    public $info = "OK";

    //准备输出的数据
    public function prepare()
    {
        $this->status = $this->response->status;
        return $this;
    }

    //改写 parent->export() 方法
    public function export()
    {
        http_response_code($this->status);
        exit;
    }

}