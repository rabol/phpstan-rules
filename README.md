# phpstan-rules

[![Continuous Integration](https://github.com/sidz/phpstan-rules/workflows/Continuous%20Integration/badge.svg)](https://github.com/sidz/phpstan-rules/actions)

Provides additional rules for [`phpstan/phpstan`](https://github.com/phpstan/phpstan).

## Installation

Run

```sh
composer require --dev sidz/phpstan-rules
```

If you use [PHPStan extension installer](https://github.com/phpstan/extension-installer), you're all set. If not, you need to manually register all the rules in your `phpstan.neon`:

```neon
includes:
    - vendor/sidz/phpstan-rules/rules.neon
```

Each rule by default ignores the following numbers: `0` and `1`. This can be configured by adding the following parameter to your `phpstan.neon`:

```neon
parameters:
	sidzIgnoreMagicNumbers: [0, 1, 100]
```

Each rule by default detects numeric strings like `'12'` in source code. This behavior could be disabled via parameter:

```neon
parameters:
	sidzIgnoreNumericStrings: true
```

## Ignoring particular rules

If you need to ignore particular rule, for example `NoMagicNumberInComparisonOperatorRule`, you can do so by using built-in `ignoreErrors` parameter:

```neon
parameters:
    ignoreErrors:
        - '#^Do not use magic number in comparison operations\. Move to constant with a suitable name\.$#'
```

If you need to ignore this rule only for particular file or folder, this also can be done by using `ignoreErrors` parameter:

```neon
parameters:
    ignoreErrors:
        -
            message: '#^Do not use magic number in comparison operations\. Move to constant with a suitable name\.$#'
            path: src/SomeFolder/*
```

And finally, if you want to ignore all the rules from this package for particular files or folders, add this to `phpstan.neon`:

```neon
parameters:
    ignoreErrors:
        -
            message: '#Do not (use|return|assign) magic number (.)#'
            paths:
                - src/DataFixtures/*
                - tests/*
```

## Rules

This package provides the following rules for use with [`phpstan/phpstan`](https://github.com/phpstan/phpstan):

- [`Sid\PHPStan\Rules\MagicNumber\NoMagicNumberAsFunctionArgumentRule`](https://github.com/sidz/phpstan-rules#magicnumbernomagicnumberasfunctionargumentrule)



### Classes

#### `MagicNumber\NoMagicNumberAsFunctionArgumentRule`

This rule reports an error when magic number is used as function argument:

```php
<?php

some_function(10);
```


## License

This package is licensed using the MIT License.

Please have a look at [`LICENSE.md`](LICENSE.md).