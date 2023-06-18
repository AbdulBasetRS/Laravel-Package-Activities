# Documentation

## Laravel Package Activities Description
- The Laravel Package Activities provides a simple and flexible way to log user activities in your Laravel application. With this package, you can track user actions such as creating, reading, updating, and deleting records.
- note for updating, when model make update he save only the value changes.

## Installation
1. open your command and use cd to go your dir laravel project
2. To install this package, run the following command:
```bash
composer require abdulbaset/laravel-package-activities
```
3. To run the table, run the following command:
```bash
php artisan migrate
```
3. To run the Config, run the following command:
```bash
php artisan vendor:publish --tag=ActivityConfig
```

## Usage
- just include the name speace in your model.
```php
use Abdulbaset\Activities\Traits\ActivityLoggable;
```
- and use the trait name in your model want to save the activities
```php
use ActivityLoggable;
```

- Full Example, and if you want exclude the same coulmn from action in model, write under line in your model.
```php
use Abdulbaset\Activities\Traits\ActivityLoggable;

class YourModel extends Model
{
    use ActivityLoggable;

    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->addExcludeCoulmn(['created_at','updated_at']);
    }
    //..
}
```

## configuration
- when you publish the ActivityConfig you will have the config file in /config path and you can customize the package from array like...
```php
return [
    'crud_operation' => [
        'create' => true,   // if false not record the action
        'read' => true,     // if false not record the action
        'update' => true,   // if false not record the action
        'delete'=> true ,   // if false not record the action
    ],
    'operation_info' => [
        'ip' => true,               // if false return null
        'browser' => true,          // if false return null
        'browser_version' => true,  // if false return null
        'referring_url' => true ,   // if false return null
        'current_url' => true,      // if false return null
        'device_type' => true,      // if false return null
        'operating_system' => true  // if false return null
    ],
    'exclude_column' => [ // write the exclude column for dont save in [old] and [new] column package, and if you exclude all the column will return null and will not save the action
        // 'created_at', 
        // 'updated_at', 
    ]
];
```
- note for after modify the config file you must run the following command:
```bash
php artisan optimize
```

## Screenshots
- if you want exclude the same coulmn from action in controller, following the code under line.
```php
Model::setExclude(['created_at','updated_at']);
```
OR
```php
$model->setExclude(['created_at','updated_at']);
```
- for example, following the image under line.
![Screenshot 1](/media/exclude.png)

- if you want save login records[ require ] and description[ option ], following the code under line.
```php
ActivityLoggable::setRecord('login','the description');
```
OR
```php
$model->setRecord('login','the description');
```
- for example, following the image under line.
![Screenshot 1](/media/login.png)

- if you want save logout records[ require ] and description[ option ], following the code under line.
```php
ActivityLoggable::setRecord('logout');
```
OR
```php
$model->setRecord('logout');
```
- for example, following the image under line.
![Screenshot 1](/media/logout.png)

## Features
- when use the package you will save the..
1. event
2. user_id
3. model
4. model_id
5. old
6. new
7. ip
8. browser
9. browser_version
10. referring_url
11. current_url
12. device_type
13. operating_system
14. description
15. created_at
16. updated_at

## Author
- Abdulbaset R. Sayed <AbdulbasetRedaSayedHF@Gmail.com>

## Contributing
1. ChatGPT

## License
- This Package is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.