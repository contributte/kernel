![](https://heatbadger.now.sh/github/readme/contributte/kernel/)

<p align=center>
  <a href="https://github.com/contributte/kernel/actions"><img src="https://badgen.net/github/checks/contributte/kernel/master?cache=300"></a>
  <a href="https://coveralls.io/r/contributte/kernel"> <img src="https://badgen.net/coveralls/c/github/contributte/kernel?cache=300"> </a>
  <a href="https://packagist.org/packages/contributte/kernel"> <img src="https://badgen.net/packagist/dm/contributte/kernel"> </a>
  <a href="https://packagist.org/packages/contributte/kernel"> <img src="https://badgen.net/packagist/v/contributte/kernel"> </a>
</p>
<p align=center>
  <a href="https://packagist.org/packages/contributte/kernel"><img src="https://badgen.net/packagist/php/contributte/kernel"></a>
  <a href="https://github.com/contributte/kernel"><img src="https://badgen.net/github/license/contributte/kernel"></a>
  <a href="https://bit.ly/ctteg"><img src="https://badgen.net/badge/support/gitter/cyan"></a>
  <a href="https://bit.ly/cttfo"><img src="https://badgen.net/badge/support/forum/yellow"></a>
  <a href="https://contributte.org/partners.html"><img src="https://badgen.net/badge/sponsor/donations/F96854"></a>
</p>
<p align=center>
Website 🚀 <a href="https://contributte.org">contributte.org</a> | Contact 👨🏻‍💻 <a href="https://f3l1x.io">f3l1x.io</a> | Twitter 🐦 <a href="https://twitter.com/contributte">@contributte</a>
</p>

Convenient bootloader for Nette (@nette) applications.

## Versions

| State  | Version | Branch   | Nette | PHP     |
|--------|---------|----------|-------|---------|
| dev    | `^0.2`  | `master` | 4.0+  | `>=8.2` |
| stable | `^0.1`  | `master` | 3.1+  | `>=8.2` |

## Installation

```bash
composer require contributte/kernel
```

## Usage

Create file `app/Bootstrap.php`.

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
			->from(MyAppPreset::create())
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

## Development

See [how to contribute](https://contributte.org/contributing.html) to this package.

This package is currently maintaining by these authors.

<a href="https://github.com/f3l1x">
  <img width="80" height="80" src="https://avatars2.githubusercontent.com/u/538058?v=3&s=80">
</a>

-----

Consider to [support](https://contributte.org/partners.html) **contributte** development team.
Also thank you for using this package.
