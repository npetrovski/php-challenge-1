# PHP Challenge #1 (PHP Version >= 5.4)

## Requirements

> **Summary**: Write a script/function `strtr_serialized` that will replace PHP serialized data *without using **serialize**/**unserialize** functions*


_What is needed is a function that replaces strings in serialized data._


Examples:

```PHP
// Serialized string

$a = serialize('foobar'); // s:6:"foobar";
```

Execute Find/Replace: `foobar => foobarbas`

Expected Result: `s:6:"foobar" => s:9:"foobarbas"`

> **Hint:** Keep in mind how: `s:6` is changed to `s:9` (this is number of characters so we need to adjust them to have valid serialized data)

```PHP
// A serialized array

$b = serialize(array('foobar')); // a:1:{i:0;s:6:"foobar";}
```

Execute Find/Replace: `foobar => foobarbas`

Expected Result: `a:1:{i:0;s:6:"foobar";} => a:1:{i:0;s:9:"foobarbas";}`

> **Hint:** Keep in mind how: `s:6` is changed to `s:9` (this is number of characters so we need to adjust them to have valid serialized data)


```PHP
// Nested serialized data

class Test {
	public $variable = null;

	public function __construct() {
		$this->variable = serialize(array('foobar'));
	}
}

$test = new Test;

$c = serialize($test); // O:4:"Test":1:{s:8:"variable";s:23:"a:1:{i:0;s:6:"foobar";}";}
```

Execute Find/Replace: `foobar => foobarbas`

Expected Result: `O:4:"Test":1:{s:8:"variable";s:26:"a:1:{i:0;s:9:"foobarbas";}";}`

> **Hint:** Keep in mind how: `s:23` is changed to `s:26` and `s:6` is changed to `s:9`

## Validation

1) The PHPUnit tests in this project should not be changed.  
2) All PHPUnit tests in the project should pass.

## What do we evaluate?

1) Unit tests shoud pass
2) Code style (variables naming convension, code commentary, code readiness)
3) Code execution performance
