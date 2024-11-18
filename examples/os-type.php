<?php

require __DIR__.'/bootstrap.php';

use mannydmorales\Console\Console;

Console::println("isWindows: ".(Console::isWindows() ? "Yes" : "No"));
Console::println("isMac: ".(Console::isMac() ? "Yes" : "No"));
Console::println("isLinux: ".(Console::isLinux() ? "Yes" : "No"));
Console::println("isUnix: ".(Console::isUnix() ? "Yes" : "No"));
Console::println("getOSType: ".Console::getOSType());