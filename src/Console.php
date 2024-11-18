<?php

/**
 * Console - Utility class for interacting with the console
 * 
 * This class provides utility methods for generating console output
 *
 * @package Console
 * @version 2.0.0
 * @file    Console.php
 * 
 * @see https://opensource.mannydmorales.com/console The Console Project Homepage
 *
 * @author    Manny Morales <mannydmorales@gmail.com>
 * @copyright 2007 - 2024 Manny D Morales
 * @license   MIT License
 * @note      This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace mannydmorales\Console;

class Console {

    // Output Options
    public const OUTPUT_STDOUT = 1;
    public const OUTPUT_STDERR = 2;
    public const OUTPUT_RETURN = 3; // Not supported by all output functions

    // Console Format Codes for Text Color
    public const TEXT_COLOR_DEFAULT         = 39;
    public const TEXT_COLOR_BLACK           = 30;
    public const TEXT_COLOR_RED             = 31;
    public const TEXT_COLOR_GREEN           = 32;
    public const TEXT_COLOR_YELLOW          = 33;
    public const TEXT_COLOR_BLUE            = 34;
    public const TEXT_COLOR_MAGENTA         = 35;
    public const TEXT_COLOR_CYAN            = 36;
    public const TEXT_COLOR_LIGHTGRAY       = 37;
    public const TEXT_COLOR_DARKGRAY        = 90;
    public const TEXT_COLOR_LIGHTRED        = 91;
    public const TEXT_COLOR_LIGHTGREEN      = 92;
    public const TEXT_COLOR_LIGHTYELLOW     = 93;
    public const TEXT_COLOR_LIGHTBLUE       = 94;
    public const TEXT_COLOR_LIGHTMAGENTA    = 95;
    public const TEXT_COLOR_LIGHTCYAN       = 96;
    public const TEXT_COLOR_WHITE           = 97;

    // Console Format Codes for Text Style
    public const TEXT_FORMAT_BOLD           = 1;
    public const TEXT_FORMAT_DIM            = 2;
    public const TEXT_FORMAT_UNDERLINE      = 4;
    public const TEXT_FORMAT_BLINK          = 5;
    public const TEXT_FORMAT_INVERT         = 7;
    public const TEXT_FORMAT_HIDDEN         = 8;

    // Console Format Codes for Text Background Color
    public const TEXT_BG_DEFAULT            = 49;
    public const TEXT_BG_BLACK              = 40;
    public const TEXT_BG_RED                = 41;
    public const TEXT_BG_GREEN              = 42;
    public const TEXT_BG_YELLOW             = 43;
    public const TEXT_BG_BLUE               = 44;
    public const TEXT_BG_MAGENTA            = 45;
    public const TEXT_BG_CYAN               = 46;
    public const TEXT_BG_LIGHTGRAY          = 47;
    public const TEXT_BG_DARKGRAY           = 100;
    public const TEXT_BG_LIGHTRED           = 101;
    public const TEXT_BG_LIGHTGREEN         = 102;
    public const TEXT_BG_LIGHTYELLOW        = 103;
    public const TEXT_BG_LIGHTBLUE          = 104;
    public const TEXT_BG_LIGHTMAGENTA       = 105;
    public const TEXT_BG_LIGHTCYAN          = 106;
    public const TEXT_BG_WHITE              = 107;

    // OS Types
    public const OS_TYPE_WINDOWS            = "WIN";
    public const OS_TYPE_LINUX              = "LIN";
    public const OS_TYPE_MAC                = "DAR";

    // OS Type Names
    public const OS_TYPE                    = array(
        self::OS_TYPE_WINDOWS   => "Windows",
        self::OS_TYPE_LINUX     => "Linux",
        self::OS_TYPE_MAC       => "Mac"
    );

    // Cached console size
    public static $consoleSize = array('width' => 0, 'height' => 0);

    /**
     * Check if the current OS is Windows
     * @return bool 
     */
    public static function isWindows() : bool {
        return strtoupper(substr(PHP_OS, 0, 3)) === self::OS_TYPE_WINDOWS;
    }

    /**
     * Check if the current OS is Windows
     * @return bool 
     */
    public static function isMac() : bool {
        return strtoupper(substr(PHP_OS, 0, 3)) === self::OS_TYPE_MAC;
    }

    /**
     * Check if the current OS is Windows
     * @return bool 
     */
    public static function isLinux() : bool {
        return strtoupper(substr(PHP_OS, 0, 3)) === self::OS_TYPE_LINUX;
    }

    /**
     * Check if the current OS is Unix (Mac or Linux)
     * @return bool 
     */
    public static function isUnix() : bool {
        return self::isMac() || self::isLinux();
    }

    /**
     * Get the current OS type
     * @return string|false Will return false if the OS type is not Windows, Mac, or Linux
     */
    public static function getOSType() : string|false {
        if(self::isWindows()) {
            return self::OS_TYPE[self::OS_TYPE_WINDOWS];
        } elseif(self::isMac()) {
            return self::OS_TYPE[self::OS_TYPE_MAC];
        } elseif(self::isLinux()) {
            return self::OS_TYPE[self::OS_TYPE_LINUX];
        }
        return false;
    }

    /**
     * Write a message to the standard output
     * @param string $message 
     * @return void 
     */
    public static function stdout(string $message) : void {
        file_put_contents('php://stdout', $message);
    }

    /**
     * Write a message to the standard error output
     * @param string $message 
     * @return void 
     */
    public static function stderror(string $message) : void {
        file_put_contents('php://stderr', $message);
    }

    /**
     * Write a message to the standard output
     * @param string ...$messages 
     * @return void 
     */
    public static function out(string ...$messages) : void {
        foreach($messages as $message) {
            self::stdout($message);
        }
    }

    /**
     * Write a message to the standard output or standard error
     * @param int $output 
     * @param string ...$messages 
     * @return void 
     */
    public static function outStream(int $output, string ...$messages) : void {
        if($output === self::OUTPUT_STDERR) {
            self::out(...$messages);
        } elseif($output === self::OUTPUT_STDOUT) {
            self::error(...$messages);
        } else {
            return;
        }
    }

    /**
     * Write a message to the standard output (alias for out)
     * @param string ...$messages 
     * @return void 
     */
    public static function echo(string ...$messages) : void {
        self::out(...$messages);
    }

    /**
     * Write a message to the standard output (alias for out)
     * @param string ...$messages 
     * @return void 
     */
    public static function print(string ...$messages) : void {
        self::out(...$messages);
    }

    /**
     * Write a message to the standard output adding a newline at the end
     * @param string ...$messages 
     * @return void 
     */
    public static function println(string ...$messages) : void {
        foreach($messages as $message) {
            self::stdout($message."\n");
        }
    }

    /**
     * Write a message to the standard error output
     * @param string ...$messages 
     * @return void 
     */
    public static function error(string ...$messages) : void {
        foreach($messages as $message) {
            self::stderror($message);
        }
    }

    /**
     * Get a formatted message with color
     * @param string $message 
     * @param int $textColor 
     * @return string 
     */
    public static function color(string $message, int $textColor) : string {
        return "\033[".$textColor."m".$message."\033[0m";
    }

    /**
     * Get a formatted message with style
     * @param string $message 
     * @param int|array<int,int> $style 
     * @return string 
     */
    public static function style(string $message, int|array $style) : string {
        if(is_array($style)) {
            $style = implode(';', $style);
        }
        return "\033[".$style."m".$message."\033[0m";
    }

    /**
     * Start a style
     * @param int|array<int,int> $style 
     * @param int $output 
     * @return string|true 
     */
    public static function startStyle(int|array $style, int $output = self::OUTPUT_STDOUT) : string|true {
        if(is_array($style)) {
            $style = implode(';', $style);
        }
        if($output === self::OUTPUT_RETURN) {
            return "\033[".$style."m";
        }
        self::outStream($output, "\033[".$style."m");
        return true;
    }

    /**
     * End a style
     * @param int $output 
     * @return string|true 
     */
    public static function endStyle(int $output = self::OUTPUT_STDOUT) : string|true {
        if($output === self::OUTPUT_RETURN) {
            return "\033[0m";
        }
        self::outStream($output, "\033[0m");
        return true;
    }

    /**
     * Get the size of the console. If the size is already known, it will return the cached value unless refresh is set to true
     * @param bool $refresh 
     * @param int $width Default width to return if the console size cannot be determined
     * @param int $height Default height to return if the console size cannot be determined
     * @return array<string,int>
     */
    public static function getConsoleSize(bool $refresh = false, int $width = 80, int $height = 80) : array {
        if(self::$consoleSize['width'] > 0 && self::$consoleSize['height'] > 0 && $refresh === false) {
            return self::$consoleSize;
        }
        if(self::isWindows()) {
            self::$consoleSize['width'] = intval(exec('mode CON'));
            self::$consoleSize['height'] = intval(exec('mode CON'));
        } else {
            self::$consoleSize['width'] = intval(exec('tput cols'));
            self::$consoleSize['height'] = intval(exec('tput lines'));
        }
        if(self::$consoleSize['width'] <= 0) {
            self::$consoleSize['width'] = $width;
        }
        if(self::$consoleSize['height'] <= 0) {
            self::$consoleSize['height'] = $height;
        }
        return self::$consoleSize;
    }

    /**
     * Clear the screen. This will work on Windows and Unix systems
     * @return void 
     */
    public static function clearScreen() : void {
        if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            system('cls');
        } else {
            system('clear');
        }
    }

    /**
     * Get a formatted table. The headers should be an array of strings. The rows should be an array of arrays of strings.
     * @param array<int,array<int,string>> $usage 
     * @param array<int,string> $headers 
     * @return string 
     */
    public static function getUsageTable(array $usage, array $headers = array("Command","Description")) : string {
        $maxWidth = self::getConsoleSize()['width'];
        // Calculate the width of each column
        $columnWidths = array(0,0);
        foreach($headers as $hrow) {
            $columnWidths[0] = max($columnWidths[0], strlen($hrow[0]));
        }
        foreach($usage as $row) {
            $columnWidths[0] = max($columnWidths[0], strlen($row[0]));
        }
        $columnWidths[0] = $columnWidths[0] + 3;
        $columnWidths[1] = $maxWidth - $columnWidths[0] - 3;
        // Create the table
        $table = '';
        $table .= str_repeat('-', $maxWidth)."\n";
        if(!is_null($headers)) {
            $table .= ' '.str_pad($headers[0], $columnWidths[0], ' ', STR_PAD_RIGHT).' '.str_pad($headers[1], $columnWidths[1], ' ', STR_PAD_RIGHT)."\n";
            $table .= str_repeat('-', $maxWidth)."\n";
        }
        foreach($usage as $row) {
            $table .= ' '.self::style(str_pad($row[0], $columnWidths[0], ' ', STR_PAD_RIGHT),self::TEXT_FORMAT_BOLD).' ';
            $wrap = wordwrap($row[1], $columnWidths[1], "\n", true);
            $lines = explode("\n", $wrap);
            $lineNo = 0;
            foreach($lines as $line) {
                if($lineNo > 0) {
                    $table .= ' '.str_pad('', $columnWidths[0], ' ', STR_PAD_RIGHT).' ';
                }
                $table .= $line."\n";
                $lineNo++;
            }
        }
        return $table;
    }

}