<?php

/**
 * NOTE: This class is not used yet. This is a work in progress for breaking out the Input
 * class into individual components.
 */

/**
 * Console - Utility class for interacting with the console
 * 
 * This class provides utility methods for generating and receiving console select input
 *
 * @package Console
 * @version 2.0.0
 * @file    Input/Select.php
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

use mannydmorales\Console\Console;
use mannydmorales\Console\Input;

class Select {

    /** @var string The prompt to display */
    private string $prompt;

    /** @var string The prompt to display for selecting an option */
    private string $selectPrompt;

    /** @var array<int,SelectOption> */
    private array $options = array();

    /** @var array<int,SelectOption> */
    private array $selected = array();

    /** @var bool Allow multiple selections */
    private bool $multi = false;

    /** @var int The maximum number of selections allowed */
    private int $max = 0;

    /** @var array<int,string> The available keys for selection */
    private array $availableKeys = array();

    /**
     * Construct the Select Input
     * @param string $prompt The prompt to display
     * @param string $selectPrompt The prompt to display for selecting an option
     * @param array<int,SelectOption> $options The options to display
     */
    public function __construct(string $prompt, string $selectPrompt, array $options) {
        $this->prompt = $prompt;
        $this->selectPrompt = $selectPrompt;
        $this->options = $options;
    }

    /**
     * Allow multiple selections
     * @param int $max The maximum number of selections allowed. Default is 0 (unlimited)
     * @return self
     */
    public function allowMultiple(int $max = 0) : self {
        $this->multi = true;
        $this->max = $max;
        return $this;
    }

    /**
     * Disable multiple selections
     * @return self
     */
    public function disableMultiple() : self {
        $this->multi = false;
        $this->max = 0;
        return $this;
    }

    /**
     * Get the prompt
     * @return string
     */
    public function getPrompt() : string {
        return $this->prompt;
    }

    /**
     * Get the select prompt
     * @return string
     */
    public function getSelectPrompt() : string {
        return $this->selectPrompt;
    }

    /**
     * Get the options
     * @return array<int,SelectOption>
     */
    public function getOptions() : array {
        return $this->options;
    }

    /**
     * Get the selected options
     * @return SelectOption|array<int,SelectOption>
     */
    public function getSelected() : SelectOption|array {
        if($this->multi) {
            return $this->selected;
        }
        return $this->selected[0];
    }

    /**
     * Get the selected keys
     * @return array<string>
     */
    public function getSelectedKeys() : array {
        return array_keys($this->selected);
    }

    /**
     * Get the selected values
     * @return array<string>
     */
    public function getSelectedValues() : array {
        return array_values($this->selected);
    }

    /**
     * Get the selected option
     * @param string $key The key of the option to get
     * @return SelectOption|false
     */
    public function getSelectedOption(string $key) : SelectOption|false {
        if(!isset($this->selected[$key])) {
            return false;
        }
        return $this->selected[$key];
    }

    /**
     * Add an option
     * @param SelectOption $option The option to add
     * @return self
     */
    public function addOption(SelectOption $option) : self {
        $this->options[$option->getKey()] = $option;
        return $this;
    }

    /**
     * Remove an option
     * @param string $key The key of the option to remove
     * @return self
     */
    public function removeOption(string $key) : self {
        unset($this->options[$key]);
        return $this;
    }

    /**
     * Build the select request
     * @return void
     */
    private function select() : void {
        Console::out($this->prompt."\n");
        foreach($this->options as $key => $option) {
            Console::out("  $key) ".$option->getValue()."\n");
        }
        Console::out($this->selectPrompt.": ");
        $response = trim(Input::read());
        if(in_array($response, $this->availableKeys)) {
            $this->selected[] = $this->options[$response];
        } else {
            Console::out(Console::color("Invalid selection\n", Console::TEXT_COLOR_RED));
            $this->select();
        }
    }

    /**
     * Generate the Select Input
     * @return void
     */
    public function getSelect() : void {
        $this->availableKeys = array_keys($this->options);
        if($this->multi) {
        } else {
            $this->select();
        }
    }

}