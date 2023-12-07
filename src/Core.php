<?php

namespace App;

class Core
{
    private static $instance;
    private $data;

    private function __construct() {}
    
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function setEntityManager($value)
    {
        $this->data['em'] = $value;
        return $this;
    }
    
    public function getEntityManager()
    {
        return $this->data['em'];
    }
    
    public function setSession($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    
    public function getSession($name)
    {
        return $_SESSION[$name] ?? null;
    }
	
	public function clearSession($name)
	{
		unset($_SESSION[$name]);
	}
    
    public function getTimeList(string $start, string $end, string $delay): array
    {
        $res = [];
        
        $l_time = \DateTime::createFromFormat('H:i', $start);
        $end = \DateTime::createFromFormat('H:i', $end);
        $delay_int = \DateInterval::createFromDateString($delay);
        $l_last = $end->sub($delay_int);

        while ($l_time->getTimestamp() <= $l_last->getTimestamp()) {
            $res[] = clone($l_time);
            $l_time = $l_time->add($delay_int);
        }
        
        return $res;
    }
}
