# PHP helpers

## Overview

Match the difference between two strings

What functions does it apply to?
such as: SMS template
At present, SMS sending is regulated by law, and template SMS was born. Template SMS generally requires that only template variables and values are submitted to the SMS gateway without submitting the original text, which will have a greater impact on the original b usiness system.

## Install

Add `liwenyu/php-helpers` to composer.json, you can assign version as `*`:

```sh
$ composer install
//or run
$ composer update
```

also we can do like this:

```sh
$ composer require liwenyu/php-helpers
```

## Usage

```
<?php

//Load Composer's autoloader
require 'vendor/autoload.php';

$template = '我爱你{a}，{b}';
$content = '我爱你中国，你最棒';
$result = \liwenyu\phpHelpers\StringDiff::getDiff($template, $content);
print_r($result);
Array
(
    [{a}] => 中国
    [{b}] => 你最棒
)
```