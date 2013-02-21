# Flexible Data Formatters

Provides a way to easily format a selection of a DataObject's fields used in a custom API. This is often useful when creating your own RESTful API that doesn't use SilverStripes `RestfulServer`

# Installation (with composer)

	$ composer require heyday/silverstripe-flexibledataformatter:~0.1

# Usage

```php
class MyDataObject extends DataObject implements FlexibleDataFormatterInterface
{
	public static $db = array(
    	'Title' => 'Varchar(255)'
	);

    public function getReadableFields()
    {
        return array(
            'Title'
        );
    }

    public function getDynamicFields()
    {
        return array();
    }
}

$dataObject = new MyDataObject(array('Title' => 'Hello'));
$formatter = new FlexibleJsonDataFormatter();
echo $formatter->convertDataObject($dataObject);

//	Results:
//	{
//		"Title": "Hello"
//	}
```

# Unit testing

Install dev dependencies from within module:

	silverstripe-flexibledataformatters/ $ composer install --dev

Use standard `phpunit` command

	silverstripe-flexibledataformatters/$ phpunit

If you don't have `phpunit` installed globally:

	silverstripe-flexibledataformatters/$ vendor/bin/phpunit
