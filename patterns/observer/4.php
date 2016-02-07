<?php
/**
* Использование простой реализации обсервера и без использования встроенный бибилиотек php
*/

interface Subject {
	public function addObserver(Observer $ob);
	public function removeObserver(Observer $ob);
	public function notifyObservers($some_val);
}

interface Observer {
	public function update($some_val);
}

class ConcreteSubject implements Subject {

	protected $observers_arr = array();

	public function addObserver(Observer $ob)
	{
		$this->observers_arr[] = $ob;
	}

	public function removeObserver(Observer $ob)
	{
		if ($this->observers_arr) {
			foreach ($this->observers_arr as $key => $observer) {
				if ($ob instanceof $observer) {
					unset($this->observers_arr[$key]);
					break;
				}
			}
		}
	}

	public function notifyObservers($some_val)
	{
		if ($this->observers_arr) {
			foreach ($this->observers_arr as $key => $observer) {
				$observer->update($some_val);
			}
		}
	}
}

class ConcreteObserver implements Observer {

	public function update($some_val)
	{
		print 'Observer ' . __CLASS__ . 'was notified from Subject with ' . $some_val . "\n";
	}
}

class ConcreteObserver2 implements Observer {

	public function update($some_val)
	{
		print 'Observer ' . __CLASS__ . 'was notified from Subject with ' . $some_val . "\n";
	}
}

class ConcreteObserver3 implements Observer {

	public function update($some_val)
	{
		print 'Observer ' . __CLASS__ . 'was notified from Subject with ' . $some_val . "\n";
	}
}

$subj = new ConcreteSubject();

$subj->addObserver(new ConcreteObserver());
$subj->addObserver(new ConcreteObserver2());
$subj->addObserver(new ConcreteObserver3());
$subj->notifyObservers('new magic val');

$subj->removeObserver(new ConcreteObserver2);
$subj->notifyObservers('new magic val222');
?>