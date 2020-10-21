<?php
/* Get Data From POST Http Request */
$datas = file_get_contents('php://input');
/* Decode Json From LINE Data Body */
file_put_contents('log.txt', $datas . PHP_EOL, FILE_APPEND);
$deCode = json_decode($datas, true);
$replyToken = $deCode ['events'] [0] ['replyToken'];
$user_id = $deCode['events'][0]['source']['userId'];
$messages = [];
$messages ['replyToken'] = $replyToken;
$messages ['messages'][0] = getFormatTextMessage("Copy and paste this token in your accent account");
$messages ['messages'][1] = getFormatTextMessage($user_id);
//$messages ['messages'][2] = getFormatTextMessage(json_encode($datas));

$encodeJson = json_encode($messages);
$LINEDatas ['url'] = "https://api.line.me/v2/bot/message/reply";
$LINEDatas ['token'] = "qstE8wVpxTCHUOKM2CiK/HeH5v61mfYCxAtC18lE1noTFErMq1yvO3R8p0237RLokeVq9lBiizJi8XPnsf2tGelw5vXSrW83U5vbeP+hc6A7jaU7/e4nWqC11sDNIjLFBe9/bOtKyvOkJcuaSTn3NwdB04t89/1O/w1cDnyilFU=";
$results = sentMessage($encodeJson, $LINEDatas);
file_put_contents('log.txt', json_encode($results) . PHP_EOL, FILE_APPEND);

/* Return HTTP Request 200 */
http_response_code(200);
function getFormatTextMessage($text)
{
    $datas = [];
    $datas ['type'] = 'text';
    $datas ['text'] = $text;
    return $datas;
}

function sentMessage($encodeJson, $datas)
{
    $datasReturn = [];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $datas ['url'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $encodeJson,
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer " . $datas ['token'],
            "cache-control: no-cache",
            "content-type: application/json;charset=UTF-8",
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        $datasReturn ['result'] = 'E';
        $datasReturn ['message'] = $err;
    } else {
        if ($response == "{}") {
            $datasReturn ['result'] = 'S';
            $datasReturn ['message'] = 'Success';
        } else {
            $datasReturn ['result'] = 'E';
            $datasReturn ['message'] = $response;
        }
    }
    return $datasReturn;
}
