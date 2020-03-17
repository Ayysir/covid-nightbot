<?php
/**
* Class and Function List:
* Function list:
* - _getJSON()
* Classes list:
*/
header('Content-type: text/plain');

function _getJSON($url)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // so curl_exec returns data
    // grab URL and pass it to the browser; store returned data
    $curlRes = curl_exec($ch);

    if (curl_errno($ch))
      {
        echo 'Error:' . curl_error($ch);
      }

    // close cURL resource, and free up system resources
    curl_close($ch);
    // Decode returned JSON so it can be handled as a multi-dimensional associative array
    return json_decode($curlRes, true);
  };

$total = _getJSON('https://corona.lmao.ninja/all');

// get latest post url
$cases     = intval($total['cases']);
$deaths    = intval($total['deaths']);
$recovered = intval($total['recovered']);
//confirmed to death ratio
$ratio = ($deaths*100)/$cases;


echo "Current COVID-19 info in total " . "Confirmed: " . $cases . " | Deaths: " . $deaths . " | Recovered: " . $recovered . " | Ratio: " . round($ratio, 2) 
?>