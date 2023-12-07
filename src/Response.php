<?php

namespace App;

class Response extends AbstractResponse
{
	const HEADER_TITLE = [
		'200' => 'HTTP/1.0 200 OK',
		'404' => 'HTTP/1.0 404 Not Found'
	];	
	
	protected $view;
    protected $params;
	
	public function __construct (string $view, $params = null)
	{
		$this->view = $view;
        $this->params = $params;
	}
	
	public function getView(): string
	{
		return $this->view;
	}
    
    public function getParams(): ?array
    {
        return $this->params;
    }
}
