<?php

/**
* пришлось расширить стандартный интерфейс subject
*/
interface ISubject extends SplSubject
{
	public function attach(SplObserver $observer, array $args = null);
	public function detach(SplObserver $observer);
	public function notify($args = null);
}

/**
* вынес в отдельный класс Subject, минус в том что нужно он него нанследоваться
*/
abstract class ASubject implements ISubject
{
	private $_observers;

	public function __construct()
	{
		/**
		* все обверверы будут теперь в нулевом подмасиве $this->_observers кроме тех которые на определенный аспекты поведения
		*
		* @var ASubject
		*/
		$this->_observers[null] = new SplObjectStorage();
	}

	/**
	* добавил новый входящий аргумент $args который указывает на желаемые аспекты поведения наблюдаемого обьекта
	*
	* @param SplObserver $observer
	* @param array $args
	*/
	final public function attach(SplObserver $observer, array $args = null)
	{
		if (!empty($args)) {
			foreach($args as $prop) {
				if (method_exists($this, $prop)) {
					if (!isset($this->_observers[$prop])) {
						$this->_observers[$prop] = new SplObjectStorage();
					}
					$this->_observers[$prop]->attach($observer);
				}
			}
		} else {
			$this->_observers[null]->attach($observer);
		}
	}

	/**
	* массив $this->_observers стал многомерным поэтому очищаем его рекурсивно
	*
	* @param SplObserver $observer
	*/
	final public function detach(SplObserver $observer)
	{
		array_walk_recursive($this->_observers, function($val)use($observer){
			$val->detach($observer);
		});
	}

	/**
	* входящий параметр $arg это аспект поведения который обновился, к сожелению пока что только одно поведение за раз может меняться
	*
	* @param mixed $arg
	*/
	final public function notify($arg = null)
	{
		if (isset($this->_observers[$arg])) {
			foreach ($this->_observers[$arg] as $observer) {
				$observer->update($this);
			}
		}
	}
}

class AccessClass
{
	protected $obj;
	static protected $obj_name;

	public function  __construct($obj)
	{
		$this->obj = $obj;
		self::$obj_name = get_class($obj);
	}

	public function __call($name, $arguments)
	{
		return call_user_func_array(array($this->obj, $name), $arguments);
	}

	public static function __callStatic($name, $arguments)
	{
		return call_user_func_array(array(self::$obj_name, $name), $arguments);
	}

	public function __get($name)
	{
		return $this->obj->$name;
	}

	public function __set($name, $value)
	{
		$this->obj->$name = $value;
	}

	public function __isset($name)
	{
		return isset($this->obj->$name);
	}

	public function __unset($name)
	{
		unset($this->obj->$name);
	}
}

/**
* добавил прокси что бы вынести с методов WeatherData дублированую информацию о нотификации,
* теперь можно управлять кто будет уведомлять сам класс WeatherData совместно с прокси или же сам клиент
*/
class ProxyWeatherData extends AccessClass
{
	public function __call($name, $args)
	{
		if (in_array($name, array('setTemperature', 'setHumidity', 'setPressure'))) {
			$return = call_user_func_array(array($this->obj, $name), $args);
			$this->obj->notify('g' . substr($name, 1));
		}
		return parent::__call($name, $args);
	}
}

class WeatherData extends ASubject
{
	protected $temp;
	protected $humidity;
	protected $pressure;

	public function __construct($temp, $humidity, $pressure)
	{
		parent::__construct();
		$this->temp = $temp;
		$this->humidity = $humidity;
		$this->pressure = $pressure;
	}

	public function setTemperature($temp)
	{
		$this->temp = $temp;
	}

	public function setHumidity($humidity)
	{
		$this->humidity = $humidity;
	}

	public function setPressure($pressure)
	{
		$this->pressure = $pressure;
	}

	public function getTemperature()
	{
		return $this->temp . ' C';
	}

	public function getHumidity()
	{
		return $this->humidity . ' %';
	}

	public function getPressure()
	{
		return $this->pressure . ' Атмосфер';
	}
}

class CurrentConditionsDisplay implements SplObserver
{
	protected $subject;

	public function __construct($subject)
	{
		$subject->attach($this);
		$this->subject = $subject;
	}

	public function update(SplSubject $subject)
	{
		if ($subject instanceof ISubject) {
			$temp = $subject->getTemperature();
			$pressure = $subject->getPressure();
			$humidity = $subject->getHumidity();

			echo "текущие метки: temp = $temp, humidity = $humidity, pressure = $pressure" . PHP_EOL;
		}
	}

	/**
	* добавил отписку для обсерверов, это важно, нужно всегда отписиваться
	* но данный способ бесполезен, на обьект 2 ссылки, в глоб. обл. и в субьекте.
	*/
	public function __destruct()
	{
		$this->subject->detach($this);
	}
}

class StatisticsDisplay implements SplObserver
{
	public function update(SplSubject $subject)
	{
		$temp = $subject->getTemperature();
		$pressure = $subject->getPressure();
		$humidity = $subject->getHumidity();
		echo "отображение статистики: temp = $temp, humidity = $humidity, pressure = $pressure" . PHP_EOL;
	}
}

class ForecastDisplay implements SplObserver
{
	public function update(SplSubject $subject)
	{
		$temp = $subject->getTemperature();
		$pressure = $subject->getPressure();
		echo "отображение прогноза температурного давления: temp = $temp, pressure = $pressure" . PHP_EOL;
	}
}

$weather_data = new ProxyWeatherData(new WeatherData(10, 10, 10));
$weather_data->attach(new StatisticsDisplay);

$fd = new ForecastDisplay;
$weather_data->attach($fd, array('getTemperature', 'getPressure'));
/**
* удаление тут обьекта не удалит обьект, а значит событие сработает, очень плохо
*/
unset($fd);

$cond_ob = new CurrentConditionsDisplay($weather_data);
$weather_data->notify();
unset($cond_ob);
echo '-----------------' . PHP_EOL;
$weather_data->setTemperature(20);