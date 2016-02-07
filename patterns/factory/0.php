<?php
/**
* Пицерия готовит всего одну пиццу
*/

class Pizza
{
	public function prepare()
	{
		echo '-подготовка основы пиццы' . PHP_EOL;
	}

	public function bake()
	{
		echo '-выпикание пиццы' . PHP_EOL;
	}

	public function cut()
	{
		echo '-нарезка пиццы' . PHP_EOL;
	}

	public function box()
	{
		echo '-упаковка пиццы' . PHP_EOL;
	}
}

class PizzaStore
{
	public function orderPizza()
	{
		$pizza = new Pizza();

		$pizza->prepare();
		$pizza->bake();
		$pizza->cut();
		$pizza->box();

		return $pizza;
	}
}

echo 'Клиент заказывает пиццу' . PHP_EOL;
$order = new PizzaStore();
$order->orderPizza();
echo 'ГОТОВО';