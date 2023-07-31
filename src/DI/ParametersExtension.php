<?php declare(strict_types = 1);

namespace Contributte\Kernel\DI;

use Contributte\Kernel\Service\AppFolder;
use Contributte\Kernel\Service\AppParams;
use Contributte\Kernel\Service\Folders;
use Contributte\Kernel\Service\LogFolder;
use Contributte\Kernel\Service\RootFolder;
use Contributte\Kernel\Service\TempFolder;
use Contributte\Kernel\Service\WwwFolder;
use Nette\DI\CompilerExtension;

class ParametersExtension extends CompilerExtension
{

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('folders'))
			->setFactory(Folders::class, [
				[
					'rootDir' => $builder->parameters['rootDir'],
					'appDir' => $builder->parameters['appDir'],
					'wwwDir' => $builder->parameters['wwwDir'],
					'tempDir' => $builder->parameters['tempDir'],
					'logDir' => $builder->parameters['logDir'],
				],
			]);

		$builder->addDefinition($this->prefix('rootFolder'))
			->setFactory(RootFolder::class, [$builder->parameters['rootDir']]);

		$builder->addDefinition($this->prefix('appFolder'))
			->setFactory(AppFolder::class, [$builder->parameters['appDir']]);

		$builder->addDefinition($this->prefix('wwwFolder'))
			->setFactory(WwwFolder::class, [$builder->parameters['wwwDir']]);

		$builder->addDefinition($this->prefix('logFolder'))
			->setFactory(LogFolder::class, [$builder->parameters['logDir']]);

		$builder->addDefinition($this->prefix('tempFolder'))
			->setFactory(TempFolder::class, [$builder->parameters['tempDir']]);

		$builder->addDefinition($this->prefix('appParams'))
			->setFactory(AppParams::class, [$builder->parameters]);
	}

}
