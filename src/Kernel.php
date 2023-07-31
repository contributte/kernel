<?php declare(strict_types = 1);

namespace Contributte\Kernel;

use Nette\Bootstrap\Configurator;
use Nette\DI\Container;

class Kernel
{

	private Configurator $configurator;

	private function __construct(Configurator $configurator)
	{
		$this->configurator = $configurator;
	}

	public static function of(Configurator $configurator): self
	{
		return new self($configurator);
	}

	public function createContainer(): Container
	{
		return $this->configurator->createContainer();
	}

}
