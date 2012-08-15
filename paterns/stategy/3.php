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

class MallardDuck extends Duck implements Flyable, Quackable
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

class RubberDuck extends Duck implements Quackable
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
* +	резиновая утка не умеет крякать и летать, как и должно быть
* - нужно каждый раз реализовывать методы fly и quack для конкретных классов которые могут его реализовать
*/