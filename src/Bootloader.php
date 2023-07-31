<?php declare(strict_types = 1);

namespace Contributte\Kernel;

use Contributte\Kernel\Modules\BaseModule;

class Bootloader
{

	private Bootconf $config;

	/** @var BaseModule[] */
	private array $presets = [];

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

	public function use(BaseModule $preset): self
	{
		$this->presets[] = $preset;

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
		array_map(fn (BaseModule $preset) => $preset->apply($configurator, $this->config), $this->presets);

		// Trigger callbacks
		array_map(fn (callable $fn) => $fn($configurator, $this->config), $this->fns);

		return Kernel::of($configurator);
	}

}
