<?php
abstract class Beverage
{
	protected $description = 'дефелтное описание продукта';
	protected $cost = 0;
	protected $size = 1;

	const SIZE_LARGE = 1;
	const SIZE_MEDIUM = 2;
	const SIZE_SMOLL = 3;

	public function getDescription()
	{
		return $this->description;
	}

	public function getSize()
	{
		return $this->size;
	}

	public function setSize($size)
	{
		$this->size = $size;
	}

	public function cost()
	{
		switch ($this->getSize()) {
			case self::SIZE_LARGE:
				return $this->cost + .30;
			break;
			case self::SIZE_MEDIUM:
				return $this->cost + .20;
			break;
			case self::SIZE_SMOLL:
				return $this->cost + .10;
			break;
		}
	}
}

class HouseBlend extends Beverage
{
	protected $description = 'Древний рецепт кавы';

	public function cost()
	{
		return parent::cost() + 12;
	}
}

class Decaf extends Beverage
{
	protected $description = 'Горькое кофе';

	public function cost()
	{
		return parent::cost() + 10;
	}
}

class Espresso extends Beverage
{
	protected $description = 'Горькое кофе';

	public function cost()
	{
		return parent::cost() + 11;
	}
}

abstract class DecoratorBeverage extends Beverage
{
	/**
	* декорируемый обьект
	*
	* @var Beverage
	*/
	protected $decorete_obj;

	protected $cost;

	public function getDescription()
	{
		return $this->decorete_obj->getDescription() . ' + ' . get_class($this);
	}

	public function cost()
	{
		return $this->decorete_obj->cost();
	}

	public function __construct(Beverage $decorete_obj)
	{
		$this->decorete_obj = $decorete_obj;
		$this->cost = $this->cost();
	}
}

class Milk extends DecoratorBeverage
{
	public function cost()
	{
		return parent::cost() + 1;
	}
}

class Soy extends DecoratorBeverage
{
	public function cost()
	{
		return parent::cost() + 2;
	}
}

$cofe = new Decaf();
//вывести общую цену заказа
echo 'Общая цена = ' . $cofe->cost() . PHP_EOL; //+10
echo 'Описание продукта: ' . $cofe->getDescription();

//добавленные новые возможности
$cofe_def = new Decaf();
$cofe_milk = new Milk($cofe_def);
$cofe_soy1 = new Soy($cofe_milk);
$cofe_new = new Soy($cofe_soy1);
//вывести общую цену заказа
echo PHP_EOL . 'Общая цена = ' . $cofe_new->cost() . PHP_EOL; //+10 общая 15
echo 'Описание продукта: ' . $cofe_new->getDescription();