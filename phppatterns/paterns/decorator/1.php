<?php
abstract class Beverage
{
	protected $description;
	protected $cost = 0;

	protected $ingridient;

	public function getDescription()
	{
		return $this->description;
	}

	public function setMilk()
	{
		$this->milk = true;
		$this->cost += 1;
		$this->description .= ' + Milk';
	}

	public function hasMilk()
	{
		return (bool) $this->milk;
	}

	public function setSoy()
	{
		$this->soy = true;
		$this->cost += 2;
		$this->description .= ' + Soy';
	}

	public function hasSoy()
	{
		return (bool) $this->soy;
	}

	abstract public function cost();
}

class HouseBlend extends Beverage
{
	protected $description = 'Древний рецепт кавы';

	public function cost()
	{
		return $this->cost + 12;
	}
}

class Decaf extends Beverage
{
	protected $description = 'Горькое кофе';

	public function cost()
	{
		return $this->cost + 10;
	}
}

class Espresso extends Beverage
{
	protected $description = 'Горькое кофе';

	public function cost()
	{
		return $this->cost + 11;
	}
}

$cofe = new Decaf();
//вывести общую цену заказа
echo 'Общая цена = ' . $cofe->cost() . PHP_EOL; //+10
echo 'Описание продукта: ' . $cofe->getDescription();

//добавленные новые возможности
$cofe = new Decaf();
$cofe->setMilk(); //+1
$cofe->setSoy(); //+2
$cofe->setSoy(); //+2
//вывести общую цену заказа
echo PHP_EOL . 'Общая цена = ' . $cofe->cost() . PHP_EOL; //+10
echo 'Описание продукта: ' . $cofe->getDescription();

/**
* + этого подхода:
* 1) очень быстро
* 2) очень просто
* 3) всем понятно
* 4) не меняем классы напитков
* - этого подхода:
* 1) при добавлении нового ингридиента нужно меняем абстрактный класс, это может повлиять на разных стремных наследников
* 2) много мусора в методах, если будет много компонентов
* 3) методы setMilk и тд. логически не относятся к классу Beverage
* 4) управлять отдельно ингридиентами не возможно, тоесть повторно использовать цену ингридиента в других местах невозможно
*/