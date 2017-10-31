<?php
/**
 * Created by PhpStorm.
 * User: Tolga-Pc
 * Date: 30.10.2017
 * Time: 22:13
 */

namespace App\Http\Controllers;

use App\Common\Message;
use App\Common\Response;
use App\Common\SqsConnection;

class MainController extends Controller
{
    /**
     * Method gets all records from SQS.
     *
     * @param SqsConnection $sqsConnection
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllMessages(SqsConnection $sqsConnection)
    {
        $messages = [];
        $receivedMessage = 0;

        $messageCount = $this->getApproximateNumberOfMessages($sqsConnection);

        while($messageCount > $receivedMessage){
            /*
             * I know using 'MaxNumberOfMessages' arg is crucial here but when I use this, I get ERR_CONNECTION_RESET error and my Apache server crashes.
             * So I decided not to use it on my first release.
             *
             * TODO: Implement MaxNumberOfMessages arg
             */

            $result = $sqsConnection->client->receiveMessage(array(
                'QueueUrl' => $sqsConnection->queueUrl
                //'MaxNumberOfMessages' => 10
            ));

            if($result->getPath('Messages/*') == null){
                var_dump('break');
                break;
            } else {
                $receivedMessage += count($result['Messages']);
                foreach ($result->getPath('Messages/*/Body') as $messageBody) {
                    $messages[] = json_decode($messageBody);
                }
            }
        }

        return Response::success($messages);
    }

    /**
     * Method creates and sends messages to SQS.
     *
     * @param SqsConnection $sqsConnection
     * @param int $count
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessages(SqsConnection $sqsConnection, $count = 1000)
    {
        $successful = 0;
        $failed = 0;

        //Creates messages from factory
        $messages = factory(Message::class, $count)->make()->toArray();

        //SQS can support up to ten messages per second so I split the $messages array 10 by 10
        $chunkMessages = array_chunk($messages, 10);

        foreach ($chunkMessages as $messages) {
            $result = $sqsConnection->client->sendMessageBatch(array(
                'QueueUrl' => $sqsConnection->queueUrl,
                'Entries' => $messages
            ));

            $successful += count($result['Successful']);
            $failed += count($result['Failed']);
        }

        return Response::success(['Successful' => $successful, 'Failed' => $failed]);
    }

    /**
     * Gets message status.
     *
     * @param SqsConnection $sqsConnection
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatus(SqsConnection $sqsConnection){

        $messageCount = $this->getApproximateNumberOfMessages($sqsConnection);

        return Response::success(['MessageCount' => $messageCount]);
    }

    /**
     * Method gets approximate number of messages on SQS.
     *
     * @param $sqsConnection
     * @return int
     */
    private function getApproximateNumberOfMessages($sqsConnection)
    {
        $result = $sqsConnection->client->getQueueAttributes(array(
            'QueueUrl' => $sqsConnection->queueUrl,
            'AttributeNames' => array('ApproximateNumberOfMessages')
        ));

        return intval($result->getPath('Attributes/ApproximateNumberOfMessages'));
    }
}
