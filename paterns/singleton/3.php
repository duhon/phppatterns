<?php
/**
* Реализация патерна одиночка для существующего класса превращает его в статический класс.
* За и против
* + Не нужно переписывать существующие вызовы методов к классу, но при этом поведение будет как для статики
* + Так как физически класс не статический то к нему можно применять большинство патернов, которые нельзя было применять к статическим классам
* - Гибкость статического класса выше, так как можно не все делать статическим, а одиночка полностью превращет обьект в статику
*/

/**
* Singleton
*/
class Singleton
{
	private static $instance;

	public static $s_var;
	public $var;
	private static $_s_var;
	private $_var;

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

	public static function getStaticVar()
	{
		return self::$_s_var;
	}

	public function getVar()
	{
		return $this->_var;
	}

	public static function setStaticVar($val)
	{
		self::$_s_var = $val;
	}

	public function setVar($val)
	{
		$this->_var = $val;
	}
}

$singleton_1_ob = Singleton::getInstance();
$singleton_2_ob = Singleton::getInstance();

//@start "Какая разница между публичными, статическими и не статическими свойствами класса одиночки"
echo 'Первый обьект', PHP_EOL;
echo 'Неназначеное значение VAR: ' . $singleton_1_ob->var, PHP_EOL; //@return ""
echo 'Второй обьект', PHP_EOL;
echo 'Неназначеное значение VAR: ' . $singleton_2_ob->var, PHP_EOL; //@return ""
echo 'Ститика класса', PHP_EOL;
echo 'Cтатическое значение VAR: ' . Singleton::$s_var, PHP_EOL; //@return ""
$singleton_1_ob->var = 'var_1';
Singleton::$s_var = 's_var_1';
echo 'Изменили $singleton_1_ob->var = "var_1"; Singleton::$s_var = "s_var_1";', PHP_EOL;
echo 'Первый обьект', PHP_EOL;
echo 'Назначеное значение VAR: ' . $singleton_1_ob->var, PHP_EOL; //@return "var_1"
echo 'Второй обьект', PHP_EOL;
echo 'Неназначеное значение VAR: ' . $singleton_2_ob->var, PHP_EOL; //@return "var_1" @expected "" @comment "Поведение свойства var аналогично статическому"
echo 'Ститика класса', PHP_EOL;
echo 'Cтатическое значение VAR: ' . Singleton::$s_var, PHP_EOL; //@return "s_var_1"
//@end "Одиночка превращает обычный обьект в статический"

//@start "Какая разница между приватными, статическими и не статическими свойствами класса одиночки"
echo 'Первый обьект', PHP_EOL;
echo 'Неназначеное значение VAR: ' . $singleton_1_ob->getVar(), PHP_EOL; //@return ""
echo 'Второй обьект', PHP_EOL;
echo 'Неназначеное значение VAR: ' . $singleton_2_ob->getVar(), PHP_EOL; //@return ""
echo 'Ститика класса', PHP_EOL;
echo 'Cтатическое значение VAR: ' . Singleton::getStaticVar(), PHP_EOL; //@return ""
$singleton_1_ob->setVar('var_1');
Singleton::setStaticVar('s_var_1');
echo 'Изменили $singleton_1_ob->setVar(\'var_1\');Singleton::setStaticVar(\'s_var_1\');', PHP_EOL;
echo 'Первый обьект', PHP_EOL;
echo 'Назначеное значение VAR: ' . $singleton_1_ob->getVar(), PHP_EOL; //@return "var_1"
echo 'Второй обьект', PHP_EOL;
echo 'Неназначеное значение VAR: ' . $singleton_2_ob->getVar(), PHP_EOL; //@return "var_1" @expected "" @comment "Поведение свойства var аналогично статическому"
echo 'Ститика класса', PHP_EOL;
echo 'Cтатическое значение VAR: ' . Singleton::getStaticVar(), PHP_EOL; //@return "s_var_1"
//@end "Одиночка превращает обычный обьект в статический"