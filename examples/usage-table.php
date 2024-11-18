<?php

require __DIR__.'/bootstrap.php';

use mannydmorales\Console\Console;

Console::println("Usage table example");
$usage = array(
    ['-v, --version', 'Display the version'],
    ['-h, --help', 'Display this help'],
    ['-f', 'File to process'],
    ['-o', 'Output file'],
    ['-d', 'Debug mode'],
    ['-l', 'Log file'],
    ['-t, --verbose', 'Test mode'],
    ['-s', 'Show progress bar'],
    ['-c', 'Show colors'],
    ['-p', 'Show percentage'],
    ['-r', 'Show remaining time'],
    ['-e', 'Show elapsed time'],
    ['-m', 'Show memory usage'],
    ['-u', 'Show usage table'],
    ['-x', 'Show all']
);
Console::out(Console::getUsageTable($usage, ["Option", "Description"]));
