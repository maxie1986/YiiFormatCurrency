YiiFormatCurrency
=================

It's the jquery Format Currency plugin adapted for PHP Yii Framework.

This is a widget made based on jquery-formatcurrency plugin.



[http://code.google.com/p/jquery-formatcurrency/](http://code.google.com/p/jquery-formatcurrency/ "http://code.google.com/p/jquery-formatcurrency/")


I had to use this plugin in my yii app and I realized that nobody already made this plugin in a widget so I wanted to create my first widget and share with the community. So If you find any bug, or have any suggestions, or want any improvements on this widget I'll take note and I'll check those.
Basically this widget will format your current value in a textField as you type in. E.g. 1500.30 will be converted into $ 1,500.30 an it's formatted as you type in
This was Tested on Yii 1.1.7

##Usage

1. Make sure to include it in /protected/config/main.php

~~~
[php]
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.vendors.*',
        'application.extensions.*',
        'application.extensions.formatCurrency.*',
~~~

and then If you want to use within a CActiveForm widget you can use it like this:

~~~
[php]

$this->widget("FormatCurrency",
                array(
                    "model" => $model,
                    "attribute" => "field_value",
                    ));
~~~

And use it like a regular CHtml textField within a CActiveForm

Or just use it :

~~~
[php]
$this->widget("FormatCurrency",
                array(
                    "name" => "name",
                    ));
~~~

##Options

You can set the following options :

**decimalSymbol** : The symbol to be used to separate the dollars from the cents. Default from Yii::app()->getLocale()->getNumberSymbol("decimal")

**digitGroupSymbol** : The symbol to be used to separate the thousands place when grouping the numbers. Default from Yii::app()->getLocale()->getNumberSymbol("group")

**negativeFormat** : The format notation for setting destination value. The %s variable signifies the symbol, and the %n variable signifies the number. An example of the default settings if the number 1000 were passed using '%s%n' would resulting in ($1,000.00). Default to '-%s%n'

**region** : One of the many cultures listed on the [InternationalSupport](http://code.google.com/p/jquery-formatcurrency/wiki/InternationalSupport "InternationalSupport") page. In order to use these values you will have to include the corresponding i18n file to your page. You can also include the jQuery.formatCurrency.all.js file to include all supported regions. If a culture cannot be found the region will be attempted, if the region cannot be found the default value will be used. (eg. If the region supplied is 'es-MX' and 'es-MX' is not found 'es' will be used. If 'es is not found then '' will be used). Default from Yii::app()->getLocale()->getId()

**roundToDecimalPlace**: An integer that indicates what decimal digit to round to (e.g. 0, 2, etc.). Use -1 to disable rounding with 2 decimals and use -2 to disable rounding with 0 decimals. Defaults to 2 decimal digits with rounding. Default 2

**Options Usage:** 
~~~
[php]
$this->widget("FormatCurrency",
                array(
                    "model" => $model,
                    "attribute" => "field_value",
                    "options" => array(
  		"negativeFormat"=>'-%s%n',
			"roundToDecimalPlace" => 2,
			"region"=> 'en-US',
			"decimalSymbol" => ',',
			"digitGroupSymbol" => '.'
                       ),
                    ));
~~~




##Resources

...external resources for this extension...

 * [GitHub repository](https://github.com/maxie1986/YiiFormatCurrency)
 * [Try out a demo](http://www.bendewey.com/code/formatcurrency/demo/format_as_you_type.html)
