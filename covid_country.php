<?php
/**
* Class and Function List:
* Function list:
* - _getJSON()
* Classes list:
*/
header('Content-type: text/plain');

$country = strtolower($_GET['country']);
if (!$country)
  {
    echo '\'&country=\' parameter not defined!';
    return;
  };

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

$countries = _getJSON('https://corona.lmao.ninja/countries/' . $country);

// get latest post url
$cases     = intval($countries['cases']);
$deaths    = intval($countries['deaths']);
$recovered = intval($countries['recovered']);
$critical  = intval($countries['critical']);
//confirmed to death ratio
$ratio = ($deaths*100)/$cases;

$date = date("m-d-Y", strtotime( '-1 days' ));
$url = "https://github.com/CSSEGISandData/COVID-19/blob/master/csse_covid_19_data/csse_covid_19_daily_reports/".$date.".csv";


echo "Current COVID-19 info in " . ucfirst($country) . ": Confirmed: " . $cases . " | Deaths: " . $deaths . " | Recovered: " . $recovered . " | Critical: " . $critical . " | Ratio: " . round($ratio, 2) . " (Detailed Spreadsheet here: " . $url . " )";
?>