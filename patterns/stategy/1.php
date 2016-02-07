<?php
abstract class Duck
{
	public function swim()
	{
		echo PHP_EOL . ' ' . __METHOD__;
	}

	abstract public function display();

	public function quack()
	{
		echo PHP_EOL . ' ' . __CLASS__ . ' кря-кря';
	}

	public function fly()
	{
		echo PHP_EOL . ' ' . __CLASS__ . ' замахала крыльями';
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
}

$duck = new MallardDuck();
$duck->display();
$duck->quack();
$duck = new RubberDuck();
$duck->display();
$duck->quack(); //резиновая утка крякать не должна

/**
* + все просто и естественно
* -	резиновая утка умеет крякать и летать, а егото не должно быть
*/