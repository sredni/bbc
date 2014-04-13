#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

use Sredni\Model\Basket;
use Sredni\Generator\RandomGenerator;
use Sredni\Verifier\ContainVerifier;
use Sredni\OutputDecorator\CliOutputDecorator;

$outputDecorator = new CliOutputDecorator();
$ballGenerator = new RandomGenerator('Sredni\\Model\\Ball', 1, 99);
$containsOnlyOneVerifier = new ContainVerifier(ContainVerifier::TYPE_ONLY_ONE);
$containsAllVerifier = new ContainVerifier(ContainVerifier::TYPE_ALL);
$resultContainsOnlyOne = [];
$resultContainsAll = [];
$baskets = [];

for ($i = 1; $i <= 3; $i++) {
	$basket = new Basket(sprintf('Basket #%s', $i), 10);

	$basket->fill($ballGenerator);
	$outputDecorator->printLine($basket->__toString());

	$baskets[] = $basket;
}

$userBasket = new Basket('User basket', 100);

$userBasket->fill($ballGenerator);
$outputDecorator->printLine($userBasket->__toString());

foreach ($baskets as $basket) {
	if ($containsAllVerifier->verify($userBasket, $basket)) {
		$resultContainsAll[] = $basket->getName();
	}

	if ($containsOnlyOneVerifier->verify($userBasket, $basket)) {
		$resultContainsOnlyOne[] = $basket->getName();
	}
}

$outputDecorator->printLine('Answer to B:');
$outputDecorator->printLine(implode(', ', $resultContainsAll));
$outputDecorator->printLine('Answer to C:');
$outputDecorator->printLine(implode(', ', $resultContainsOnlyOne));