<?php declare(strict_types = 1);

namespace Contributte\Kernel\Modules;

use Contributte\Kernel\Bootconf;
use Contributte\Kernel\Configurator;

/**
 * @phpstan-consistent-constructor
 */
class InjectionModule extends BaseModule
{

	private function __construct()
	{
		// Use self::create();
	}

	public static function create(): self
	{
		return new static();
	}

	public function apply(Configurator $configurator, Bootconf $config): void
	{
		// nette/di conventions
		$configurator->addConfig([
			'di' => [
				'debugger' => '%debugMode%',
			],
		]);
	}

}
