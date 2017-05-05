<?php

$access_token = 'graf7SqP950czzLSFI3HUJ3XcE1HUvZHtA7tKs//LQMFE4IJOdTflRBqpsWP//sD8y0DikCkidZxW4ATZ7CEzoJ6DIaMVs+U3H/D+iQvGp+HS2QwHi54ZCAb5rp486K66U8L2+B9WqtmqgCB7rskWgdB04t89/1O/w1cDnyilFU=';
//$proxy = <YOUR_PROXY_FROM_FIXIE>;
//$proxyauth = <YOUR_PROXYAUTH_FROM_FIXIE>;

// Get POST body content
$content = file_get_contents('php://input');

// Parse JSON
$events = json_decode($content, true);

// Validate parsed JSON data
if (!is_null($events['events'])) {
    // Loop through each event
    foreach ($events['events'] as $event) {
        // Reply only when message sent is in 'text' format
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            $bufferMessages = [3];
            // Get text sent
            $text = $event['message']['text'];
            // Get replyToken
            $replyToken = $event['replyToken'];

            $messages = [
              'type' => 'text',
              'text' => 'สวัสดี ยินดีรับใช้ กด a ตรวจสอบการพยากรณ์อากาศ'
            ];
            
            $messages01 = [
                'type' => 'text',
                'text' => 'ครับผม ได้ครับ'
             ];

            // Build message to reply back
            
            if ($event['message']['text'] == "a"){
                $bufferMessages[0] = $messages01;
            }
            if($event['message'['text'] == ""){
                $bufferMessages[1] = $messages;
            }
            // Enter your code here

            // Make a POST Request to Messaging API to reply to sender
            $url = 'https://api.line.me/v2/bot/message/reply';
            $data = [
              'replyToken' => $replyToken,
              'messages' => $bufferMessages,
            ];

            $post = json_encode($data);
            $headers = array('Content-Type: application/json', 'Authorization: Bearer '.$access_token);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            //curl_setopt($ch, CURLOPT_PROXY, $proxy);
            //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
            $result = curl_exec($ch);
            curl_close($ch);

            echo $result."\r\n";
        }
    }
}
echo 'OK';
