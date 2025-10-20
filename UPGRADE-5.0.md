# Upgrading from Laravel 4.2 to Laravel 5.0

This guide will help you upgrade your Laravel HTMLMin installation from Laravel 4.2 to Laravel 5.0+.

## Requirements

- PHP 5.4.0 or higher
- Laravel 5.0 or higher

## Step-by-Step Migration Guide

### 1. Update Laravel

First, upgrade your Laravel application from 4.2 to 5.0. Follow the official Laravel upgrade guide:
https://laravel.com/docs/5.0/upgrade

### 2. Update HTMLMin Package

Update your `composer.json` to require the latest version:

```json
{
    "require": {
        "htmlmin/htmlmin": "^5.0"
    }
}
```

Then run:

```bash
composer update htmlmin/htmlmin
```

### 3. Update Service Provider Registration

In Laravel 4.2, you registered the service provider like this:

```php
// app/config/app.php (Laravel 4.2)
'providers' => array(
    // ...
    'HTMLMin\HTMLMin\HTMLMinServiceProvider',
),
```

In Laravel 5.0+, update it to:

```php
// config/app.php (Laravel 5.0+)
'providers' => [
    // ...
    HTMLMin\HTMLMin\HTMLMinServiceProvider::class,
],
```

### 4. Update Facade Registration

In Laravel 4.2:

```php
// app/config/app.php (Laravel 4.2)
'aliases' => array(
    // ...
    'HTMLMin' => 'HTMLMin\HTMLMin\Facades\HTMLMin',
),
```

In Laravel 5.0+:

```php
// config/app.php (Laravel 5.0+)
'aliases' => [
    // ...
    'HTMLMin' => HTMLMin\HTMLMin\Facades\HTMLMin::class,
],
```

### 5. Move Configuration File

In Laravel 4.2, configuration files were stored in:
```
app/config/packages/htmlmin/htmlmin/config.php
```

In Laravel 5.0+, move your configuration to:
```
config/htmlmin.php
```

You can publish the default configuration with:

```bash
php artisan vendor:publish --provider="HTMLMin\HTMLMin\HTMLMinServiceProvider"
```

### 6. Update Filters to Middleware

Laravel 5.0 replaced filters with middleware. If you were using HTMLMin filters in Laravel 4.2, you need to update them to use middleware.

#### Laravel 4.2 (Filters):
```php
// app/filters.php
Route::filter('minify', function() {
    // minification logic
});

// Usage
Route::get('/', ['before' => 'minify', 'uses' => 'HomeController@index']);
```

#### Laravel 5.0+ (Middleware):
```php
// app/Http/Kernel.php
protected $middleware = [
    // ...
    \HTMLMin\HTMLMin\Http\Middleware\MinifyMiddleware::class,
];

// Or use it on specific routes
protected $routeMiddleware = [
    // ...
    'minify' => \HTMLMin\HTMLMin\Http\Middleware\MinifyMiddleware::class,
];

// Usage
Route::get('/', ['middleware' => 'minify', 'uses' => 'HomeController@index']);
```

### 7. Clear Compiled Views

After completing the migration, clear your compiled views:

```bash
php artisan view:clear
```

If this command is not available in Laravel 5.0, manually delete the contents of:
```
storage/framework/views/
```

### 8. Update Namespace Imports

If you're using HTMLMin classes directly in your code, update the imports to use Laravel 5.0+ syntax:

#### Laravel 4.2:
```php
<?php
use HTMLMin\HTMLMin\HTMLMin;
```

#### Laravel 5.0+:
```php
<?php

namespace App\Http\Controllers;

use HTMLMin\HTMLMin\Facades\HTMLMin;
```

## Configuration Changes

The configuration file structure remains the same, but make sure to review your settings:

```php
return [
    'blade' => false,  // Enable automatic blade minification
    'force' => false,  // Force minification even on dangerous templates
    'ignore' => [      // Paths to ignore
        'resources/views/emails',
        'resources/views/notifications',
    ],
];
```

## Testing

After migration, thoroughly test your application:

1. Test all views render correctly
2. Test that minification is working as expected
3. Check that ignored paths are still being ignored
4. Verify middleware is working on routes

## Troubleshooting

### Views not minifying
- Check that `'blade' => true` is set in `config/htmlmin.php`
- Run `php artisan view:clear` to clear cached views
- Make sure the service provider is registered

### Errors about undefined methods
- Clear your application cache: `php artisan cache:clear`
- Clear config cache: `php artisan config:clear`
- Make sure you're running Laravel 5.0 or higher

### Middleware not working
- Check that middleware is registered in `app/Http/Kernel.php`
- Verify route middleware is applied correctly
- Clear route cache: `php artisan route:clear`

## Additional Resources

- [Laravel 5.0 Upgrade Guide](https://laravel.com/docs/5.0/upgrade)
- [Laravel HTMLMin Documentation](README.md)
- [Middleware Documentation](https://laravel.com/docs/5.0/middleware)

## Support

If you encounter any issues during migration, please:
1. Check the [GitHub Issues](https://github.com/HTMLMin/Laravel-HTMLMin/issues)
2. Review the [CHANGELOG](CHANGELOG.md)
3. Open a new issue with details about your problem

