<?PHP
/*
  * File function.php 
  *
  * Author: Jakub
  * Copyright by author
  * You can edit file but you cant remove this comment
  *
  *
  * Zawiera dodatkowe funkcje niezbędne do dobrego działania bota
*/

function work_interval_check($time, $time2, $interval) {
		$check = strtotime($time);
		$check2 = strtotime($time2);
		$difference_time = $check - $check2;
		if($difference_time >= $interval) return true;
		else return false;
}

function convert_interval($interval) {
		$interval['hours'] += $interval['days']*24;
		$interval['minutes'] += $interval['hours']*60;
		$interval['seconds'] += $interval['minutes']*60;
		return $interval['seconds'];
}

function name_group($sgid) {
	global $queryCore;
	$result = $queryCore ->serverGroupList();
	if(true === $result['success']) {
		foreach($result['data'] as $group) {
			if ($group['sgid']==$sgid) {
				return $group['name'];
			}
		}
	}
}

function online_check($uid) {
		global $queryCore;
		$clientList = $queryCore ->clientList("-uid");
		foreach($clientList['data'] as $client) {										
			if($client['client_unique_identifier'] == $uid) {
				return true;
			}
		}
    return false;
}

function clid_check($uid) {
    global $queryCore;
    $clientList = $queryCore ->clientList("-uid");
    foreach($clientList['data'] as $client) {                   
      if($client['client_unique_identifier'] == $uid) return $client['clid'];
    }
    return false;
}

function format_seconds($time) {    
    $time = $time / 1000;
    $hours = floor($time / 3600);
    $minutes = floor(($time / 60) % 60);
    $uptime_text = '';
    if ($hours > 0) $uptime_text .= $hours.' '.($hours == 1 ? 'godzina ' : 'godziny ');
    if ($minutes > 0) $uptime_text .= $minutes .' '.($minutes == 1 ? 'minuta ' : 'minut ');  
    if ($uptime_text == '') $uptime_text .= $seconds.' sekund';
    return $uptime_text;
  }

function simple_convert($msg) {    
    $msg = str_replace("\n" ,'\n' ,$msg); 
    $msg = str_replace(" " ,'\s' ,$msg);
    return $msg;
}

function check_admin($groups,$admin) {
    if (count(array_diff($groups, $admin)) < count($groups)) return true;
    else return false;
}

function date_difference($date_1, $date_2)
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    $interval = date_diff($datetime1, $datetime2);
    return $interval ->format('%R%a');
}

?>