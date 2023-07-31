<?php declare(strict_types = 1);

namespace Contributte\Kernel\Modules;

use Contributte\Kernel\Bootconf;
use Contributte\Kernel\Configurator;
use Contributte\Kernel\DI\ParametersExtension;
use Nette\DI\Compiler;

/**
 * @phpstan-consistent-constructor
 */
class ConfigModule extends BaseModule
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
		$configurator->addStaticParameters([
			'rootDir' => dirname($config->getRoot()),
			'appDir' => $config->getRoot(),
			'wwwDir' => realpath($config->getRoot() . '/../www'),
			'logDir' => realpath($config->getRoot() . '/../var/log'),
			'tempDir' => realpath($config->getRoot() . '/../var/tmp'),
		]);

		// extensions
		assert(is_array($configurator->onCompile));
		$configurator->onCompile[] = static function (Configurator $configurator, Compiler $compiler): void {
			$compiler->addExtension('params', new ParametersExtension());
		};

		// config.neon
		if (file_exists($config->getRoot() . '/../config/config.neon')) {
			$configurator->addConfig($config->getRoot() . '/../config/config.neon');
		}

		// local.neon
		if (file_exists($config->getRoot() . '/../config/local.neon')) {
			$configurator->addConfig($config->getRoot() . '/../config/local.neon');
		}
	}

}
