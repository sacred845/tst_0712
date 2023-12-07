<?php

namespace App;

class JsonResponse extends AbstractResponse
{
	protected $data;
	
	public function __construct (array $data)
	{
		$this->data = $data;
        $this->setHeader('Content-Type: application/json');
	}
    
    public function getData(): ?array
    {
        return $this->data;
    }
}
