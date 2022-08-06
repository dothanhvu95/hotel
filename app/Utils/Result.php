<?php

namespace App\Utils;

class Result
{
    const OK = 0001;
    const VALIDATE_ERROR = 203;
    const TOKEN_IS_EXPIRED = 300;
    const TOKEN_IS_INVALID = 301;
    const TOKEN_IS_NOT_FOUND = 302;
    const TOKEN_BLACKLISTED_EXCEPTION = 303;
 
    public static $resultMessage = [
        self::OK => 'Ok',
        self::VALIDATE_ERROR => 'Validate error',
        self::TOKEN_IS_EXPIRED => 'Hiện tại phiên đăng nhập của bạn đã hết hạn, bạn vui lòng đăng nhập lại.',
        self::TOKEN_IS_INVALID => 'Token is invalid',
        self::TOKEN_BLACKLISTED_EXCEPTION => 'Token can not be used, get new one',
        self::TOKEN_IS_NOT_FOUND => 'Authorization Token not found',
        
    ];
}
