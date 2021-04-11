<?php 
main();

#-----------------------------------------------------------------------------
# FUNCTIONS
#-----------------------------------------------------------------------------
function main () {
	
	$apiCall = 'https://api.covid19api.com/summary';
	$json_string = curl_get_contents($apiCall);
	$obj = json_decode($json_string);
	$death_arr = Array() ;
	foreach($obj->Countries as $i){
		$death_arr[$i->Country] = $i->TotalDeaths;
	}
	arsort($death_arr);

	echo '<html>';
	echo '<head>';
	echo "<a target='_blank' href='https://github.com/asimstha/covid19api/blob/main/APICovid19.php'>Source Code</a> <br><br>";
	echo '<style>';
	echo "table, th, td {
	border: 1px solid black;
	  	}";
	echo '</style>';
	echo '</head>';
	
	echo '<body onload="loadDoc()">';
	// Top 10 
	$death_arr = array_slice($death_arr,0,10);
	$JSONString=json_encode($death_arr);
	$JSONObject = json_decode($JSONString); 

	echo '<br><br>';
	echo "<div><b>Table</b>";
	echo "<table>";
        echo "<tr>";
		echo "<th>PHP</th>";
            echo "<th>Country</th>";
            echo "<th> Number of Death Cases</th>";
		echo "</tr>";
		$i=1;
		foreach ($death_arr as $country => $cases) {
			echo "<tr>";
			echo "<td>{$i}</td>";
			echo "<td>{$country}</td>";
			echo "<td>{$cases}</td>";
			echo "</tr>";
			$i++;
		 }
	echo "</table>";
	echo '</div>';
	echo '</body>';
	echo '</html>';
}

#-----------------------------------------------------------------------------
// read data from a URL into a string
function curl_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>