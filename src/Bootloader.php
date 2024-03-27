<?php declare(strict_types = 1);

namespace Contributte\Kernel;

use Contributte\Kernel\Modules\BaseModule;
use Contributte\Kernel\Presets\BasePreset;

class Bootloader
{

	private Bootconf $config;

	/** @var BasePreset[] */
	private array $presets = [];

	/** @var BaseModule[] */
	private array $modules = [];

	/** @var callable[] */
	private array $fns = [];

	private function __construct(Bootconf $config)
	{
		$this->config = $config;
	}

	public static function of(string $root): self
	{
		return new self(
			new Bootconf($root)
		);
	}

	public function from(BasePreset $preset): self
	{
		$this->presets[] = $preset;

		return $this;
	}

	public function use(BaseModule $preset): self
	{
		$this->modules[] = $preset;

		return $this;
	}

	public function fn(callable $callback): self
	{
		$this->fns[] = $callback;

		return $this;
	}

	public function boot(): Kernel
	{
		$configurator = new Configurator();

		// Trigger presets
		array_map(fn (BasePreset $preset) => $preset->apply($this), $this->presets);

		// Trigger modules
		array_map(fn (BaseModule $module) => $module->apply($configurator, $this->config), $this->modules);

		// Trigger callbacks
		array_map(fn (callable $fn) => $fn($configurator, $this->config), $this->fns);

		return Kernel::of($configurator);
	}

}
