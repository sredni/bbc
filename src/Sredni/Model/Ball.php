<?php

namespace Sredni\Model;

use Sredni\Generator\Generatable;

class Ball implements Generatable
{
	/**
	 * @var integer
	 */
	protected $number;

	/**
	 * @param integer $number
	 * @return Ball
	 */
	public function setNumber($number)
	{
		$this->number = $number;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getNumber()
	{
		return $this->number;
	}

	/**
	 * @return String
	 */
	public function __toString()
	{
		return (string)$this->getNumber();
	}
}