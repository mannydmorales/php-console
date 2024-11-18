<?php

require __DIR__.'/bootstrap.php';

use mannydmorales\Console\Console;
use mannydmorales\Console\Input;

Console::out("Enter a name: ");
$name = Input::read();
Console::out("You entered: $name\n");

Console::out("Enter a password: ");
$password = Input::password();
Console::out("\nYou entered: $password\n");

$ageGroup = Input::select("What is your age group?", [
    '1' => 'Under 18',
    '2' => '18-24',
    '3' => '25-34',
    '4' => '35-44',
    '5' => '45-54',
    '6' => '55-64',
    '7' => '65 or older'
], null, false);
Console::out("You selected: $ageGroup\n");

if(Input::confirm("Do you want to continue?")) {
    Console::out("You confirmed\n");
} else {
    Console::out("You did not confirm\n");
}

$color = Input::prompt("What is your favorite color?", "none");
Console::out("You entered: $color\n");

Console::out("Muli-select example\n");
$multi = Input::selectMultiple("Select your favorite colors", [
    '1' => 'Red',
    '2' => 'Green',
    '3' => 'Blue',
    '4' => 'Yellow',
    '5' => 'Purple',
    '6' => 'Orange',
    '7' => 'Black',
    '8' => 'White',
    '9' => 'Gray',
    '10' => 'Brown',
    '11' => 'Pink',
    '12' => 'Cyan',
    '13' => 'Magenta'
], null, 0);
Console::out("You selected: ".implode(", ", $multi)."\n");