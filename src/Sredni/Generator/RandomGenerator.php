<?php

namespace Sredni\Generator;

class RandomGenerator implements GeneratorInterface
{
	/**
	 * @var String
	 */
	protected $className;
	/**
	 * @var integer
	 */
	protected $rangeFrom;
	/**
	 * @var integer
	 */
	protected $rangeTo;

	/**
	 * @param String $className
	 * @param integer $rangeTo
	 * @param integer $rangeFrom
	 * @throws \Exception
	 */
	public function __construct($className, $rangeFrom = 1, $rangeTo = 999)
	{
		$reflectionClass = New \ReflectionClass($className);

		if (!$reflectionClass->implementsInterface('Sredni\\Generator\\Generatable')) {
			throw new \Exception('Class passed to generator must implements Generatable interface');
		}

		if ($rangeFrom > $rangeTo) {
			throw new \Exception('RangeFrom value must be less than or equal to rangeTo value');
		}

		$this->className = $className;
		$this->rangeFrom = $rangeFrom;
		$this->rangeTo = $rangeTo;
	}

	/**
	 * @param int $length
	 * @yield Generatable
	 * @return Generatable
	 * @throws \Exception
	 */
	public function generate($length = 1)
	{
		if ($length < 1) {
			throw new \Exception('Length must be greater than 0');
		}

		$className = $this->className;
		$rangeFrom = $this->rangeFrom;
		$rangeTo = $this->rangeTo;

		for ($i = 1; $i <= $length; $i++) {
			$object = new $className();

			$object->setNumber(mt_rand($rangeFrom, $rangeTo));

			yield $object;
		}
	}
}