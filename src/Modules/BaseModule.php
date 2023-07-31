<?php declare(strict_types = 1);

namespace Contributte\Kernel\Modules;

use Contributte\Kernel\Bootconf;
use Contributte\Kernel\Configurator;

abstract class BaseModule
{

	abstract public function apply(Configurator $configurator, Bootconf $config): void;

}
