<?php declare(strict_types = 1);

namespace Contributte\Kernel\Utils;

use Contributte\Kernel\Exception\LogicalException;

class Environments
{

	public const PREFIX = 'NETTE';
	public const DELIMITER = '__';
	public const DEBUG = 'NETTE_DEBUG';

	/**
	 * @param mixed[] $variables
	 * @param non-empty-string $delimiter
	 * @return mixed[]
	 */
	public static function getVariables(array $variables, string $prefix = self::PREFIX, string $delimiter = self::DELIMITER): array
	{
		// @phpcs:ignore
		$map = function (&$array, array $keys, $value) use (&$map) {
			if (count($keys) <= 0)

				return $value;

			$key = array_shift($keys);

			if (!is_array($array)) {
				throw new LogicalException(sprintf('Invalid structure for key "%s" value "%s"', implode($keys), $value));
			}

			if (!array_key_exists($key, $array)) {
				$array[$key] = [];
			}

			// Recursive
			$array[$key] = $map($array[$key], $keys, $value);

			return $array;
		};

		$parameters = [];
		foreach ($variables as $key => $value) {
			// Ensure value
			$value = getenv($key);
			if (strpos($key, $prefix) === 0 && $value !== false) {
				// Parse PREFIX{delimiter=__}{NAME-1}{delimiter=__}{NAME-N}
				$keys = explode($delimiter, $key);
				// Make array structure
				$map($parameters, $keys, $value);
			}
		}

		return $parameters;
	}

	public static function isDebug(): bool
	{
		$debug = (string) getenv(self::DEBUG);

		return strtolower($debug) === 'true' || $debug === '1' || $debug === 'yes';
	}

}
