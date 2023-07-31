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
		// environment variables
		// @phpstan-ignore-next-line
		$configurator->onCompile[] = static function (Configurator $configurator, Compiler $compiler): void {
			// phpcs:ignore SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable
			$compiler->addConfig(['parameters' => Environments::getVariables($_SERVER)]);
		};
	}

}
