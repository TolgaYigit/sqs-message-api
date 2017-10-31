<?php
/**
 * Created by PhpStorm.
 * User: Tolga-Pc
 * Date: 30.10.2017
 * Time: 23:02
 */

namespace App\Common;

use Aws\Sqs\SqsClient;

class SqsConnection
{
    public $client;
    public $queueUrl;

    public function __construct(){
        $this->client = SqsClient::factory(array(
            'region'  => env('AWS_REGION')
        ));

        $this->queueUrl = env('SQS_QUEUE_URL');
    }
}