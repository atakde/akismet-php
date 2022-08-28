<?php

declare(strict_types=1);

use Atakde\AkismetPhp\AkismetPhp;
use Atakde\AkismetPhp\Exception\InvalidApiKey;
use Atakde\AkismetPhp\Exception\InvalidCheckType;
use Atakde\AkismetPhp\Exception\InvalidResponseException;
use PHPUnit\Framework\TestCase;

final class CheckExceptionsTest extends TestCase
{
    public function testApiKeyException()
    {
        $this->expectException(InvalidApiKey::class);
        $this->expectExceptionMessage('Akismet key is required');
        $this->expectExceptionCode(500);
        $akismet = new AkismetPhp();
        $akismet->checkSpam();
    }

    public function testInvalidCheckTypeException()
    {
        $this->expectException(InvalidCheckType::class);
        $this->expectExceptionMessage('Check type is invalid');
        $this->expectExceptionCode(500);
        $akismet = new AkismetPhp();
        $akismet->setAkismetKey('TEST_KEY')->setCheckType('INVALID_CHECK_TYPE');
        $akismet->checkSpam();
    }

    public function testInvalidResponseException()
    {
        $this->expectException(InvalidResponseException::class);
        $this->expectExceptionMessage('Error: Missing required field: blog.');
        $this->expectExceptionCode(500);
        $akismet = new AkismetPhp();
        $akismet->setAkismetKey('TEST_KEY');
        $akismet->checkSpam();
    }
}
