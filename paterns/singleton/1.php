<?php
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
