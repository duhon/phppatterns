<?php
abstract class Beverage
{
	protected $description;
	protected $cost = 0;
	protected $size = 1; //1 маленькая, 2 средняя, 3 большая

	const SIZE_LARGE = 1;
	const SIZE_MEDIUM = 2;
	const SIZE_SMOLL = 3;

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

class Decorator
{
	/**
	* @var object
	*/
	protected $decorator_obj;

	/**
	* @var array
	*/
	protected $func = array();

	public function __construct($obj, array $params = null)
	{
		$this->decorator_obj = $obj;
		if (!empty($params)) {
			$this->func = $params;
		}
	}

	public function setMethodCall($function_name, Closure $decorate_function)
	{
		$this->func[$function_name] = $decorate_function;
	}

	public function __call($method, $args)
	{
		$return = call_user_func_array(array($this->decorator_obj, $method), $args);
		if (in_array($method, array_keys($this->func))) {
			return $this->func[$method]($return);
		}
		return $return;
	}

	public static function __callStatic($method, $args)
	{
		$return = call_user_func_array(array($this->decorator_obj, $method), $args);
		if (in_array($method, array_keys($this->func))) {
			return $this->func[$method]($return);
		}
		return $return;
	}

	public function __set($name, $value)
	{
		$this->decorator_obj->$name = $value;
	}

	public function __get($name)
	{
		return $this->decorator_obj->$name;
	}

	public function __isset($name)
	{
		return isset($this->decorator_obj->$name);
	}

	public function __unset($name)
	{
		unset($this->decorator_obj->$name);
	}

	public function __invoke()
	{
		$args = func_get_args();
	}
}

$cofe = new Decaf();
//вывести общую цену заказа
echo 'Общая цена = ' . $cofe->cost() . PHP_EOL; //+10
echo 'Описание продукта: ' . $cofe->getDescription();

//добавленные новые возможности
$def_cofe = new Decaf();
$cofe = new Decorator($def_cofe,
	array(
		'cost' => function ($cost){
			return $cost + 5;
		},
		'getDescription' => function ($descr){
			return $descr . ' + сахар';
		},
	)
);
$cofe = new Decorator($cofe, array(
	'cost' => function ($cost){
		return $cost + 1;
	},
	'getDescription' => function ($descr){
		return $descr . ' + молоко';
	},
));
$cofe->setSize(Decaf::SIZE_MEDIUM);

//вывести общую цену заказа
echo PHP_EOL . 'Общая цена = ' . $cofe->cost(); //+10 общая 15
echo PHP_EOL . 'Описание продукта: ' . $cofe->getDescription();
echo PHP_EOL . 'Размер: ' . $cofe->getSize();
