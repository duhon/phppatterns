<?php
interface Flyable
{
	public function fly();
}

interface Quackable
{
	public function quack();
}

abstract class Duck
{
	public function swim()
	{
		echo PHP_EOL . ' ' . get_called_class();
	}

	abstract public function display();
}

abstract class FlyDuck extends Duck
{
	abstract public function fly();
}

abstract class QuackDuck extends Duck
{
	abstract public function quack();
}

abstract class QuackFlyDuck extends QuackDuck
{}

class MallardDuck extends QuackFlyDuck
{
	public function display()
	{
		echo PHP_EOL . ' ' . __METHOD__;
	}

	public function quack()
	{
		echo PHP_EOL . ' ' . get_called_class() . ' кря-кря';
	}

	public function fly()
	{
		echo PHP_EOL . ' ' . get_called_class() . ' замахала крыльями';
	}
}

class RubberDuck extends QuackDuck
{
	public function display()
	{
		echo PHP_EOL . ' ' . __METHOD__;
	}

	public function quack()
	{
		echo PHP_EOL . ' ' . __CLASS__ . ' гум-гум';
	}
}

class DecoyDuck extends Duck
{
	public function display()
	{
		echo PHP_EOL . ' ' . __METHOD__;
	}
}

$duck = new MallardDuck();
$duck->display();
$duck->quack();
$duck->fly();
$duck = new RubberDuck();
$duck->display();
$duck->quack(); //резиновая утка крякать не должна
$duck instanceof Flyable && $duck->fly(); //резиновая утка не должна летать
$duck = new DecoyDuck();
$duck->display();
$duck instanceof Quackable && $duck->quack(); //резиновая утка крякать не должна
$duck instanceof Flyable && $duck->fly(); //резиновая утка не должна летать

/**
* - полностью неудачная попытка, невозможно унаследовать сразу от двух класов
*/