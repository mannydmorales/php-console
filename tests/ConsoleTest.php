<?php

use PHPUnit\Framework\TestCase;
use mannydmorales\Console\Console;

class ConsoleTest extends TestCase {

    public function testIsWindows() {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $this->assertTrue(Console::isWindows());
        } else {
            $this->assertFalse(Console::isWindows());
        }
    }

    public function testIsMac() {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'DAR') {
            $this->assertTrue(Console::isMac());
        } else {
            $this->assertFalse(Console::isMac());
        }
    }

    public function testIsLinux() {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'LIN') {
            $this->assertTrue(Console::isLinux());
        } else {
            $this->assertFalse(Console::isLinux());
        }
    }

    public function testIsUnix() {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'DAR' || strtoupper(substr(PHP_OS, 0, 3)) === 'LIN') {
            $this->assertTrue(Console::isUnix());
        } else {
            $this->assertFalse(Console::isUnix());
        }
    }

    public function testGetOSType() {
        $osType = Console::getOSType();
        if(Console::isWindows()) {
            $this->assertEquals('Windows', $osType);
        } else if(Console::isMac()) {
            $this->assertEquals('Mac', $osType);
        } else if(Console::isLinux()) {
            $this->assertEquals('Linux', $osType);
        } else {
            $this->assertFalse($osType);
        }
    }

    public function testColor() {
        $coloredMessage = Console::color('Hello, World!', Console::TEXT_COLOR_RED);
        $this->assertEquals("\033[31mHello, World!\033[0m", $coloredMessage);
    }

    public function testStyle() {
        $styledMessage = Console::style('Hello, World!', Console::TEXT_FORMAT_BOLD);
        $this->assertEquals("\033[1mHello, World!\033[0m", $styledMessage);
    }

    public function testStartStyle() {
        $startStyle = Console::startStyle(Console::TEXT_FORMAT_BOLD, Console::OUTPUT_RETURN);
        $this->assertEquals("\033[1m", $startStyle);
    }

    public function testEndStyle() {
        $endStyle = Console::endStyle(Console::OUTPUT_RETURN);
        $this->assertEquals("\033[0m", $endStyle);
    }

    public function testGetConsoleSize() {
        $size = Console::getConsoleSize();
        $this->assertArrayHasKey('width', $size);
        $this->assertArrayHasKey('height', $size);
    }

    public function testGetUsageTable() {
        $usage = [
            ['command1', 'description1'],
            ['command2', 'description2']
        ];
        $table = Console::getUsageTable($usage);
        $this->assertStringContainsString('command1', $table);
        $this->assertStringContainsString('description1', $table);
        $this->assertStringContainsString('command2', $table);
        $this->assertStringContainsString('description2', $table);
    }
}