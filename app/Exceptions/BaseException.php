<?php

namespace App\Exceptions;

use App\Utils\Result;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Support\Facades\Log;

class BaseException extends Exception
{
    use ApiResponser;

    protected $errors = [];
    protected $message = '';
    protected $code;

    public function __construct($code = Result::OK, $message = null, $errors = [])
    {
        parent::__construct($message, $code);
        
        $this->code = $code;
        $this->message = $message ?: Result::$resultMessage[$code];
        $this->errors = $errors;
    }

    public function render($request)
    {
        return $this->errorResponse($this->code, $this->message, $this->errors);
    }

    public function getBaseErrors() {
        return $this->errors;
    }

    public function report()
    {
        Log::emergency($this->message);
    }
}
