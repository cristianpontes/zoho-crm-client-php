# Zoho CRM Client for PHP
[![Build Status](https://travis-ci.org/cristianpontes/zoho-crm-client-php.svg?branch=master)](https://travis-ci.org/cristianpontes/zoho-crm-client-php)
[![Latest Stable Version](https://poser.pugx.org/cristianpontes/zoho-crm-client-php/v/stable)](https://packagist.org/packages/cristianpontes/zoho-crm-client-php)
[![License](https://poser.pugx.org/cristianpontes/zoho-crm-client-php/license)](https://packagist.org/packages/cristianpontes/zoho-crm-client-php)
<br>
Provides a clean readable PHP API to the [Zoho Rest API](https://www.zoho.com/crm/help/api/).
<br>
This project was initially cloned from [this repository](https://github.com/christiaan/zohocrmclient) and improved with:
+ New methods
+ More features
+ Friendly documentation


## Prerequisites
   - PHP 5.4 or above
   - [CURL](http://php.net/manual/en/book.curl.php)

## Easy Installation

To install with [Composer](https://getcomposer.org/), simply require the
latest version of this package.

```bash
composer require cristianpontes/zoho-crm-client-php
```

Make sure that the autoload file from Composer is loaded.

```php
// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';
```

## Usage Sample
```php
use CristianPontes\ZohoCRMClient\ZohoCRMClient;

$client = new ZohoCRMClient('Leads', 'yourAuthToken');

$records = $client->getRecords()
    ->selectColumns('First Name', 'Last Name', 'Email')
    ->sortBy('Last Name')->sortAsc()
    ->since(date_create('last week'))
    ->request();

// Just for debug
echo "<pre>";
print_r($records);
echo "</pre>";
```

## Available Methods
+ getRecords
+ insertRecords
+ updateRecords
+ deleteRecords
+ getDeletedRecordIds
+ getRelatedRecords
+ getRecordById
+ searchRecords
+ getSearchRecordsByPDC
+ uploadFile
+ downloadFile
+ deleteFile
+ getFields
+ convertLead
+ updateRelatedRecords

## Documentation
All the methods previously mentioned are well explained in the [library documentation page](https://cristianpontes.github.io/zoho-crm-client-php/).
<br>
Also, the code is well documented too, so you'll be able to look at the methods, functions and check how they work.
