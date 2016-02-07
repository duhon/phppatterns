<?php
class WeatherData
{
	protected $temp;
	protected $humidity;
	protected $pressure;

	public function __construct($temp, $humidity, $pressure)
	{
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

class Subject extends AccessClass implements SplSubject
{
	private $_observers;

	public function __construct($obj)
	{
		parent::__construct($obj);
		$this->_observers = new SplObjectStorage();
	}

	public function attach(SplObserver $observer)
	{
			$this->_observers->attach($observer);
	}

	public function detach(SplObserver $observer)
	{
		$this->_observers->detach($observer);
	}

	public function notify()
	{
		foreach ($this->_observers as $observer) {
			$observer->update($this);
		}
	}
}

class AccessClass
{
	protected $obj;

	public function  __construct($obj)
	{
		$this->obj = $obj;
	}

	public function __call($name, $arguments)
	{
		return call_user_func_array(array($this->obj, $name), $arguments);
	}

	public static function __callStatic($name, $arguments)
	{
		return call_user_func_array(array($this->obj, $name), $arguments);
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

class CurrentConditionsDisplay implements SplObserver
{
	public function __construct(SplSubject $subject)
	{
		$subject->attach($this);
	}

	public function update(SplSubject $subject)
	{
		$temp = $subject->getTemperature();
		$pressure = $subject->getPressure();
		$humidity = $subject->getHumidity();
		echo "текущие метки: temp = $temp, humidity = $humidity, pressure = $pressure" . PHP_EOL;
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

$weather_data = new WeatherData(10, 10, 10);
$subject_weather = new Subject($weather_data);
//наблюдатель создается и сам подписывается на обновление
$cond_ob = new CurrentConditionsDisplay($subject_weather);
$forec_ob = new ForecastDisplay();
$subject_weather->attach($forec_ob);
$subject_weather->notify();
//$weather_data->measurementsChanged();
echo '-----------------' . PHP_EOL;
$weather_data->setTemperature(20);
//обновим всех наблюдателей
$subject_weather->notify();