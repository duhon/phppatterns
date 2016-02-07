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
	private $_all_cost = 0;

	public function addIngridient(Ingridient $ingridient)
	{
		$this->ingridients[] = $ingridient;
		$this->_all_cost += $ingridient->cost();
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

	public function getAllCost()
	{
		return $this->_all_cost + $this->cost();
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

//добавленные новые возможности
$cofe = new Decaf();
$cofe->addIngridient(new Milk); //+1
$cofe->addIngridient(new Soy); //+2
$cofe->addIngridient(new Soy); //+2
//вывести общую цену заказа
echo PHP_EOL . 'Общая цена = ' . $cofe->getAllCost() . PHP_EOL; //+10 общая 15
echo 'Описание продукта: ' . $cofe->getDescription();
//получить список ингридиентов
echo PHP_EOL .'Ингридиенты:';
foreach($cofe->getIngridients() as $ingridient) {
	echo  PHP_EOL . get_class($ingridient) . ' = ' . $ingridient->cost();
}

/**
* + этого подхода:
* 1) отдельные класы ингридиентов лучше можно использовать в системе
* 2) напиток имеет отдельно свою цену и общую цену напитка с ингридиентами и цену каждого ингридиента
* 3) легко добавлять новый ингридиент
* - этого подхода:
* 1) в напитке будет 2 метода цена и общая цена, возможна путаница
*/