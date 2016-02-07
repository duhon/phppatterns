<?php
/**
* ставим приватными конструктор, для защиты от прямого вызова
* Sergei Matros: приватный __clone() для защиты от клонирования
* Sergei Matros: защита заключается в том, что пых выбрасывает Fatal Error
* Sergei Matros: для полноты картины нужно запретить сериализацию объекта
* Sergei Matros: т.е. поставить приватным __wakeup() -- это если верить википедии
* Sergei Matros: 5.2.17 отлично отработав, выбросив фатал еррор
* Sergei Matros: а вот на 5.3.14 и 5.4.4 выбрасывается всего лишь Warning и все, создается еще один объект
* Duhon: ну я думаю это связано с введением обьекта serealize
*/

/**
* Singleton
*/
class Singleton
{
	private static $instance;

	private function __construct(){}
	private function __clone(){}
	private function __sleep(){}
	private function __wakeup(){}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new Singleton;
		}

		return self::$instance;
	}
}

/*$a = new Singleton();
print '<pre>'; var_dump($a);*/

// $a = Singleton::getInstance();
// print '<pre>'; var_dump($a);

/*for ($i=0; $i < 10; $i++) {
	${a.$i} = Singleton::getInstance();
	print '<pre>'; var_dump(${a.$i});
}*/

$o = Singleton::getInstance();

$so = serialize($o);

$uso = unserialize($so);
print '<pre>'; var_dump($uso);


// $co = clone $o;
// print '<pre>'; var_dump($o);
// print '<pre>'; var_dump($co);
