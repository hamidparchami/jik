<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\ChargedUsersByProductItem;
use Morilog\Jalali\jDateTime;
use App\Lib\ChortkehBaseService;
use DB;
use Illuminate\Http\Request;
use App\LeaderboardPeriodically;
use Response;

class PointsController extends Controller
{
    public function getUserPoint(Request $request)
    {
        if(!isset($request->accountId)){
            return Response::json(array(
                'status'   =>  false
            ), 406);
        }
        $Chortkeh = new ChortkehBaseService;
        $topicName = $Chortkeh->getGeneralTopicName();
        $topic_list[] = $topicName;
        $point_result[$topicName] = array( "name" => "روزانه", "rank" => 0, "point" => 0);

        date_default_timezone_set('Asia/Tehran');
        $date = date('Y-m-d');
        $topics = LeaderboardPeriodically::where([
            ['start_date', '<=', $date],
            ['end_date'  , '>=', $date]
        ])->get();

        foreach ($topics as $topic){
            $topicName    = $Chortkeh->getPeriodTopicName(jDateTime::strftime('Y-m-d', strtotime($topic->start_date)),jDateTime::strftime('Y-m-d', strtotime( $topic->end_date)));
            $topic_list[] = $topicName;
            $point_result[$topicName] = array( "name" => $topic->topic_name, "rank" => 0, "point" => 0);
        }

        $chortkeh_result = $Chortkeh->getPointInMultipleTopics($topic_list, array($request->accountId));
        $chortkeh_result = json_decode($chortkeh_result['response']);

        foreach ($chortkeh_result as $title){
            $point_result[$title->Topic->ExternalKey]['point'] = $title->Point;
            $point_result[$title->Topic->ExternalKey]['rank'] = $title->Rank;
        }

        return array_values($point_result);
    }

    /*******  Service  *******/
    // Run Minute
    public function setChargedUsersScore()
    {
        $res = ChargedUsersByProductItem::where('status' , 0)->limit(100)->get();
        foreach ($res as $item) {
            $trueDate = jDateTime::strftime('Y-m-d', strtotime($item->Date));
            $Chortkeh = new ChortkehBaseService;
            $generalTopice = $Chortkeh->getGeneralTopicName($trueDate);
            $res = $Chortkeh->addPoint($generalTopice, $item->TransactionCode, $item->AccountID, $item->Point, $item->ProductItemCode);
            if ($res['success']) {
                ChargedUsersByProductItem::where('TransactionCode', $item->TransactionCode)->update(['status' => 1]);
            }
        }
        return "Batch Point Has Been Set";
    }

    // Run Hourly
    public function getNewAutoChargeFromPayment()
    {
        $query = 'select 1 as a; EXEC SFC.SPU_LocalChargeInsert';
        $res = DB::connection('sqlsrv')->select($query);
        return "New Charge Proceed";
    }



}