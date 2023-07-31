<?php declare(strict_types = 1);

namespace Contributte\Kernel;

class Bootconf
{

	public function __construct(
		private string $root
	)
	{
	}

	public function getRoot(): string
	{
		return $this->root;
	}

}
