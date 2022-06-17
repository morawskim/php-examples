## Info

This project include a very simple example of PHPStan rule.
This rule check first argument passed to function `file_get_contents`.
The first argument value need to be snake_case.
Only one specific case is checked.

PHPStan analysis `vendor/bin/phpstan analyse -l 8 --debug --xdebug tests/_data/test.php`

Execute unit tests `./vendor/bin/phpunit tests/`

## More info

[PHPStan Custom Rules](https://phpstan.org/developing-extensions/rules)

[Creating custom PHPStan rules for your Symfony project](https://www.strangebuzz.com/en/blog/creating-custom-phpstan-rules-for-your-symfony-project)
