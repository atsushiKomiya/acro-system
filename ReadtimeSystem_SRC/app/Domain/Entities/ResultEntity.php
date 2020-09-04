<?php

namespace App\Domain\Entities;

class ResultEntity
{
    public $result;
    public $message;
    public $errorMessage;
    public $exception;

    public function __construct()
    {
        $this->result = false;
        $this->message = "";
        $this->errorMessage = "";
        $this->exception = null;
    }

    public function success(string $message = null)
    {
        $this->result = true;
        if ($message != null) {
            $this->message = $message;
        }
    }

    public function failure(string $message = null)
    {
        $this->result = false;
        if ($message != null) {
            $this->errorMessage = $message;
        }
    }
}
