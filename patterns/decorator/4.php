<?php
abstract class Ingridient
{
	protected $cost = 0;

	public function cost()
	{
		return $this->cost;
	}
}

class Milk extends Ingridient
{
	protected $cost = 1;
}

class Soy extends Ingridient
{
	protected $cost = 2;
}

abstract class Beverage
{
	protected $description;
	protected $cost = 0;
	protected $ingridients;

	public function addIngridient(Ingridient $ingridient)
	{
		$this->ingridients[] = $ingridient;
		$this->cost += $ingridient->cost();
	}

	public function getIngridients()
	{
		return $this->ingridients;
	}

	public function hasIngridients()
	{
		return !empty($this->ingridients);
	}

	public function getDescription()
	{
		$description = $this->description;
		if ($this->hasIngridients()) {
			foreach($this->getIngridients() as $ingridient) {
				$description .= ' + ' . get_class($ingridient);
			}
		}
		return $description;
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
$cofe->addIngridient(new Milk); //+1
$cofe->addIngridient(new Soy); //+2
$cofe->addIngridient(new Soy); //+2
//вывести общую цену заказа
echo PHP_EOL . 'Общая цена = ' . $cofe->cost() . PHP_EOL; //+10 общая 15
echo 'Описание продукта: ' . $cofe->getDescription();
//получить список ингридиентов
echo PHP_EOL .'Ингридиенты:';
foreach($cofe->getIngridients() as $ingridient) {
	echo  PHP_EOL . get_class($ingridient) . ' = ' . $ingridient->cost();
}

/**
* + этого подхода:
* 1) отдельные класы ингридиентов лучше можно использовать в системе
* 2) возможность легко управлять ингридиентами в класах напитков
* - этого подхода:
* 1) меняються классы напитков
* 4) теряется цена напитка без ингридиентов
*/