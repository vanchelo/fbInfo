<?php

if ( ! defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}

class FbCache
{
	/**
	 * @var FbCache
	 */
	protected static $instance;

	protected function __construct() {}

	public static function instance()
	{
		if ( ! isset(static::$instance))
		{
			static::$instance = new static;
		}

		return static::$instance;
	}

	/**
	 * Сохранить данные в кэш
	 *
	 * @param mixed $data данные
	 * @param string $namespace пространство имён
	 * @param string $id идентификатор
	 */
	public function put($data, $namespace, $id)
	{
		$storage = [
			'data' => $data,
			'timestamp' => time()
		];
		$path = $this->getNamespacePath($namespace) . $this->getIdDir($id);
		if ( ! file_exists($path))
		{
			mkdir($path, 0775, true);
		}

		file_put_contents($path . md5($id), serialize($storage));
	}

	/**
	 * Сохранить данные из кэша
	 *
	 * @param string $namespace пространство имён
	 * @param string $id идентификатор
	 * @param int $lifetime время жизни
	 *
	 * //TODO: проверять время жизни не загружая файл
	 *
	 * @return null|mixed
	 */
	public function get($namespace, $id, $lifetime = 0)
	{
		$filename = $this->getNamespacePath($namespace) . $this->getIdPath($id);
		if ( ! file_exists($filename))
		{
			return null;
		}

		$data = unserialize(file_get_contents($filename));
		if (empty($data['timestamp']))
		{
			return null;
		}

		//истекло ли время жизни?
		if ($lifetime != 0 && ($data['timestamp'] + $lifetime) < time())
		{
			$this->remove($namespace, $id);

			return null;
		}

		return $data['data'];
	}

	/**
	 * Удаляем данные из кэша
	 *
	 * @param string $namespace пространство имён
	 * @param string $id идентификатор
	 */
	function remove($namespace, $id)
	{
		$filename = $this->getNamespacePath($namespace) . $this->getIdPath($id);
		if (file_exists($filename))
		{
			unlink($filename);
		}
	}

	/**
	 * @param string $id идентификатор
	 *
	 * @return string
	 */
	private function getIdPath($id)
	{
		return $this->getIdDir($id) . md5($id);
	}

	/**
	 * @param string $id
	 *
	 * @return string
	 */
	private function getIdDir($id)
	{
		$hash = md5($id);

		return $hash[0] . DS . $hash[1] . DS . $hash[2] . DS . $hash[3] . DS . $hash[4] . DS . $hash[5] . DS;
	}

	/**
	 * @param string $namespace пространство имён
	 *
	 * @return string
	 */
	private function getNamespacePath($namespace)
	{
		return MODX_BASE_PATH . 'assets/cache' . DS . 'namespaces' . DS . $namespace . DS;
	}
}
