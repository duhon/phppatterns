<?php
/**
* Добавились региональные стили приготовления пиццы
* нужно другое решение
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

class NYCheesePizza extends CheesePizza
{
	public function prepare()
	{
		echo $this->getName() . ': подготовка толстой основы пиццы' . PHP_EOL;
	}
}

class ChicagoCheesePizza extends CheesePizza
{
 public function cut()
	{
		echo $this->getName() . ': нарезка пиццы квадратиками' . PHP_EOL;
	}
}

class PepperoniPizza extends Pizza
{
}

class NYPepperoniPizza extends PepperoniPizza
{
	public function prepare()
	{
		echo $this->getName() . ': подготовка тонкой основы пиццы' . PHP_EOL;
	}
}

class ChicagoPepperoniPizza extends PepperoniPizza
{
 public function cut()
	{
		echo $this->getName() . ': нарезка пиццы квадратиками и одним кружочком' . PHP_EOL;
	}
}

class PizzaStore
{
	protected $pizza_factory;

	public function __construct(SimplePizzaFactory $pizza_factory)
	{
		$this->pizza_factory = $pizza_factory;
	}

	public function orderPizza($type)
	{
		$pizza = $this->pizza_factory->createPizza($type);
		$pizza->prepare();
		$pizza->bake();
		$pizza->cut();
		$pizza->box();

		return $pizza;
	}
}

class SimplePizzaFactory
{
	protected $name;

	public function __construct()
	{
		$this->name = preg_replace('/Pizza.*/', '', get_called_class());
	}

	public function createPizza($type)
	{
		switch ($type) {
			case 'cheese':
				$class_name_pizza = $this->getClassNamePizza('CheesePizza');
				break;
			case 'pepperoni':
				$class_name_pizza = $this->getClassNamePizza('PepperoniPizza');
				break;
		}
		$pizza = new $class_name_pizza;
		return $pizza;
	}

	protected function getClassNamePizza($simple_class_name)
	{
		return $this->getName() . $simple_class_name;
	}

	protected function getName()
	{
		return $this->name;
	}
}

class NYPizzaFactory extends SimplePizzaFactory
{
}

class ChicagoPizzaFactory extends SimplePizzaFactory
{
}

//-----Проба-------------
echo 'В ньюйорке проиходило дело' . PHP_EOL;
$ny_order = new PizzaStore(new NYPizzaFactory());
echo 'Вася заказал пиццу cheese' . PHP_EOL;
$ny_order->orderPizza('cheese');
echo 'Коля заказал пиццу pepperoni' . PHP_EOL;
$ny_order->orderPizza('pepperoni');

echo 'В чикаго было дело' . PHP_EOL;
$ch_order = new PizzaStore(new ChicagoPizzaFactory());
echo 'Вася заказал пиццу cheese' . PHP_EOL;
$ch_order->orderPizza('cheese');
echo 'Коля заказал пиццу pepperoni' . PHP_EOL;
$ch_order->orderPizza('pepperoni');

echo 'ГОТОВО';