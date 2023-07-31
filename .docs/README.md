# Contributte Kernel

Convenient bootloader for Nette (@nette) applications.

## Installation

```bash
composer require contributte/kernel
```

## Installation

Install `contributte/kernel` via `composer require contributte/kernel`.

## Usage

Create file `app/Bootstra.php`.

```php
<?php declare(strict_types = 1);

namespace App;

use Contributte\Kernel\Bootloader;
use Contributte\Kernel\Kernel;
use Contributte\Kernel\Modules\ConfigModule;
use Contributte\Kernel\Modules\EnvModule;
use Contributte\Kernel\Modules\InjectionModule;
use Contributte\Kernel\Modules\TracyModule;

final class Bootstrap
{

	public static function boot(): Kernel
	{
		return Bootloader::of(__DIR__)
			->use(TracyModule::create())
			->use(ConfigModule::create())
			->use(EnvModule::create())
			->use(InjectionModule::create())
			->boot();
	}

	public static function run(): void
	{
		self::boot()
			->createContainer()
			->getByType(YourApplication::class)
			->run();
	}

}
```

## Structure

This package assume you are using this project structure. If you are using different one, you need to update `appDir`, `logDir`, `tempDir`, `wwwDir` and `configDir`.

```
├── app
│ ├── Bootstrap.php
├── config
│ ├── config.neon
├── var
│ ├── log
│ └── tmp
└── www
    └── index.php
```
