<?php

namespace Sredni\Verifier;

class ContainVerifier
{
	const TYPE_ALL = 0;
	const TYPE_ONLY_ONE = 1;

	/**
	 * @var array
	 */
	public static $TYPES = [
		self::TYPE_ALL,
		self::TYPE_ONLY_ONE,
	];

	/**
	 * @param string $type
	 * @throws \Exception
	 */
	public function __construct($type)
	{
		if (!in_array($type, self::$TYPES)) {
			throw new \Exception('Invalid type');
		}

		$this->type = $type;
	}

	/**
	 * @param Containable $objectToCheck
	 * @param array $values
	 * @return bool
	 */
	public function verify(Containable $objectToCheck, $values)
	{
		$result = true;
		$containsNo = 0;

		foreach ($values as $value) {
			if ($objectToCheck->contains($value)) {
				$containsNo++;

				if ($this->type === self::TYPE_ONLY_ONE && $containsNo > 1) {
					$result = false;

					break;
				}
			} elseif ($this->type === self::TYPE_ALL) {
				$result = false;

				break;
			}
		}

		if ($this->type === self::TYPE_ONLY_ONE && $containsNo !== 1) {
			$result = false;
		}

		return $result;
	}
}