<h2 align="center">
    Linkmobility Package for Laravel
</h2>

<p align="center">
    <a href="https://packagist.org/packages/jcsofts/laravel-linkmobility"><img src="https://poser.pugx.org/jcsofts/laravel-linkmobility/v/stable?format=flat-square" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/jcsofts/laravel-linkmobility"><img src="https://poser.pugx.org/jcsofts/laravel-linkmobility/v/unstable?format=flat-square" alt="Latest Unstable Version"></a>    
    <a href="https://packagist.org/packages/jcsofts/laravel-linkmobility"><img src="https://poser.pugx.org/jcsofts/laravel-linkmobility/license?format=flat-square" alt="License"></a>
    <a href="https://packagist.org/packages/jcsofts/laravel-linkmobility"><img src="https://poser.pugx.org/jcsofts/laravel-linkmobility/downloads" alt="Total Downloads"></a>
</p>

## Introduction

This is a simple Laravel Service Provider providing access to the <a href="https://www.linkmobility.com/wp-content/uploads/2017/09/SMS_REST_API_MT_DLR-1.3-1.pdf">Linkmobility API</a>

Installation
------------

To install the PHP client library using Composer:

```bash
composer require jcsofts/laravel-linkmobility
```

Alternatively, add these two lines to your composer require section:

```json
{
    "require": {
        "jcsofts/laravel-linkmobility": "^1.0"
    }
}
```

### Laravel 5.5+

If you're using Laravel 5.5 or above, the package will automatically register the `Linkmobility` provider and facade.

### Laravel 5.4 and below

Add `Jcsofts\LaravelLinkmobility\LinkmobilityServiceProvider` to the `providers` array in your `config/app.php`:

```php
'providers' => [
    // Other service providers...

    Jcsofts\LaravelLinkmobility\LinkmobilityServiceProvider::class,
],
```

If you want to use the facade interface, you can `use` the facade class when needed:

```php
use Jcsofts\LaravelLinkmobility\Facade\Linkmobility;
```

Or add an alias in your `config/app.php`:

```php
'aliases' => [
    ...
    'Linkmobility' => Jcsofts\LaravelLinkmobility\Facade\Linkmobility::class,
],
```

### Using Laravel-Linkmobility with Lumen

laravel-linkmobility works with Lumen too! You'll need to do a little work by hand
to get it up and running. First, install the package using composer:


```bash
composer require jcsofts/laravel-linkmobility
```

Next, we have to tell Lumen that our library exists. Update `bootstrap/app.php`
and register the `LinkmobilityServiceProvider`:

```php
$app->register(Jcsofts\LaravelLinkmobility\LinkmobilityServiceProvider::class);
```

Finally, we need to configure the library. Unfortunately Lumen doesn't support
auto-publishing files so you'll have to create the config file yourself by creating
a config directory and copying the config file out of the package in to your project:

```bash
mkdir config
cp vendor/jcsofts/laravel-linkmobility/config/linkmobility.php config/linkmobility.php
```


Configuration
-------------

You can use `artisan vendor:publish` to copy the distribution configuration file to your app's config directory:

```bash
php artisan vendor:publish
```

Then update `config/linkmobility.php` with your credentials. Alternatively, you can update your `.env` file with the following:

```dotenv
LINKMOBILITY_USERNAME=
LINKMOBILITY_PASSWORD=
LINKMOBILITY_PLATFORM_ID=
LINKMOBILITY_PARTNER_ID=
LINKMOBILITY_USE_DELIVERY_REPORT=true
LINKMOBILITY_DEBUG=true
```

Usage
-----
   
To use the Linkmobility Client Library you can use the facade, or request the instance from the service container:

```php
try{
        $messageId=Linkmobility::send('Hello word', '+8618903859xxx');
        echo $messageId;
    }catch(Exception $e){
        echo $e->getMessage();
    }
```

Or

```php
$linkmobility = app('Linkmobility');

$messageId=$linkmobility->send('Hello word', '+8618903859xxx');
```
