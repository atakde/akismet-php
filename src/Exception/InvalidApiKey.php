<?php

declare(strict_types=1);

namespace Atakde\AkismetPhp\Exception;

use Exception;

class InvalidApiKey extends Exception
{
    public function __construct($message = 'Akismet key is required', $code = 500)
    {
        parent::__construct($message, $code);
    }
}
