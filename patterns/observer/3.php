<?php
interface ISubject extends SplSubject
{
	public function attach(SplObserver $observer, array $args = null);
	public function detach(SplObserver $observer);
	public function notify(array $args = null);
	public function setChangeObservers();
}

abstract class ASubject implements ISubject
{
	private $_observers;
	private $_is_change = false;

	public function __construct()
	{
		$this->_observers = new SplObjectStorage();
	}

	final public function attach(SplObserver $observer, array $args = null)
	{
		if (!empty($args)) {
			foreach($args as $prop) {
				if (function_exists(array($observer, $prop))) {
					//TODO: доделать возможность подписываться на конкретное свойство
				}
			}
		}
		$this->_observers->attach($observer);
	}

	final public function detach(SplObserver $observer)
	{
		$this->_observers->detach($observer);
	}

	final public function notify(array $args = null)
	{
		if ($this->_is_change) {
			foreach ($this->_observers as $observer) {
				$observer->update($this);
			}

			$this->_setDefaultChangeState();
		}
	}

	final public function setChangeObservers()
	{
		$this->_is_change = true;
	}

	private function _setDefaultChangeState()
	{
		$this->_is_change = false;
	}
}

class WeatherData extends ASubject
{
	protected $temp;
	protected $humidity;
	protected $pressure;

	public function measurementsChanged()
	{
		$this->notify();
	}

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
		$this->measurementsChanged();
	}

	public function setHumidity($humidity)
	{
		$this->humidity = $humidity;
		$this->measurementsChanged();
	}

	public function setPressure($pressure)
	{
		$this->pressure = $pressure;
		$this->measurementsChanged();
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
	public function __construct(WeatherData $subject)
	{
		$subject->attach($this);
	}

	public function update(SplSubject $subject)
	{
		if ($subject instanceof ISubject) {
			$temp = $subject->getTemperature();
			$pressure = $subject->getPressure();
			$humidity = $subject->getHumidity();

			echo "текущие метки: temp = $temp, humidity = $humidity, pressure = $pressure" . PHP_EOL;
		}

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
$weather_data->attach(new StatisticsDisplay);
$weather_data->attach(new ForecastDisplay);
$cond_ob = new CurrentConditionsDisplay($weather_data);
$weather_data->measurementsChanged();
echo '-----------------' . PHP_EOL;
$weather_data->setTemperature(20);