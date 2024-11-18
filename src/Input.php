<?php

/**
 * Console - Utility class for interacting with the console
 * 
 * This class provides utility methods for generating and accessing console input
 *
 * @package Console
 * @version 2.0.0
 * @file    Input.php
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

class Input {

    /**
     * Read input from the command line
     * @return string|false
     */
    public static function read() : string|false {
        return trim(fgets(STDIN));
    }

    /**
     * Get input from the command line (alias for read)
     * @return string|false
     * @see read()
     */
    public static function get() : string|false {
        return self::read();
    }

    /**
     * Read a password from the command line
     * @return string|false
     */
    public static function password() : string|false {
        return trim(shell_exec('stty -echo; read pwd; stty echo; echo $pwd'));
    }

    /**
     * Prompt the user for input
     * @param string $message The message to display
     * @param string|null $default The default value to return if no input is provided
     * @return string|false The user input or the default value or false if no input and default is null
     */
    public static function prompt(string $message, ?string $default = null) : string|false {
        $msg = $message;
        if(!is_null($default)) {
            $msg .= " [$default]";
        }
        $msg .= ": ";
        Console::out($msg);
        $response = self::read();
        if(!empty($response)) {
            return $response;
        }
        if(!is_null($default)) {
            return $default;
        }
        return false;
    }

    /**
     * Confirm a question with the user
     * @param string $message The message to display
     * @return bool
     */
    public static function confirm(string $message) : bool {
        Console::out($message." [y/n]: ");
        $response = strtolower(trim(self::read()));
        return in_array($response, ['y', 'yes']);
    }

    /**
     * Select an option from a list
     * @param string $message The message to display
     * @param array $options The list of options to select from
     * @param string|null $selectMessage The message to display when selecting
     * @param bool $returnKey If true will return the key of the selected option, if false will return the value
     * @param bool $retry If true will retry if an invalid selection is made
     * @return string|false The selected option or false if no selection is made
     */
    public static function select(string $message, array $options, ?string $selectMessage = null, bool $returnKey = true, bool $retry = true) : string|false {
        Console::out($message."\n");
        foreach($options as $key => $option) {
            Console::out("  $key) $option\n");
        }
        $selectMessage = $selectMessage ?? "Enter a number from the options above";
        Console::out("$selectMessage: ");
        $response = trim(self::read());
        $selected = $options[$response] ?? false;
        if($selected === false && $retry === true) {
            Console::out(Console::color("Invalid selection\n", Console::TEXT_COLOR_RED));
            if($retry === true) {
                return self::select($message, $options, $selectMessage, $returnKey, $retry);
            }
            return false;
        }
        return ($returnKey) ? $response : $selected;
    }

    public static function selectMultiple(string $message, array $options, ?string $selectMessage = null, int $max = 0, bool $retry = true, string $doneKey = 'done', string $doneString = 'Done Selecting') : array|false {
        $selected = [];
        if($max === 0) {
            $max = count($options);
        }
        for($i = 0; $i < $max; $i++) {
            if($i === 1) {
                $options[$doneKey] = $doneString;
            }
            $selectedOption = self::select($message, $options, $selectMessage, true, $retry);
            if($selectedOption === false) {
                return false;
            }
            if($selectedOption == $doneKey) {
                return $selected;
            }
            $selected[] = $selectedOption;
        }
        return $selected;
    }

}