<?php
abstract class Beverage
{
	protected $description;
	protected $cost = 0;

	public function getDescription()
	{
		return $this->description;
	}

	abstract public function cost();
}

class HouseBlend extends Beverage
{
	protected $description = 'Древний рецепт кавы';

	public function cost()
	{
		return 12;
	}
}

class Decaf extends Beverage
{
	protected $description = 'Горькое кофе';

	public function cost()
	{
		return 10;
	}
}

class Espresso extends Beverage
{
	protected $description = 'Горькое кофе';

	public function cost()
	{
		return 11;
	}
}

$cofe = new Decaf();
//вывести общую цену заказа
echo 'Общая цена = ' . $cofe->cost() . PHP_EOL; //+10
echo 'Описание продукта: ' . $cofe->getDescription();