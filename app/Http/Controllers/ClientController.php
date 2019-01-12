<?php

namespace App\Http\Controllers;

use Elastica\Client;
use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;
use Faker\Factory as Faker;
use Elastica\Client as ElasticClient;

class ClientController extends Controller
{
    //ElasticSearch-php Client
    protected $elasticsearch;

    //Elastica Client
    protected $elastica;

    //Elastica Index
    protected $elasticaIndex;

    //Set up our Clients
    public function __construct()
    {
        $this->elasticsearch = ClientBuilder::create()->build();

        //Create an Elastica Client
        $this->elasticConfig = [
            'host' => 'localhost',
            'port' => 9200,
            'index' => 'megacorp'
        ];

        $this->elastica = new ElasticClient($this->elasticConfig);

        $this->elasticaIndex = $this->elastica->getIndex('megacorp');
    }

    //Test ElasticSearch-php Client
    public function elasticsearchTest()
    {
        dump($this->elasticsearch);

        echo "\n\nRetrive a document:\n";
        $params = [
            'index' => 'megacorp',
            'type' => 'employee',
            'id' => '1'
        ];

        $response = $this->elasticsearch->get($params);
        dump($response);
    }

    // Test elastica client
    public function elasticaTest()
    {
        // View our Elastica Client Object
        dump($this->elastica);

        //View our Elastica Index
        dump($this->elasticaIndex);

        //Get the Types and Mapping
        echo "\n\nGet types and Mapping\n";
        $employeeType = $this->elasticaIndex->getType('employee');
        dump($employeeType->getMapping());

        //Retrive a document that we have indexed
        echo "\n\nGet a document\n";
        $response = $employeeType->getDocument('1');
        dump($response);
    }

    public function elasticsearchData()
    {
        $params = [
            'index' => 'megacorp',
            'type' => 'employee',

        ];
    }
}
