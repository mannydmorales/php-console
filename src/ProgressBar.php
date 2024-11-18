<?php

/**
 * Console - Utility class for interacting with the console
 * 
 * This class provides utility methods for generating and interacting with a console progress bar
 *
 * @package Console
 * @version 2.0.0
 * @file    ProgressBar.php
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

class ProgressBar {

    /** @var string The Glyph to display for a complete step */
    public static $glyphComplete                = '▓';

    /** @var string The Glyph to display for an incomplete step */
    public static $glyphPending                 = '░';

    /** @var bool Display a complete progress bar on completion (if true) or a label (if false) */
    public static $displayProgressBarComplete   = false;

    /** @var array<int,int> List of format attributes if displaying a complete label instead of complete progress bar */
    public static $labelCompleteFormat          = array(Console::TEXT_COLOR_GREEN, Console::TEXT_FORMAT_BOLD);

    /** @var string The label to display if displaying a complete label instead of complete progress bar */
    public static $labelCompleteText            = "Complete";

    /** @var array<int,int> List of format attributes if displaying a failed label instead of complete progress bar */
    public static $labelFailedFormat            = array(Console::TEXT_COLOR_RED, Console::TEXT_FORMAT_BOLD);

    /** @var array<int,string> Spinner Glyphs */
    protected array $spinners                   = array('|', '/', '-', '\\', '|', '/', '-', '\\');

    /** @var int The number of steps to display */
    protected int $steps                        = 60;

    /** @var int the total of available progress */
    protected int $total                        = 100;

    /** @var int the total of progress completed so far */
    protected int $complete                     = -1;

    /** @var string The text to display on complete */
    protected string $completeText;

    /**
     * Construct the Progress Bar
     * 
     * @param int $total Total available progress - Default is 100
     * @param int $steps Total steps to display on screen - Default is 60
     * @param ?string $completeText The text to display on completion - Default is null and will use the static default label
     * @throws \Exception If not in cli will throw
     */
    public function __construct(int $total = 100, int $steps = 60, ?string $completeText = null) {
        if(PHP_SAPI != 'cli') {
            throw new \Exception('Progress bar only available in CLI application');
        }
        $this->total = $total;
        $this->steps = $steps;
        $this->completeText = (is_null($completeText)) ? self::$labelCompleteText : $completeText;
    }

    /**
     * Display Complete
     * 
     * @return void
     */
    public function complete() : void {
        if(self::$displayProgressBarComplete === true) {
            Console::out("Progress: [".str_repeat(self::$glyphComplete, $this->steps + 1)."] 100%".PHP_EOL);
        } else {
            $screenSize = Console::getConsoleSize();
            Console::out(Console::style(str_pad($this->completeText, ((($screenSize['width'] - 1) > 0) ? ($screenSize['width'] - 1):($this->steps + 20)), " ", STR_PAD_RIGHT), self::$labelCompleteFormat).PHP_EOL);
        }
    }

    /**
     * Display Failed
     * @param string $message The message to display on failure
     * @param bool $stderr If true will display on stderr, if false will display on stdout
     * @return void
     */
    public function failed(string $message = "Failed", bool $stderr = true) : void {
        $screenSize = Console::getConsoleSize();
        $out = Console::style(str_pad($message, ((($screenSize['width'] - 1) > 0) ? ($screenSize['width'] - 1):($this->steps + 20)), " ", STR_PAD_RIGHT), self::$labelFailedFormat).PHP_EOL;
        if($stderr) {
            Console::error($out);
        } else {
            Console::out($out);
        }
    }

    /**
     * Update Progress and print 
     * 
     * @param ?int $complete the total amount complete out of the total value. If null will auto increment by 1
     * @param bool $showSpinner Show the spinner glyph. Default true
     * @return void
     */
    public function progress(?int $complete = null, bool $showSpinner = true) : void {
        if($complete === null) {
            $complete = ($this->complete + 1);
        }
        $this->complete = $complete;
        if($this->complete >= $this->total) {
            $this->complete();
            return;
        } else {
            $remaining = floor((1 - ($complete / $this->total)) * $this->steps);
            $progressBar = str_repeat(self::$glyphComplete, $this->steps - $remaining);
            $percent = str_pad(intval((($complete / $this->total) * 100)), 3, " ", STR_PAD_LEFT) . "%";
            $empty = str_repeat(self::$glyphPending, $remaining);
            $index = $complete % 8;
            $filler = ($showSpinner) ? $this->spinners[$index] : self::$glyphPending;
            $disp = "Progress: [" . $progressBar . $filler . $empty . "] ".$percent."\r";
        }
        console::out($disp);
    }

}