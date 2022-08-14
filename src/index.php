<?php

$DEBUG=true;
if($DEBUG) {
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
}

require '../vendor/autoload.php';



/**
 *  An example CORS-compliant method.  It will allow any GET, POST, or OPTIONS requests from any
 *  origin.
 *
 *  In a production environment, you probably want to be more restrictive, but this gives you
 *  the general idea of what is involved.  For the nitty-gritty low-down, read:
 *
 *  - https://developer.mozilla.org/en/HTTP_access_control
 *  - https://fetch.spec.whatwg.org/#http-cors-protocol
 *
 * (from https://stackoverflow.com/questions/39519246/make-xmlhttprequest-post-using-json#39519299)
 */
function cors() {

  // Allow from any origin
  if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
  }

  // Access-Control headers are received during OPTIONS requests
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
      // may also be using PUT, PATCH, HEAD etc
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
      header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
  }
}

Flight::route('POST|GET /filter(/@method)', function($method){

  $request = Flight::request();
  if(isset($request->query['html'])){
    $html =  $request->query['html'];
    $htmlChecksum = $request->query['htmlChecksum'];
  } else {
    $html = $request->data->html;
    $htmlChecksum = $request->data->htmlChecksum;
  }

  if(!$html){
    Flight::halt(400, 'HAH parameter text missing in POST body or as request parameter.<br>Request.body=' . $request->getBody() . "<br>Request.data=" . var_export($request->data, true));
  }

  $htmlNormalized =  Normalizer::normalize($html);

  switch($method){
    case FilterMethods::KACKSPECHT:
        $filterMethod = new KackspechtFilterMethod($htmlNormalized);
        break;
    case FilterMethods::WEICHSPUELER:
        $filterMethod = new OneWordFilterMethod($htmlNormalized, FilterMethods::WEICHSPUELER);
        break;
    case FilterMethods::KLARSPUELER:
        $filterMethod = new OneWordFilterMethod($htmlNormalized, FilterMethods::KLARSPUELER);
        break;
    case FilterMethods::VERNIS:
        $filterMethod = new OneWordFilterMethod($htmlNormalized, FilterMethods::VERNIS);
        break;
    case FilterMethods::POLYNESIEN:
        $filterMethod = new OneWordFilterMethod($htmlNormalized, FilterMethods::POLYNESIEN);
        break;
    case FilterMethods::LESEBRILLE:
        $filterMethod = new OneWordFilterMethod($htmlNormalized, FilterMethods::LESEBRILLE);
        break;
    case FilterMethods::LAUT:
        $filterMethod = new LautFilterMethod($htmlNormalized);
        break;
    case FilterMethods::NOVERB:
        $filterMethod = new NoVerbFilterMethod($htmlNormalized);
        break;
    case FilterMethods::XX:
        $filterMethod = new XXFilterMethod($htmlNormalized);
        break;
    case FilterMethods::BASISFORM:
        $filterMethod = new BasisformFilterMethod($htmlNormalized);
        break;
    default:
      $filterMethod = new KackspechtFilterMethod($htmlNormalized);
  }
  // respond with JSON data
  Flight::json(new ResponseData($filterMethod->getReplaceTokens(), $htmlChecksum, $method));
});


Flight::route('GET /methods', function (){
  Flight::json(FilterMethods::list());
});

Flight::route('/', function(){
  echo '<h3>IdiomReplaceX filter api</h3>Endpoints:<ul><li>/filter</li><li>/methods</li></ul>';
});

// enable CORS requests
cors();
// start the Flight
Flight::start();
