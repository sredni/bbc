<?php

namespace Sredni\Model;

use Sredni\Exception\AlreadyContainsException;
use Sredni\Generator\GeneratorInterface;
use Sredni\Verifier\Containable;

class Basket implements Containable, \Iterator
{
	/**
	 * @var String
	 */
	protected $name;
	/**
	 * @var integer
	 */
	protected $capacity;
	/**
	 * @var array
	 */
	protected $balls = [];

	/**
	 * @param integer $name
	 * @param integer $capacity
	 */
	public function __construct($name, $capacity)
	{
		$this->name = $name;
		$this->capacity = $capacity;
	}

	/**
	 * @param Ball $ball
	 * @return Basket
	 * @throws \Exception
	 */
	public function add(Ball $ball)
	{
		if (count($this->balls) > $this->capacity) {
			throw new \Exception('Cannot add ball, basket is full');
		}

		if ($this->contains($ball)) {
			throw new AlreadyContainsException('Basket already contains this ball');
		}

		$this->balls[] = $ball;

		return $this;
	}

	/**
	 * @param Ball $ball
	 * @return bool
	 * @throws \Exception
	 */
	public function contains($ball)
	{
		if (!$ball instanceof Ball) {
			throw new \Exception('Basket can only contains balls');
		}

		return in_array($ball, $this->balls);
	}

	/**
	 * @return integer
	 */
	public function getCapacity()
	{
		return $this->capacity;
	}

	/**
	 * @param GeneratorInterface $generator
	 */
	public function fill(GeneratorInterface $generator)
	{
		foreach ($generator->generate(rand(1, $this->getCapacity())) as $ball) {
			try {
				$this->add($ball);
			} catch (AlreadyContainsException $e) {
				//log
			}
		}
	}

	public function getName()
	{
		return (string)$this->name;
	}

	/**
	 * @return String
	 */
	public function __toString()
	{
		$result = $this->getName();

		if (count($this->balls)) {
			usort($this->balls, function($a, $b) {
				return $a->getNumber() < $b->getNumber() ? -1 : 1;
			});

			$result .= ': ' . implode(', ', $this->balls);
		}

		return $result;
	}

	/**
	 * @inheritdoc
	 */
	public function rewind()
	{
		reset($this->balls);
	}

	/**
	 * @inheritdoc
	 */
	public function current()
	{
		return current($this->balls);
	}

	/**
	 * @inheritdoc
	 */
	public function key()
	{
		return key($this->balls);
	}

	/**
	 * @inheritdoc
	 */
	public function next()
	{
		return next($this->balls);
	}

	/**
	 * @inheritdoc
	 */
	public function valid()
	{
		$key = key($this->balls);

		return ($key !== NULL && $key !== FALSE);
	}
}