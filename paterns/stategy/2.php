<?php
abstract class Duck
{
	public function swim()
	{
		echo PHP_EOL . ' ' . get_called_class();
	}

	abstract public function display();

	public function quack()
	{
		echo PHP_EOL . ' ' . get_called_class() . ' кря-кря';
	}

	public function fly()
	{
		echo PHP_EOL . ' ' . get_called_class() . ' замахала крыльями';
	}
}

class MallardDuck extends Duck
{
	public function display()
	{
		echo PHP_EOL . ' ' . __METHOD__;
	}
}

class RubberDuck
{
	public function display()
	{
		echo PHP_EOL . ' ' . __METHOD__;
	}

	public function quack()
	{
		echo PHP_EOL . ' ' . __CLASS__ . ' гум-гум';
	}

	public function fly()
	{
		echo PHP_EOL . ' ' . __CLASS__ . ' не умеет летать';
	}
}

class DecoyDuck
{
	public function display()
	{
		echo PHP_EOL . ' ' . __METHOD__;
	}

	public function quack()
	{
		echo PHP_EOL . ' ' . __CLASS__ . ' не крякает';
	}

	public function fly()
	{
		echo PHP_EOL . ' ' . __CLASS__ . ' не умеет летать';
	}
}

$duck = new MallardDuck();
$duck->display();
$duck->quack();
$duck->fly();
$duck = new RubberDuck();
$duck->display();
$duck->quack(); //резиновая утка крякать не должна
$duck->fly(); //резиновая утка не должна летать
$duck = new DecoyDuck();
$duck->display();
$duck->quack(); //резиновая утка крякать не должна
$duck->fly(); //резиновая утка не должна летать

/**
* + все просто и естественно
* +	резиновая утка не умеет крякать и летать, как и должно быть
* - при создании большого количества проблемных уток нужно заново реализовывать пустые методы quack b fly
*/