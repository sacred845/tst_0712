<?php

namespace App;

use App\Request;
use App\Application;
use App\Response;
use App\AbstractResponse;
use App\JsonResponse;

class Front
{
    private function __construct() {}
    
    public static function run()
    {
        $instance = new self();
        $instance->init();
        $instance->processRrequest();
    }
    
    private function init()
    {
        ;
    }
    
    private function processRrequest()
    {
        $request = new Request();
        $application = new Application($request);
        $application->exec();
        $this->invokeView($application->getResponse());
    }
    
    private function invokeView(AbstractResponse $response)
    {
		foreach ($response->getHeaders() as $title) {
			header($title);
		}
        
        if ($response instanceof Response) {
            $params = $response->getParams();
            ob_start();
            include(LAYOUT_DIR . '/' . $response->getView().'.phtml');
            $content = ob_get_contents();
            ob_end_clean();

            include(LAYOUT_DIR . '/layout.phtml');
        } elseif ($response instanceof JsonResponse) {
            echo json_encode($response->getData());
        }
        
		exit;
    }
}
