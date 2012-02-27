## Installation

**Git Submodule**

	git submodule add git@github.com:UserScape/language-builder.git bundles/language-builder

**Modify application/bundles.php**

```php
return array(
	'language-builder' => array(
		'location' => 'language-builder',
		'handles' => 'language-builder',
	),
);
```
**Publish assets**

	php artisan bundle:publish

Now visit yoursite.com/index.php/language-builder and you should be prompted to select a language that you want to translate.

## Configuration

You should open the config/builder.php to adjust settings to your individual needs. Below is a list of settings:

* `base_lang` - The base language used as a reference and the master.
* `languages` - An array of languages that can be translated to.

### Contributing

Contributions are encouraged and welcome; however, please review the Developer Certificate of Origin in the "license.txt" file included in the repository. All commits must be signed off using the "-s" switch.

	git commit -s -m "thie commit will be signed off automatically!"