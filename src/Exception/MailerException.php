<?php

namespace App\Exception;


class MailerException extends \Exception
{
    public static function transportFails($code)
    {
        return new self("Transport Failed, Code: {$code}");
    }
}
