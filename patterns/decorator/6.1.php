<?php
interface Beverage
{
	public function getDescription();
	public function autor();
	public function cost();
}
abstract class BaseBeverage
{
	protected $description = 'дефелтное описание продукта';
	protected $cost = 0;

	public function getDescription()
	{
		return $this->description;
	}

	public function autor()
	{
		return 'Леонид Петровичь';
	}
}

class HouseBlend extends BaseBeverage implements Beverage
{
	protected $description = 'Древний рецепт кавы';

	public function cost()
	{
		return 12;
	}
}

class Decaf extends BaseBeverage implements Beverage
{
	protected $description = 'Горькое кофе';

	public function cost()
	{
		return 10;
	}

	public function autor()
	{
		return 'Итальянцы';
	}

	public function soAutor()
	{
		return 'Нестандартный метод';
	}
}

class Espresso extends BaseBeverage implements Beverage
{
	protected $description = 'Кластное кофе';

	public function cost()
	{
		return $this->cost + 11;
	}
}

abstract class DecoratorBeverage implements Beverage
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

	public function __construct(Beverage $decorete_obj)
	{
		$this->decorete_obj = $decorete_obj;
	}

	//интерфейс заставил создать метод который мы изначально декорировать не хоетли
	public function autor()
	{
		return $this->decorete_obj->autor();
	}
}

class Milk extends DecoratorBeverage implements Beverage
{
	public function cost()
	{
		$cost = $this->decorete_obj->cost();
		return $cost + 1;
	}
}

class Soy extends DecoratorBeverage implements Beverage
{
	public function cost()
	{
		$cost = $this->decorete_obj->cost();
		return $cost + 2;
	}
}

$cofe = new Decaf();
//вывести общую цену заказа
echo 'Общая цена = ' . $cofe->cost(); //+10
echo PHP_EOL . 'Описание продукта: ' . $cofe->getDescription();
echo PHP_EOL . 'Автор: ' . $cofe->autor();
echo PHP_EOL . 'SoАвтор: ' . $cofe->soAutor();

//добавленные новые возможности
$cofe_def = new Decaf();
$cofe_milk = new Milk($cofe_def);
$cofe_soy1 = new Soy($cofe_milk);
$cofe_new = new Soy($cofe_soy1);
//вывести общую цену заказа
echo PHP_EOL . 'Общая цена = ' . $cofe_new->cost(); //+10 общая 15
echo PHP_EOL . 'Описание продукта: ' . $cofe_new->getDescription();
echo PHP_EOL . 'Автор: ' . $cofe_new->autor();
echo PHP_EOL . 'SoАвтор: ' . $cofe_new->soAutor();
/**
* + этого подхода:
* 1) универсальный, всем известный способ
* 2) не меняем классы напитков
* - этого подхода:
* 3) небезопастное использование конструктора DecoreteBeverage, может попасть любой обьект
* 4) управлять отдельно ингридиентами не возможно, тоесть повторно использовать цену ингридиента в других местах невозможно
*/