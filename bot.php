<?php
class tgbot{
  private $token;
  private $apikey;
  //function for api request
private function open_url($url, $method, $data = null) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);

  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  return curl_exec($ch);

}
  //Constructor
  public function __construct($token,$api)
  {
    $this->token=$token;
    $this->apikey=$api;
  }


  //function for control api
private function control_api($method,$data=null){
  $token=$this->token;
  return $this->open_url("https://api.telegram.org/bot$token$method","POST",$data);
}

  
//Function For send message
  public function send_message($to,$text,$parse_mode){
   $data=array();
    $data['chat_id']=$to;
    $data['text']=$text;
  $data['parse_mode']=$parse_mode;
  return $this->control_api("/sendMessage",$data);
  }


  //Function For get Answer
  public function get_answer($q){
    // Set up the request parameters
$url = 'https://api.openai.com/v1/engines/text-davinci-003/completions';
$data = array(
  'prompt' => $q,
  'max_tokens' => 1024,
  'temperature' => 0.5,
  'n' => 1,
  'stop' => null,
);

// Set up the CURL request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  "Authorization: Bearer $this->apikey",
));

// Send the request and get the response
$response = curl_exec($ch);
curl_close($ch);
    $res = json_decode($response, true);
   return $res['choices'][0]['text'];
    //return $q;//$response;
  }
}