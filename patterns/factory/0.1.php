<?php
/**
* Добавились разные виды пицц
*/

abstract class Pizza
{
	protected $name;

	public function __construct()
	{
		$this->name = preg_replace('/Pizza.*/', '', get_called_class());
	}

	public function prepare()
	{
		echo $this->getName() . ': подготовка основы пиццы' . PHP_EOL;
	}

	public function bake()
	{
		echo $this->getName() . ': выпикание пиццы' . PHP_EOL;
	}

	public function cut()
	{
		echo $this->getName() . ': нарезка пиццы' . PHP_EOL;
	}

	public function box()
	{
		echo $this->getName() . ': упаковка пиццы' . PHP_EOL;
	}

	protected function getName()
	{
		return $this->name;
	}
}

class CheesePizza extends Pizza
{
}

class GreekPizza extends Pizza
{
}

class PepperoniPizza extends Pizza
{
}

class PizzaStore
{
	public function orderPizza($type)
	{
		switch ($type) {
			case 'cheese':
				$pizza = new CheesePizza();
				break;
			case 'greek':
				$pizza = new GreekPizza();
				break;
			case 'pepperoni':
				$pizza = new PepperoniPizza();
				break;
		}

		$pizza->prepare();
		$pizza->bake();
		$pizza->cut();
		$pizza->box();
	}
}

//-----Проба-------------
$order = new PizzaStore();
echo 'Вася заказал пиццу cheese' . PHP_EOL;
$order->orderPizza('cheese');
echo 'Коля заказал пиццу greek' . PHP_EOL;
$order->orderPizza('greek');
echo 'ГОТОВО';