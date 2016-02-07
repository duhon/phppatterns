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
	protected $size = 1; //1 маленькая, 2 средняя, 3 большая

	public function getDescription()
	{
		return $this->description;
	}

	public function setSize($size)
	{
		$this->size = $size;
	}

	public function getSize()
	{
		return $this->size;
	}

	abstract public function cost();
}

abstract class DecoratorSizeBeverage extends Beverage
{
	/**
	* @var Beverage
	*/
	protected $decorator_obj;

	public function __construct(Beverage $beverage)
	{
		$this->decorator_obj = $beverage;
	}

	public function getSize()
	{
		return $this->decorator_obj->getSize();
	}
}

class SmallSizeBeverage extends DecoratorSizeBeverage
{
	public function cost()
	{
		return $this->decorator_obj->cost() + .10;
	}
}


class MediumSizeBeverage extends DecoratorSizeBeverage
{
	public function cost()
	{
		return $this->decorator_obj->cost() + .20;
	}
}


class BigSizeBeverage extends DecoratorSizeBeverage
{
	public function cost()
	{
		return $this->decorator_obj->cost() + .30;
	}
}

class BeverageIngridient
{
	protected $ingridients;
	protected $beverage;
	protected $cost = 0;

	public function __construct(Beverage $beverage)
	{
		$this->beverage = $beverage;
		$this->cost = $beverage->cost();
	}

	public function getIngridients()
	{
		return $this->ingridients;
	}

	public function hasIngridients()
	{
		return !empty($this->ingridients);
	}

	public function addIngridient(Ingridient $ingridient)
	{
		$this->ingridients[] = $ingridient;
		$this->cost += $ingridient->cost();
	}

	public function getBeverage()
	{
		return $this->beverage;
	}

	public function getDescription()
	{
		$description = $this->beverage->getDescription();
		if ($this->hasIngridients()) {
			foreach($this->getIngridients() as $ingridient) {
				$description .= ' + ' . get_class($ingridient);
			}
		}
		return $description;
	}

	public function cost()
	{
		return $this->cost;
	}
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
$def_cofe = new Decaf();
$def_cofe->setSize(3);
$cofe = new BeverageIngridient(new BigSizeBeverage($def_cofe));
$cofe->addIngridient(new Milk); //+1
$cofe->addIngridient(new Soy); //+2
$cofe->addIngridient(new Soy); //+2
//вывести общую цену заказа
echo PHP_EOL . 'Общая цена = ' . $cofe->cost(); //+10 общая 15
echo PHP_EOL . 'Описание продукта: ' . $cofe->getDescription();
echo PHP_EOL . 'Размер порции: ' . $cofe->getBeverage()->getSize();