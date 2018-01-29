<?php
namespace App\Lib;

use Morilog\Jalali\jDateTime;

class ChortkehBaseService
{

    private static $CHORTKEH_BASE_URL;
    private static $CHORTKEH_API;

    private $prefix = "CP-Doband-Lead-";
    private $topic_preodic = "period-";

    private $topic_general = "general-";

    const CHORTKEH_API_METHODS = [
        'set_topic'                          => 'post',
        'get_point_in_multiple_topics'       => 'post',
        'get_rank_in_multiple_topics'        => 'post',
        'set_parent_topic'                   => 'post',
        'add_children_to_parent_topic'       => 'post',
        'get_all_points_in_topic'            => 'get',
        'set_delta_point'                    => 'post',
        'set_bulk_delta_point'               => 'post',
        'get_multiple_points_in_topic'       => 'post',
        'get_multiple_points_multiple_topic' => 'post',
    ];

    const DEFAULT_FROM_DATE = "2000-01-01 00:00:00";
    const DEFAULT_TO_DATE = "2040-01-01 00:00:00";

    public function __construct() {
        self::$CHORTKEH_BASE_URL = env('CHORTKEH_BASE_URL');

        self::$CHORTKEH_API = [
            'set_topic'                          => self::$CHORTKEH_BASE_URL . 'topics',
            'get_point_in_multiple_topics'       => self::$CHORTKEH_BASE_URL . 'accountpoints',
            'get_rank_in_multiple_topics'        => self::$CHORTKEH_BASE_URL . 'accountranks',
            'set_parent_topic'                   => self::$CHORTKEH_BASE_URL . 'topics',
            'add_children_to_parent_topic'       => self::$CHORTKEH_BASE_URL . 'topics/addChild',
            'get_all_points_in_topic'            => self::$CHORTKEH_BASE_URL . 'points',
            'set_delta_point'                    => self::$CHORTKEH_BASE_URL . 'points',
            'set_bulk_delta_point'               => self::$CHORTKEH_BASE_URL . 'pointsBulk',
            'get_multiple_points_in_topic'       => self::$CHORTKEH_BASE_URL . 'topicpoints',
            'get_multiple_points_multiple_topic' => self::$CHORTKEH_BASE_URL . 'acccounts/topics/point',
        ];
    }

    public function getGeneralTopicName($date = null) {
        if (is_null($date)) {
            $date = jDateTime::strftime('Y-m-d', strtotime('now'), "Asia/Tehran");
        }

        $name = $this->prefix . $this->topic_general . strval($date);
        return $name;
    }

    public function getPeriodTopicName($start_time, $end_time) {
        $name = $this->prefix . $this->topic_preodic . strval($start_time) . '-To-' . strval($end_time);
        return $name;
    }

    public function addTopic($topicName, $fromDate = self::DEFAULT_FROM_DATE, $toDate = self::DEFAULT_TO_DATE) {

        $body = [
            "ExternalKey"  => $topicName,
            "TopicName"    => $topicName,
            "FromDateTime" => $fromDate,
            "ToDateTime"   => $toDate
        ];

        return $this->setAndSendRequest('set_topic', $body);

    }

    public function addPoint($topicExternalKey, $externalKey, $accountId, int $delta, $eventId = "defaultEvent") {

        $body = [
            "TopicExternalKey" => $topicExternalKey,
            "ExternalKey"      => $externalKey,
            "account"          => $accountId,
            "delta"            => $delta,
            "eventID"          => $eventId
        ];

        return $this->setAndSendRequest("set_delta_point", $body);

    }

    public function addBulkPoints($topicsExternalKeys, array $externalKeys, array $accountIds, array $deltas, array $eventIds = [], array $descriptions = []) {
        $body = [];
        for ($i = 0; $i < sizeof($accountIds); $i += 1) {
            $body[] = [
                "topicExternalKey" => $topicsExternalKeys,
                "eventId"          => $eventIds[$i],
                "account"          => $accountIds[$i],
                "delta"            => $deltas[$i],
                "externalKey"      => $externalKeys[$i],
                "description"      => $descriptions[$i] ?? NULL
            ];
        }

        return $this->setAndSendRequest('set_bulk_delta_point', $body);
    }

    public function getPointInMultipleTopics(array $topics, array $accountId) {

        $topicsKeys = [];
        foreach ($topics as $child) {
            $topicsKeys[] = [
                "ExternalKey" => $child
            ];
        }

        $body = [
            "accounts" => $accountId,
            "topics"  => $topicsKeys
        ];

        return $this->setAndSendRequest("get_multiple_points_multiple_topic", $body);

    }

    public function addChildToParentTopic($parentTopic, array $childrenTopics, array $ratios = []) {
        $formula = [];
        for ($i = 0; $i < sizeof($childrenTopics); $i += 1) {
            $formula[] = [
                "externalKey" => $childrenTopics[$i],
                "ratio"       => $ratios[$i] ?? 1
            ];
        }

        $body = [
            "ParentTopicExternalKey" => $parentTopic,
            "formula"                => $formula
        ];

        return $this->setAndSendRequest('add_children_to_parent_topic', $body);
    }

    private function setAndSendRequest($api_name, array $params) {
        $client = new CurlRequest();
        $client->setCurlHeaders('Content-Type: application/json');

        $client->sendCurlRequest(self::$CHORTKEH_API[$api_name], json_encode($params), self::CHORTKEH_API_METHODS[$api_name]);

        if (($client->status == 200) or ($client->status == 201)) {
            $res = array(
                "success"  => true,
                "response" => $client->response
            );
        } else {
            $res = array(
                "success"  => false,
                "response" => json_decode($client->response) ?? null
            );

            if (isset($res["response"]->Errors[0]->ErrorKey)){
                $response = $res["response"]->Errors[0]->ErrorKey == "DuplicateValue" ? true : false;
                if ($response){
                    $res["success"] = true;
                }
            }
        }

        return $res;
    }


}