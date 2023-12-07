<?php

namespace App;

abstract class AbstractResponse
{
	const HEADER_TITLE = [
		'200' => 'HTTP/1.0 200 OK',
		'404' => 'HTTP/1.0 404 Not Found'
	];	
	
	protected $headers = [];

    public function setCode($code): self
    {
        $this->headers = [self::HEADER_TITLE[$code]];
        
        return $this;
    }

	public function setHeader($title): self
	{
		$this->headers[] = $title;
		return $this;
	}

	public function getHeaders(): ?array
	{
		return $this->headers;
	}
}
