# Contact

[![Build Status](https://travis-ci.com/toancong/contact.svg?branch=master)](https://travis-ci.com/toancong/contact)

## Install

```
composer require beanbean/contact
```

## Usage

### This package support for single or multiple contact for an object.
Example: Your user can have a main contact, and other contact for billing, and other contact for shipping, and other for secondary contact, ...

### Integrate with your code

1. Add trait Contactable in your model

```
// class User
use \Bean\Contact\Traits\Contactable;
```

2. Save a contact which update or create new contact

```
$user->saveContact($name = 'shipping', $contact = [
    'first_name' => 'any',
    'last_name'  => 'any',
    'address'    => 'any',
    'address_2'  => 'any',
    'city'       => 'any',
    'state'      => 'any',
    'postcode'    => 'any',
    'country'    => 'any',
    'phone'      => 'any',
    'fax'        => 'any',
    'email'      => 'any',
]);
```

3. Get contact
Has some relationship to populate contact

```
$user->contacts // return all contacts of user by hasMany relationship
$user->contact($name = 'shipping')->first() // return a single shipping contact of user
$user->contact_shipping // return a shipping contact of user by magic method
```

4. json api
Register the resource provider into your api config file
```
    'providers' => [
        \Bean\Contact\ApiResourceProvider::class,
    ],
```

```
get contact: GET contacts?filter[object_id]=1&filter[object_type]=User&filter[name]=shipping
see more https://github.com/cloudcreativity/laravel-json-api
```

** Publish migration if you need change somethings
```
php artisan vendor:publish --provider "Bean\Contact\ServiceProvider"
```

## Contribute

PR are welcome. Please open an issue first and submit PR with a good commit message. Thanks

## License

MIT
