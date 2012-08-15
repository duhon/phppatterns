<?php
class WeatherData implements SplSubject
{
	protected $temp;
	protected $humidity;
	protected $pressure;

	private $_observers;

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

	public function measurementsChanged()
	{
		$this->notify();
	}

	public function __construct($temp, $humidity, $pressure)
	{
		$this->_observers = new SplObjectStorage();
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
$weather_data->attach(new StatisticsDisplay);
$weather_data->attach(new ForecastDisplay);
$cond_ob = new CurrentConditionsDisplay($weather_data);
$weather_data->measurementsChanged();
echo '-----------------' . PHP_EOL;
$weather_data->setTemperature(20);