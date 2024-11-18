<?php

require __DIR__.'/bootstrap.php';

use mannydmorales\Console\Console;

$output = Console::OUTPUT_STDOUT;

Console::startStyle([Console::TEXT_BG_BLUE, Console::TEXT_COLOR_WHITE], $output);
Console::outStream($output, "This is a message with a blue background and white text\n", "and this is a second message\n");
Console::endStyle($output);
Console::outStream($output, "This is a message without any style\n");