<?php declare(strict_types = 1);

namespace Contributte\Kernel\Utils;

use Contributte\Kernel\Exception\LogicalException;

class Environments
{

	public const PREFIX = 'NETTE';
	public const DELIMITER = '__';
	public const DEBUG = 'NETTE_DEBUG';
	public const ENV = 'NETTE_ENV';
	public const COOKIE = 'nette-debug';

	/**
	 * @param mixed[] $variables
	 * @param non-empty-string $delimiter
	 * @return mixed[]
	 */
	public static function getVariables(array $variables, string $prefix = self::PREFIX, string $delimiter = self::DELIMITER): array
	{
		// @phpcs:ignore
		$map = static function (&$array, array $keys, $value) use (&$map) {
			if (count($keys) <= 0) {
				return $value;
			}

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
			if (strpos($key, $prefix . $delimiter) === 0 && $value !== false) {
				// Parse PREFIX{delimiter=__}{NAME-1}{delimiter=__}{NAME-N}
				$keys = explode($delimiter, strtolower(substr($key, strlen($prefix . $delimiter))));
				// Make array structure
				$map($parameters, $keys, $value);
			}
		}

		return $parameters;
	}

	public static function getEnvMode(): ?string
	{
		$env = (string) getenv(self::ENV);

		if ($env === '') {
			return null;
		}

		// remove special characters
		$env = preg_replace('/[^a-zA-Z0-9_]/', '', $env);

		return $env;
	}

	public static function isDebug(): bool
	{
		$debug = (string) getenv(self::DEBUG);

		return strtolower($debug) === 'true' || $debug === '1' || $debug === 'yes';
	}

	public static function isDebugCookie(?string $cookie): bool
	{
		if ($cookie === null || strlen($cookie) <= 0) {
			return false;
		}

		// phpcs:ignore
		return ($_COOKIE[self::COOKIE] ?? null) === $cookie;
	}

}
