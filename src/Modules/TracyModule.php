<?php declare(strict_types = 1);

namespace Contributte\Kernel\Modules;

use Contributte\Kernel\Bootconf;
use Contributte\Kernel\Configurator;
use Contributte\Kernel\Utils\Environments;

/**
 * @phpstan-consistent-constructor
 */
class TracyModule extends BaseModule
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
		$configurator->setDebugMode(Environments::isDebug());

		$configurator->enableTracy($config->getRoot() . '/../var/log');

		// tracy/tracy conventions
		$configurator->addConfig([
			'tracy' => [
				'strictMode' => true,
			],
		]);
	}

}
