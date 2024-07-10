<?php
namespace SimpleTest;

abstract class TestCase
{
    /** @var TestRunner */
    static public $testRunner;

    static public function assertSame($expected, $actual, $message = '')
    {
        if ($expected !== $actual) {
            self::$testRunner->fail("expected $expected but got $actual" . ($message ? ": $message" : ''));
        } else {
            self::$testRunner->succeed();
        }
    }
}
