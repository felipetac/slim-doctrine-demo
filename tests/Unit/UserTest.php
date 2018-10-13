<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\User;

class UserTest extends TestCase
{
    public function testPasswordIsHashedWithBcrypt(): void
    {
        $sut = new User('john.doe@example.com', $plainPwd = 'abcd');
        self::assertTrue(password_verify($plainPwd, $sut->getHash()));
    }
}