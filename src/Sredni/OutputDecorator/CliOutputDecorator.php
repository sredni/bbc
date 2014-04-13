<?php

namespace Sredni\OutputDecorator;

class CliOutputDecorator
{
	public function printLine($message)
	{
		echo  $message . PHP_EOL;
	}
}