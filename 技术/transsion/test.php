<?php
//计时开始
function utime() {
    $time = explode( " ", microtime() );
    $usec = (double)$time[0];
    $sec = (double)$time[1];
    return $usec + $sec;
}
$startTimes = utime();

include("inc/geoip.inc");

// open the geoip database
$gi = geoip_open("inc/GeoIP.dat",GEOIP_STANDARD);

// 获取国家代码
$country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
echo "Your country code is: <strong>$country_code</strong> <br />";

// 获取国家名称
$country_name = geoip_country_name_by_addr($gi, $_SERVER['REMOTE_ADDR']);
echo "Your country name is: <strong>$country_name</strong> <br />";

// close the database
geoip_close($gi);

//运行结束时间
$endTimes = utime();
$runTimes = sprintf( '%0.4f', ( $endTimes - $startTimes ) );
echo "Processed in " . $runTimes . "second.";
$k = 1 / 0;

echo "2ddd2";
?>
