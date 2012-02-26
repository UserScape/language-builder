## Installation

**Git Submodule**

	git submodule add git@github.com:UserScape/language-builder.git bundles/language-builder

** Modify application/bundles.php**

```php
return array(
	'language-builder' => array(
		'location' => 'language-builder',
		'handles' => 'language-builder',
	),
);
```

Now visit yoursite.com/index.php/language-builder and you should be prompted to select a language that you want to translate.

## Configuration

You should open the config/builder.php to adjust settings to your individual needs. Below is a list of settings:

* `base_lang` - The base language used as a reference and the master.
* `languages` - An array of languages that can be translated to.

