<?php

namespace App\App\Presenter;

use App\Presenter\ApiBasePresenter;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Nette\Application\Responses\JsonResponse;
use Tracy\ILogger;

class ApiJsonPresenter extends ApiBasePresenter
{
    
    public ILogger $log;
    public function __construct()
    {
        parent::__construct();
    }
    public function actionApiList()
    {
        $client = new Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false ) ));
        try {
            $response = $client->request( 'get','https://jsonplaceholder.typicode.com/todos/1');
        } catch (GuzzleException $e)
        {
            $this->log->log('Chyba při stahování dat '. $e->getMessage(),'error');
        }
        return $this->sendResponse(new JsonResponse($response->getBody()));
    }
    
}