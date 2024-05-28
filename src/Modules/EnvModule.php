<?php declare(strict_types = 1);

namespace Contributte\Kernel\Modules;

use Contributte\Kernel\Bootconf;
use Contributte\Kernel\Configurator;
use Contributte\Kernel\Utils\Environments;
use Nette\DI\Compiler;

/**
 * @phpstan-consistent-constructor
 */
class EnvModule extends BaseModule
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
		// phpcs:ignore SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable
		$envs = Environments::getVariables($_ENV + $_SERVER);

		// Static parameters to apply changes to DI container if ENV is changed
		$configurator->addStaticParameters($envs);

		// environment variables
		$configurator->onCompile[] = static function (Configurator $configurator, Compiler $compiler) use ($envs): void {
			$compiler->addConfig(['parameters' => $envs]);
		};
	}

}
