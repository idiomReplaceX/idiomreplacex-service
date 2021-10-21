<?php

$DEBUG=true;
if($DEBUG) {
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
}

require '../vendor/autoload.php';

Flight::route('POST|GET /filter(/@method)', function($method){

  $request = Flight::request();
  if(isset($request->query['text'])){
    $text =  $request->query['text'];
  } else {
    $text = $request->data->text;
  }

  if(!$text){
    Flight::halt(400, 'parameter text missing in POST body or as request parameter');
  }

  switch($method){
    case FilterMethods::TOURETTE:
    case FilterMethods::DADA:
    default:
      $filterMethod = new TestFilterMethod($text);
  }
  // respond with JSON data
  Flight::json($filterMethod->getReplaceTokens());
});


Flight::route('GET /methods', function (){
  Flight::json(FilterMethods::list());
});

Flight::route('/', function(){
  echo '<h3>IdiomReplaceX filter api</h3>Endpoints:<ul><li>/filter</li></ul>';
});

Flight::start();
