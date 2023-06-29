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
3. To run the Config, run the following command:
```bash
php artisan vendor:publish --tag=ActivityConfig
```
4. To run the table, run the following command:
```bash
php artisan migrate
```
<!-- 4. To run the command for delete older activities, run the following command:
```bash
php artisan delete-older-activities
``` -->

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

## Configuration
- when you publish the ActivityConfig you will have the config file in /config path and you can customize the package from array like...
```php
return [
    'activity_enabled' => env('ACTIVITY_ENABLED', true),
    'table_name' => 'activities',
    'submit_empty_logs' => true,
    'log_only_changes' => true,
    'delete_records_older_than_days' => 365,
    'crud_operation' => [
        'create' => true,
        'read' => true,
        'update' => true,
        'delete'=> true ,
    ],
    'operation_info' => [
        'ip' => true,
        'browser' => true,
        'browser_version' => true,
        'referring_url' => true ,
        'current_url' => true,
        'device_type' => true,
        'operating_system' => true
    ],
    'exclude_column' => [
        // 'created_at', 
        // 'updated_at' , 
        // 'deleted_at',
        // 'password',
        // 'other',
    ],
];
```
- note for after modify the config file you must run the following command:
```bash
php artisan optimize
```

## Screenshots For Examples

- if you want make event for set visited in controller, following the code under line.
```php
ActivityLoggable::setVisited();
```
OR
```php
$model->setVisited('write any description if you want or make it null');
```
- for example, following the image under line.
![Screenshot 1](/media/setVisited.png)

- if you want set the Description for action, following the code under line.
```php
$model->setDescriptionForActivity('Description For create user');
```
- for example, following the image under line.
![Screenshot 1](/media/setDescription.png)

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