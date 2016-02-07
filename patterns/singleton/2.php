<?php
	/**
	 * Абстрактный паттерн «Одиночка» («Реестр одиночек»)
	 * @project FLC
	 * @author KIVagant
	 * @version $Id: class.Singleton.php 1443 2012-04-18 13:52:31Z KIVagant $
	 */
	abstract class Singleton
	{
		/**
		 * object instance
		 * @var Singleton
		 */
		protected static $instance = array();

		/**
		 * Защищаем от создания через new Singleton
		 */
		protected function __construct()
		{
			//
		}

		/**
		 * Защищаем от создания через клонирование
		 */
		protected function __clone()
		{
			//
		}

		/**
		 * Защищаем от создания через unserialize
		 */
		protected function __wakeup()
		{
			//
		}

		/**
		 * Создавался ли инстанс
		 */
		public static function isNewInstance()
		{
			$child_class = get_called_class();
			return !isset(self::$instance[$child_class]);
		}

		/**
		 * Возвращает единственный экземпляр класса.
		 * @return Singleton
		 */
		public static function getInstance()
		{
			$child_class = get_called_class();
			if (self::isNewInstance()) {
				self::$instance[$child_class] = new $child_class;
			}

			return self::$instance[$child_class];
		}
	}