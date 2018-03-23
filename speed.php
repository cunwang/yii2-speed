<?php
namespace Yii2\lib;

/**
 *  用于程序消费记录
 * @author <github.com/cunwang>
 * @link https://github.com/cunwang/yii2-speed
 * @date 2018/03
 * @since 1.1 简化代码
 */
class speed
{
	/**
	 * @property json 
		{
			"title":"Speed-xxx",
			"flag":"",
			"alias":[],
			"option":[],
			"time":[],
			"error":[],
			"optionSpeed":"",
			"allSpeed":"",
			"average":[]
		}
	*/
	private $speedData;

	/**
	 * initialize
	 * @param $name string default NULL
	 */
	public function __construct($name = NULL)
	{
		$this->speedData = [
			'title'		=> (empty($name) ? 'Speed-' . date('Ymdhis') : $name),
			'flag'		=> '',
		];
		$this->setLoop('Start');
	}

	protected function getMt()
	{
		list($usec,  $sec)	= explode(" ",  microtime());
		return ((float) $usec + (float) $sec);
	}

	protected function getDiff($a, $b)
	{
		return sprintf("%.5f", (float) $b - (float) $a);
	}

	protected function add($name)
	{
		$this->speedData['alias'][]		= (empty($name) ? uniqid('Alias-') : $name);
		$this->speedData['option'][]	= uniqid('Option-');
		$this->speedData['time'][]		= $this->getMt();
	}

	protected function getAllSpeed()
	{
		$data	= [];
		$tmp	= $this->speedData['time'];
		if (! empty($tmp)) {
			$data['all']	= $this->getDiff($tmp[0], end($tmp));
			$data['optionSpeed']	= [];
			for ($i = 1; $i < count($tmp); $i++) {
				$curr	= $tmp[$i];
				$pre	= $tmp[$i -1];
				$data['optionSpeed'][] = $this->getDiff($pre, $curr);
			}
		}
		unset($tmp, $curr, $pre);
		return $data;
	}

	public function __get($name)
	{
		if (empty($name)) return;
		if (isset($this->speedData[$name])) {
			return $this->speedData[$name];
		} else {
			throw new \Exception('Call unknow property: '. $name);
		}
	}

	public function __set($name, $value)
	{
		if (empty($name)) return;
		if (isset($this->speedData[$name])) {
			$this->speedData[$name]	= $value;
		}
	}

	public function __call($name, $arguments)
	{
		$f = 'get' . ucfirst(strtolower($name));
		if (method_exists($this, $f)) {
			return call_user_func_array ([$this, $f], is_array($arguments) ? $arguments : [$arguments]);
		} else {
			throw new \Exception('Calling unknown method: ' . get_class($this) . "::$f()", 404);
		}
	}

	public function s($name, $args  = [])
	{
		$f  = NULL;
		$f2 = 'set' . ucfirst(strtolower($name));
		do {
			if (method_exists($this, $f2)) {
				$f  = $f2;
				call_user_func_array([$this, $f], [$args]);
			} else {
				throw new \Exception('Calling unknown method: ' . get_class($this) . "::$f2()", 404);
			}
		} while ($f = NULL);
		unset($f, $f2);
	}

	protected function setError($msg)
	{
		if (! empty($msg) && isset($this->speedData['error'])) {
			$this->speedData['error'][]	= $msg;
		}
	}

	public function setLoop($name = NULL)
	{
		$this->add($name);
	}

	public function end()
	{
		$this->setLoop('End');
		$allSpeed	= $this->getAllSpeed();
		$average	= (float) ($allSpeed['all'] / count($this->speedData['option']));
		$options	= $allSpeed['optionSpeed'];

		$this->speedData['optionSpeed']	= (count($options) > 1) ? $options : (string) $options[0];
		$this->speedData['allSpeed']	= (string) $allSpeed['all'];
		$this->speedData['average']		= (string) $average;
		unset($allSpeed, $average, $options);
	}

	protected function getData($t = 'str')
	{
		return ($t	== 'arr') ? $this->speedData : json_encode($this->speedData);
	}
}
