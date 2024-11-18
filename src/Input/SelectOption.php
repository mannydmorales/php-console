<?php

/**
 * NOTE: This class is not used yet. This is a work in progress for breaking out the Input
 * class into individual components.
 */

/**
 * Console - Utility class for interacting with the console
 * 
 * This class is the selection option object for select input
 *
 * @package Console
 * @version 2.0.0
 * @file    Input/SelectOption.php
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

namespace mannydmorales\Console\Input;

class SelectOption {

    private string $key;
    private string $value;
    private bool $selected = false;

    /**
     * Construct the Select Option
     * @param string $key The key for the option
     * @param string $value The value for the option
     * @param bool $caseSensitiveKey Whether the key is case sensitive. Default is false (case insensitive)
     */
    public function __construct(string $key, string $value, bool $caseSensitiveKey = false) {
        $this->key = ($caseSensitiveKey) ? $key : strtolower($key);
        $this->value = $value;
    }

    /**
     * Select the option
     * @return self
     */
    public function select() : self {
        $this->selected = true;
        return $this;
    }

    /**
     * Unselect the option
     * @return self
     */
    public function unselect() : self {
        $this->selected = false;
        return $this;
    }

    /**
     * Check if the option is selected
     * @return bool
     */
    public function isSelected() : bool {
        return $this->selected;
    }

    /**
     * Get the key for the option
     * @return string
     */
    public function getKey() : string {
        return $this->key;
    }

    /**
     * Get the value for the option
     * @return string
     */
    public function getValue() : string {
        return $this->value;
    }

    /**
     * Get the string representation of the option in the format of key:value
     * @return string
     */
    public function __toString() : string {
        return $this->key.":".$this->value;
    }

}