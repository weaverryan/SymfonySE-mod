1) Installing
-------------

When it comes to installing the Symfony Standard Edition, you have the
following options.

### Downloading vendors

As Symfony uses [Composer][2] to manage its dependencies, the recommended way
to create a new project is to use it.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command from within the
project:

    curl -s http://getcomposer.org/installer | php

Then download the vendor libraries.

    php composer.phar install

2) Checking your System Configuration
-------------------------------------

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

The script returns a status code of `0` if all mandatory requirements are met,
`1` otherwise.

Access the `config.php` script from a browser:

    http://localhost/path-to-project/web/config.php

If you get any warnings or recommendations, fix them before moving on.

3) View the Site
----------------

Either setup a VirtualHost, or just run the internal PHP web server:

    php app/console server:run

Then view the site at `http://localhost:8000`

Enjoy!

[2]:  http://getcomposer.org/
