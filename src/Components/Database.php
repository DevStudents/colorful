<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Components;
use sintloer\COLORFUL\Core;

/**
 * Database component.
 * 
 */

class Database
{

	/**
	 * Database instances.
	 * @var array
	 * 
	 */
	
	private static $_instances = [];

	/**
	 * PDO object.
	 * @var null|object
	 * 
	 */

	private $_db = null;

	/**
	 * Query string.
	 * @var string
	 * 
	 */

	private $_query = '';

	/**
	 * Database params to bind.
	 * @var array
	 * 
	 */

	private $_params = [];

	/**
	 * Table prefix.
	 * @var array
	 * 
	 */

	private $_prefix = '';

	/**
	 * Create new instance of Database object.
	 * @return object
	 * 
	 */

	public static function get($name)
	{
		if(!isset(self::$_instances[$name]))
			self::$_instances[$name] = new self($name);

		return self::$_instances[$name];
	}

	/**
	 * Private construct.
	 * @param string $name
	 * @return object
	 * 
	 */

	private function __construct($name)
	{
		if($config = Core\Config::get('databases.' . $name))
		{
			try
			{
				$this->_db = new \PDO(($config['driver'] ?? '') . ':host=' . ($config['host'] ?? '') . ';dbname=' . ($config['name']) ?? '' . ';charset=utf8', ($config['username'] ?? ''), ($config['password'] ?? ''), [
						\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
					]);

				if(isset($config['prefix']) && !empty($config['prefix']))
					$this->_prefix = $config['prefix'];
			}
			catch(\PDOException $e)
			{
				Core\Error::show('Database "'. $name .'" connection:<br>' . ucfirst($e->getMessage()) . '.');
			}
		}
		else
			Core\Error::show('You need to configure database connection: "'. $name .'".', 1100);

		return $this;
	}

	/**
	 * Run query.
	 * @param string|array $name
	 * @return object
	 * 
	 */

	public function query($str, $data = [])
	{
		if(!$this->_isSelectedDatabase())
			return false;

		$this->_query = $str;
		if(is_array($data) && count($data) > 0)
			$this->_params = $data;

		$result = $this->_run();
		if($result !== false)
			return $result;

		return false;
	}

	/**
	 * Create select query and run it.
	 * @param string $what
	 * @param string $table
	 * @param string $rest
	 * @param array $data
	 * @return object|boolean
	 * 
	 */

	public function select($what, $table, $rest = '', $data = [])
	{
		if(!$this->_isSelectedDatabase())
			return false;

		if(is_array($rest) && count($data) == 0)
			$data = $rest;

		$query = 'SELECT ' . $what . ' FROM ' . $this->_getTablePrefix() . $table . ' ' . $rest;
		$result = $this->query($query, $data);

		if($result !== false)
		{
			$obj = new \stdClass();
			$obj->query = $result->queryString;
			$obj->params = $data;
			$obj->data = $result->fetchAll(\PDO::FETCH_OBJ);
			$obj->first = $obj->data[0] ?? new \stdClass();
			$obj->num = count($obj->data);

			return $obj;
		}

		return false;
	}

	/**
	 * Select one record from table by id.
	 * @param string $what
	 * @param string $table
	 * @param string $rest
	 * @param array $data
	 * @return object|boolean
	 * 
	 */

	public function read($table, $id)
	{
		return $this->select('*', $table, 'WHERE `id` = :id LIMIT 1', [
				':id' => $id
			]);
	}

	/**
	 * Create select query and run it.
	 * @param string $table
	 * @param array $data
	 * @return int|boolean
	 * 
	 */

	public function insert($table, $data = [])
	{
		if(!$this->_isSelectedDatabase())
			return false;

		if(!is_array($data))
			return false;

		$fields = '';
		$values = '';

		foreach($data as $field => $value)
		{
			$fields .= '`' . $field . '`, ';
			$isFunc = $this->_isFunc($value);

			if($isFunc !== false)
				$values .= $isFunc . ', ';
			else
			{
				$values .= '?, ';
				$this->_params[] = $value;
			}
		}

		$fields = rtrim($fields, ', ');
		$values = rtrim($values, ', ');

		$this->_query = 'INSERT INTO ' . $this->_getTablePrefix() . $table . ' (' . $fields . ') VALUES (' . $values . ')';

		$result = $this->_run();
		if($result !== false)
			return $this->_db->lastInsertId();

		return false;
	}

	/**
	 * Create update query and run it.
	 * @param string $table
	 * @param array $set
	 * @param string $rest
	 * @param array $data
	 * @return boolean
	 * 
	 */

	public function update($table, $set = [], $rest = '', $data = [])
	{
		if(!$this->_isSelectedDatabase())
			return false;

		if(!is_array($set))
			return false;

		$fields = '';
		$values = [];

		foreach($set as $key => $value)
		{
			$paramValue = ':' . strtolower(trim($key));
			$isFunc = $this->_isFunc($value);

			if($isFunc !== false)
				$paramValue = $isFunc;
			else
				$values[$paramValue] = $value;

			$fields .= $key . ' = ' . $paramValue . ', ';
		}

		$fields = rtrim($fields, ', ');

		$query = 'UPDATE ' . $this->_getTablePrefix() . $table . ' SET ' . $fields . ' ' . $rest;

		$result = $this->query($query, array_merge($values, $data));
		if($result !== false)
			return true;

		return false;
	}

	/**
	 * Create delete query and run it.
	 * @param string $table
	 * @param string $rest
	 * @param array $data
	 * @return boolean
	 * 
	 */

	public function delete($table, $rest = '', $data = [])
	{
		if(!$this->_isSelectedDatabase())
			return false;

		$query = 'DELETE FROM ' . $this->_getTablePrefix() . $table . ' ' . $rest;

		$result = $this->query($query, $data);
		if($result !== false)
			return true;

		return false;
	}

	/**
	 * Create truncate query and run it.
	 * @param string $table
	 * @return boolean
	 * 
	 */

	public function truncate($table)
	{
		$query = 'TRUNCATE TABLE `' . $this->_getTablePrefix() . $table . '`';
		return $this->query($query);
	}

	/**
	 * Close Database connection.
	 * @return void
	 * 
	 */

	public function close()
	{
		$this->_db = null;
	}

	/**
	 * Close all Database connections.
	 * @return void
	 * 
	 */

	public static function closeAll()
	{
		foreach(self::$_instances as $instance)
			$instance->close();
	}


	/**
	 * Insert SQL functions to query.
	 * @param string $str
	 * @return string
	 * 
	 */

	public function func($str = 'NOW()')
	{
		return '::FUNC::' . $str;
	}

	/**
	 * Method for return query.
	 * @return string
	 * 
	 */

	public function showQuery()
	{
		return $this->_query;
	}

	/**
	 * Run method.
	 * @return object|boolean
	 * 
	 */

	private function _run($query = '')
	{
		if(!empty($query))
			$this->_query = $query;

		try
		{
			$q = $this->_db->prepare($this->_query);
			if(!$q->execute($this->_params))
				return false;

			$this->_query = '';
			$this->_params = [];

			return $q;
		}
		catch(\PDOException $e)
		{
			Core\Error::show('Database execution:<br>' . $e->getMessage());
		}

		return false;
	}

	/**
	 * Check $str is SQL function.
	 * @param string $str
	 * @return string|boolean
	 * 
	 */

	private function _isFunc($str)
	{
		if(strpos($str, '::FUNC::') !== false)
			return str_replace('::FUNC::' , '', $str);

		return false;
	}

	/**
	 * Check $this->_db is PDO object.
	 * @return boolean
	 * 
	 */

	private function _isSelectedDatabase()
	{
		if(!($this->_db instanceof \PDO))
		{
			Core\Error::show('You don\'t selected database. Call use() method please.', 1101);
			return false;
		}

		return true;
	}

	/**
	 * Get table prefix.
	 * @return string
	 * 
	 */

	private function _getTablePrefix()
	{
		$prefix = '';
		if(!empty($this->_prefix))
			$prefix = $this->_prefix;

		return $prefix;
	}
}