<?php
interface FlyBehavior
{
	public function fly(Duck $duck);
}

interface QuackBehavior
{
	public function quack();
}

abstract class Duck
{
	protected $fly_behavior;
	protected $quack_behavior;
	protected $fly_asign;

	public function __construct(FlyBehavior $fly, QuackBehavior $quack)
	{
		$this->setFlyBegavior($fly);
		$this->setQuackBegavior($quack);
	}

	public function setFlyAsign()
	{
		$this->fly_asign = true;
	}

	public function getFlyAsign()
	{
		return (bool)$this->fly_asign;
	}

	public function setFlyBegavior(FlyBehavior $fly)
	{
		$this->fly_behavior = $fly;
	}

	public function setQuackBegavior(QuackBehavior $quack)
	{
		$this->quack_behavior = $quack;
	}

	public function fly()
	{
		return $this->fly_behavior->fly($this);
	}

	public function quack()
	{
		return $this->quack_behavior->quack();
	}

	public function swim()
	{
		return 'плавание';
	}

	abstract public function display();
}

class FlyWithWings implements FlyBehavior
{
	public function fly(Duck $duck)
	{
		return 'реализация полета';
	}
}

class FlyNoWay implements FlyBehavior
{
	public function fly(Duck $duck)
	{
		if ($duck->getFlyAsign()) {
			return 'принудительный полет';
		}
	}
}

class QuackStandart implements QuackBehavior
{
	public function quack()
	{
		return 'крякание';
	}
}

class Squeak implements QuackBehavior
{
	public function quack()
	{
		return 'резиновые утки пищат';
	}
}

class MuteQuack implements QuackBehavior
{
	public function quack()
	{}
}

class MallardDuck extends Duck
{
	public function __construct()
	{
		$this->setFlyBegavior(new FlyWithWings());
		$this->setQuackBegavior(new QuackStandart());
	}

	public function display()
	{
		return __METHOD__;
	}
}

class RubberDuck extends Duck
{
	public function __construct()
	{
		$this->setFlyBegavior(new FlyNoWay());
		$this->setQuackBegavior(new Squeak());
	}

	public function display()
	{
		return __METHOD__;
	}
}

class DecoyDuck extends Duck
{
	public function __construct()
	{
		$this->setFlyBegavior(new FlyNoWay());
		$this->setQuackBegavior(new MuteQuack());
	}

	public function display()
	{
		return __METHOD__;
	}
}

$duck = new MallardDuck();
echo $duck->display() . PHP_EOL;
echo $duck->swim() . PHP_EOL;
echo $duck->quack() . PHP_EOL;
echo $duck->fly() . PHP_EOL;
$duck = new RubberDuck();
echo $duck->display() . PHP_EOL;
echo $duck->quack() . PHP_EOL; //резиновая утка крякать не должна
echo $duck->swim() . PHP_EOL;
$duck->setFlyAsign();
echo $duck->fly() . PHP_EOL; //резиновая утка не должна летать
$duck = new DecoyDuck();
echo $duck->display() . PHP_EOL;
echo $duck->swim() . PHP_EOL;
echo $duck->quack() . PHP_EOL; //резиновая утка крякать не должна
echo $duck->fly() . PHP_EOL; //резиновая утка не должна летать

/**
* - полностью неудачная попытка, невозможно унаследовать сразу от двух класов
*/