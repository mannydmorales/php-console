<?php

require __DIR__.'/bootstrap.php';

use mannydmorales\Console\Console;
use mannydmorales\Console\ProgressBar;

$wait = round((1000000/20));

Console::println("Basic Progress bar example");
$progress = new ProgressBar(100, 60);
for($i = 0; $i <= 100; $i++) {
    // $progress->progress($i);
    $progress->progress();
    usleep($wait);
}

Console::println("Basic Progress bar example custom complete text");
$progress = new ProgressBar(100, 60, "Complete Message Here");
for($i = 0; $i <= 100; $i++) {
    $progress->progress($i);
    usleep($wait);
}

Console::println("Progress bar: Disable Complete Label");
ProgressBar::$displayProgressBarComplete = true;
$progress = new ProgressBar(100, 60);
for($i = 0; $i <= 100; $i++) {
    $progress->progress($i);
    usleep($wait);
}
ProgressBar::$displayProgressBarComplete = false; // Re enable complete progress bar label for other examples

Console::println("Progress bar: Color");
Console::startStyle(Console::TEXT_COLOR_YELLOW, Console::OUTPUT_STDOUT);
$progress = new ProgressBar(100, 60);
for($i = 0; $i <= 100; $i++) {
    $progress->progress($i);
    usleep($wait);
}
Console::endStyle(Console::OUTPUT_STDOUT);

Console::println("Progress bar: Failed");
$progress = new ProgressBar(100, 60);
for($i = 0; $i <= 60; $i++) {
    $progress->progress($i);
    usleep($wait);
}
$progress->failed("Error Message here");

Console::println("Progress bar: Actions (jump percentages)");
$progress = new ProgressBar(100, 60);
$progress->progress(0, false);
usleep(500000); // Do action 1
$progress->progress(10, false);
usleep(1000000); // Do action 2
$progress->progress(40, false);
usleep(500000); // Do action 3
$progress->progress(70, false);
usleep(500000); // Do action 4
$progress->progress(99, false);
usleep(100000); // Complete
$progress->progress(100, false);

Console::println("Progress bar: Custom Glyphs");
ProgressBar::$glyphComplete = 'X';
ProgressBar::$glyphPending = '-';
$progress = new ProgressBar(100, 60);
for($i = 0; $i <= 100; $i++) {
    $progress->progress($i);
    usleep($wait);
}