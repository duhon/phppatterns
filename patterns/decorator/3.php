<?php
abstract class Beverage
{
	protected $description = 'дефелтное описание продукта';
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
		return $this->cost + 11;
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

/**
* + этого подхода:
* 1) универсальный, всем известный способ
* 2) не меняем классы напитков
* - этого подхода:
* 3) ингридиент поддерживает интерфейс напитка, но таким не является
* 4) управлять отдельно ингридиентами не возможно, тоесть повторно использовать цену ингридиента в других местах невозможно
*/