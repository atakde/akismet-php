<?php

declare(strict_types=1);

namespace Atakde\AkismetPhp\Exception;

use Exception;

class InvalidCheckType extends Exception
{
    public function __construct($message = 'Check type is invalid', $code = 500)
    {
        parent::__construct($message, $code);
    }
}
