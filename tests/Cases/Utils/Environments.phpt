<?php declare(strict_types = 1);

namespace Tests\Cases\Override;

use Contributte\Kernel\Utils\Environments;
use Contributte\Tester\Toolkit;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

Toolkit::test(static function (): void {
	putenv('NETTE_DEBUG=1');
	Assert::true(Environments::isDebug());
	putenv('NETTE_DEBUG=0');
	Assert::false(Environments::isDebug());
});
