<?php declare(strict_types = 1);

namespace Contributte\Kernel\Presets;

use Contributte\Kernel\Bootloader;

abstract class BasePreset
{

	abstract public function apply(Bootloader $bootloader): void;

}
