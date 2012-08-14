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

	public function measurementsChanged()
	{
		$temp = $this->getTemperature();
		$humidity = $this->getHumidity();
		$pressure = $this->getPressure();

		$current_conditions_ob = new CurrentConditionsDisplay();
		$statistics_ob = new StatisticsDisplay();
		$forecast_ob = new ForecastDisplay();

		$current_conditions_ob->update($temp, $humidity, $pressure);
		$statistics_ob->update($temp, $humidity, $pressure);
		$forecast_ob->update($temp, $pressure);
	}
}

class CurrentConditionsDisplay
{
	public function update($temp, $humidity, $pressure)
	{
		echo "текущие метки: temp = $temp, humidity = $humidity, pressure = $pressure" . PHP_EOL;
	}
}

class StatisticsDisplay
{
	public function update($temp, $humidity, $pressure)
	{
		echo "отображение статистики: temp = $temp, humidity = $humidity, pressure = $pressure" . PHP_EOL;
	}
}

class ForecastDisplay
{
	public function update($temp, $pressure)
	{
		echo "отображение прогноза температурного давления: temp = $temp, pressure = $pressure" . PHP_EOL;
	}
}

$weather_data = new WeatherData(10, 10, 10);
$weather_data->measurementsChanged();
echo '-----------------' . PHP_EOL;
$weather_data->setTemperature(20);