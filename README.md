# Console Library (PHP)

## Description
This library provides utility functions to interact with the console. Helpfull for console applications.

## Features
- Stylize outputs (Formatting includes: font color, background color, bold, hide for passwords, etc)
- Ask for user input: (Password, Prompt, Selects, Multi-Select, Confirm)
- Progress Bar
- Print formatted Usage Table
- Output to STDOUT and STDERR
- Clear Screen
- Console Size Detection
- Check OS type: isWindows, isMac, isLinux

## Installation
To install the library (using composer):

1. `composer require mannydmorales/console`
2. Include the composer autoloader 
    ```php
    require __DIR__.'/vendor/autoload.php';
    ```

To install the library (if not using composer):

1. Clone/Download the repository
2. Include the *autoload.php* script in your application
    ```php
    require 'path/to/install/autoload.php';
    ```

## Usage
Please view the examples located in the [examples/](examples) directory.

## Contributing
Contributions are welcome! Please fork the repository and create a pull request with your changes.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contact
For any questions or suggestions, please contact [mannydmorales@gmail.com](mailto:mannydmorales@gmail.com).
