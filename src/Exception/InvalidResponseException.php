<?php

declare(strict_types=1);

namespace Atakde\AkismetPhp\Exception;

use Exception;

class InvalidResponseException extends Exception
{
    public function __construct($message = 'Invalid response!', $code = 500)
    {
        parent::__construct($message, $code);
    }
}
