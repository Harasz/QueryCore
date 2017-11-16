<?PHP
/*
  * File works.php 
  *
  * Author: Jakub
  * Copyright by author
  * You can edit file but you cant remove this comment
  *
  *
  * Zawiera wszystkie zadania i fukncje
*/

function channelTime() {
  global $queryCore;
  global $setup;
  $ci = $queryCore ->channelInfo($setup['work']['channelInfo']['time']['channelId']);
  $channelNameReplace = str_replace('[time]' ,date('H:i') ,$setup['work']['channelInfo']['time']['channelName']);
  $data = array('channel_name' => $channelNameReplace,);
  if($ci['data']['channel_name'] !== $channelNameReplace) $queryCore ->channelEdit($setup['work']['channelInfo']['time']['channelId'],$data);
}


function channelClientOnline() {
  global $queryCore;
  global $setup;
  $ci = $queryCore ->channelInfo($setup['work']['channelInfo']['clientsOnline']['channelId']);
  $serverInfo = $queryCore->serverInfo();
  $clientsOnline = $serverInfo['data']['virtualserver_clientsonline']-1;
  $channelNameReplace = str_replace('[online]' ,$clientsOnline ,$setup['work']['channelInfo']['clientsOnline']['channelName']);
  $data = array('channel_name' => $channelNameReplace,);
  if($ci['data']['channel_name'] !== $channelNameReplace) $queryCore ->channelEdit($setup['work']['channelInfo']['clientsOnline']['channelId'],$data);
}


function channelClientRecord() {
  global $queryCore;
  global $setup;
  $ci = $queryCore ->channelInfo($setup['work']['channelInfo']['clientsRecord']['channelId']);
  $record = file_get_contents('function/cache/userRecord.txt', true);
  $serverInfo = $queryCore->serverInfo();
  $channelNameReplace = str_replace('[record]' ,$record ,$setup['work']['channelInfo']['clientsRecord']['channelName']);
  $data = array('channel_name' => $channelNameReplace,);
  if ($serverInfo['data']['virtualserver_clientsonline'] > $record) {
    $channelNameReplace2 = str_replace('[record]' ,$serverInfo['data']['virtualserver_clientsonline']-1 ,$setup['work']['channelInfo']['clientsRecord']['channelName']);
    $data = array('channel_name' => $channelNameReplace2,);
    file_put_contents('function/cache/userRecord.txt', $serverInfo['data']['virtualserver_clientsonline']);
  }
  if($ci['data']['channel_name'] !== $channelNameReplace) $queryCore ->channelEdit($setup['work']['channelInfo']['clientsRecord']['channelId'], $data);
}

function hostMessage() {
  global $queryCore;
  global $setup;
  $serverinfo = $queryCore->serverInfo(); 
  $uptime = $queryCore ->convertSecondsToStrTime($serverinfo['data']['virtualserver_uptime']);
  $hostMessage = file_get_contents($setup['work']['hostMessage']['message'], true);
  $hostMessage = str_replace('[online]' ,$serverinfo['data']['virtualserver_clientsonline'] ,$hostMessage);
  $hostMessage = str_replace('[uptime]' ,$uptime ,$hostMessage);
  $hostMessage = simple_convert($hostMessage);
  $data = array('virtualserver_hostmessage' => $hostMessage, 'virtualserver_hostmessage_mode' => 2);
  $queryCore ->serverEdit($data);
}

function listeners() {
  global $queryCore;
  global $setup;
  $channel = $queryCore->channelList();
  foreach ($channel['data'] as $channell) {
    foreach($setup['work']['listeners']['area'] as $cid => $cid2) {
      if($channell['cid'] == $cid) {
        $channell['total_clients'] = $channell['total_clients']-1;
        if($channell['total_clients'] >= 0) {
          $channelNameReplace = str_replace('[listeners]' ,$channell['total_clients'] ,$setup['work']['listeners']['channelName']);
        } else {
          $channelNameReplace = $setup['work']['listeners']['offline'];
        }
        $data = array('channel_name' => $channelNameReplace);
        $ci = $queryCore ->channelInfo($cid2);
        if($ci['data']['channel_name'] !== $channelNameReplace) $queryCore ->channelEdit($cid2, $data);
      }
    }
  } 
}

function globalMessage() {
  global $queryCore;
  global $setup;
  $globalMessage = file_get_contents($setup['work']['globalMessage']['message'], true);
  $serverinfo = $queryCore->serverInfo(); 
  $globalMessage = str_replace('[online]' ,$serverinfo['data']['virtualserver_clientsonline'] ,$globalMessage);
  $globalMessage = str_replace('[total]' ,$serverinfo['data']['virtualserver_maxclients'] ,$globalMessage);
  $globalMessage = simple_convert($globalMessage);
  $queryCore ->sendMessage(3, $serverinfo['data']['virtualserver_id'], $globalMessage);
}

function serverName() {
  global $queryCore;
  global $setup;
  $si = $queryCore ->serverInfo(); 
  $serverName = str_replace('[online]' ,$si['data']['virtualserver_clientsonline'] ,$setup['work']['serverName']['serverName']);
  $serverName = str_replace('[total]' ,$si['data']['virtualserver_maxclients'] ,$serverName);
  $data = array('virtualserver_name' => $serverName);
  if($si['data']['virtualserver_name'] !== $serverName) $queryCore ->serverEdit($data);
}

function adminList() {
  global $queryCore;
  global $setup;
  global $connect;
  $description = '';$admins = 0;
  foreach ($setup['work']['adminList']['adminGroup'] as $adminGroup) {
    $clientList = $queryCore ->serverGroupClientList($adminGroup, $names = true);
    $description .= '[center][COLOR=#424242][size=16][B]'.name_group($adminGroup).'[/B][/size][/COLOR][/center]\n[size=12][list]';
    foreach ($clientList['data'] as $user) {
        if (online_check($user['client_unique_identifier'])) {
          if ($user['client_unique_identifier'] != 'serveradmin' || $connect['nickname'] != $user['client_nickname']){
            $info = $queryCore ->clientInfo(clid_check($user['client_unique_identifier']));
            $onChannel = $queryCore ->channelInfo($info['data']['cid']);
              if ($info['data']['client_output_muted'] || $info['data']['client_away']) {
               $status = 'Chwilowo niedostępny';
               $color = '#ca8700';
              } else {
               $status = 'Dostępny';
               $color = '#347C17';
               ++$admins;
             }
            $description .= '\n[*][url=client://'.$info['data']['client_database_id'].'/'.$info['data']['client_unique_identifier'].']'.$user['client_nickname'].'[/url]\n\nStatus: [b][color='.$color.']'.$status.'[/color][/b]\n\nNa kanale: [b][url=channelID://'.$info['data']['cid'].']'.$onChannel['data']['channel_name'].'[/url][/b]\n\nCzas na serwerze: [b]'.format_seconds($info['data']['connection_connected_time']).'[/b]\n\n' ; 
          }
        } elseif (isset($user['cldbid'])) {
          $dbifno = $queryCore ->clientDbInfo($user['cldbid']);
          $description .= '\n[*][url=client://'.$dbifno['data']['client_database_id'].'/'.$dbifno['data']['client_unique_identifier'].']'.$dbifno['data']['client_nickname'].'[/url]\n\nStatus: [color=red][b]Niedostępny[/b][/color]\n\nOstatnio połączony [b]'.date('H:i \d\n\i\a d-m-Y', $dbifno['data']['client_lastconnected']).'[/b]\n\n';
        }
    }
    $description .= '\n[/list][/size]\n';
  }
  $description .= '[right][size=8]Wygenerowane przez:  [B]Query Core - Make it automatic[/B]
[I]Free query application for automating server[/I][/size][/right]'; // * Dont remove this line (c) * 
  $ci = $queryCore ->channelInfo($setup['work']['adminList']['adminList']);
  if($ci['data']['channel_description'] !== $description) {
    $data = array('channel_description' => $description);
    $queryCore ->channelEdit($setup['work']['adminList']['adminList'], $data);
  }
  if ($setup['work']['adminList']['channelAdminCount']['active']) {
    $adminsCount = str_replace('[count]' ,$admins ,$setup['work']['adminList']['channelAdminCount']['channelName']);
    $data1 = array('channel_name' => $adminsCount);
    $ci1 = $queryCore ->channelInfo($setup['work']['adminList']['channelAdminCount']['adminCountID']);
    if($ci1['data']['channel_name'] !== $adminsCount) {
      $queryCore ->channelEdit($setup['work']['adminList']['channelAdminCount']['adminCountID'], $data1);
    } 
  }

}

function userOnChannel() {
  global $queryCore;
  global $setup;
  global $connect;
  $clientList = $queryCore ->clientList('-uid -away -voice -groups');
  foreach ($setup['work']['userOnChannel']['channels'] as $channels => $channel) {
    $userToPokes = array(); $i=0;
    $adminToPokes = array(); $j=0;
    foreach ($clientList['data'] as $user) {
      $user['client_servergroups'] = explode(',', $user['client_servergroups']);
      if ($user['cid']==$channels && check_admin($user['client_servergroups'],$channel['group'])) {
        continue 2;
      } elseif ($user['cid']==$channels && !check_admin($user['client_servergroups'], $channel['group'])) {
        if ($user['client_output_muted'] || $user['client_away']) {
          $queryCore ->clientPoke($user['clid'], 'Jesteś wyciszony! Musisz być aktywnym aby móc sobie pomóc');
          $queryCore ->clientKick($user['clid'], $kickMode = 'channel', $kickmsg = 'Jesteś wyciszony! Musisz być aktywnym aby móc sobie pomóc');   
        } else {
          ++$i;
          $userToPokes[$i] = $user['clid'];
        }
      }      
    }
    if (array_key_exists(1, $userToPokes)) {
      foreach ($clientList['data'] as $user) {
        $user['client_servergroups'] = explode(',',$user['client_servergroups']);
        if ($user['cid']!=$channels && check_admin($user['client_servergroups'],$channel['group']) && $user['client_unique_identifier'] != 'serveradmin') {
          ++$j;
          $adminToPokes[$j] = $user['clid'];
        }      
      }
    }
    if (array_key_exists(1, $adminToPokes)) {
      $userMessage = file_get_contents($channel['userMessage'], true);
      $adminMessage = file_get_contents($channel['adminMessage'], true);
      $userMessage = simple_convert($userMessage);
      $adminMessage = simple_convert($adminMessage);
    } elseif (array_key_exists(1, $userToPokes)) {
      $userMessage = file_get_contents($channel['adminOffline'], true);
      $userMessage = simple_convert($userMessage);
    }
    switch ($channel['method']) {
      case 1:
        foreach ($userToPokes as $user) {
          $queryCore ->clientPoke($user, $userMessage);
        }
        if (isset($adminMessage)) {
          foreach ($adminToPokes as $user) {
            $queryCore ->clientPoke($user, $adminMessage);
          }
        }
        break;
      
      case 2:
        foreach ($userToPokes as $user) {
          $queryCore ->sendMessage(1, $user, $userMessage);
        }
        if (isset($adminMessage)) {
          foreach ($adminToPokes as $user) {
            $queryCore ->sendMessage(1, $user, $adminMessage);
          }
        }
        break;

      case 3:
        foreach ($userToPokes as $user) {
          $queryCore ->sendMessage(1, $user, $userMessage);
        }
        if (isset($adminMessage)) {
          foreach ($adminToPokes as $user) {
            $queryCore ->clientPoke($user, $adminMessage);
          }
        }
        break;
    }
  }
}


function channelRegister() {
  global $queryCore;
  global $setup;
  $clientList = $queryCore ->clientList('-groups');
  foreach ($clientList['data'] as $user) {
    foreach ($setup['work']['channelRegister']['registerGroup'] as $sgid => $cid) {
      if ($user['cid'] == $cid && array_key_exists($user['client_servergroups'],$setup['work']['channelRegister']['registerGroup'])){
        $queryCore ->clientPoke($user['clid'], 'Zostałeś już zarejestrowany!');
        $queryCore ->clientKick($user['clid'], $kickMode = 'channel', $kickmsg = 'Zostałeś już zarejestrowany!'); 
      } elseif ($user['cid'] == $cid && !array_key_exists($user['client_servergroups'],$setup['work']['channelRegister']['registerGroup'])) {
        $queryCore ->serverGroupAddClient($sgid, $user['client_database_id']);   
        $queryCore ->clientPoke($user['clid'], 'Zostałeś zarejestrowany jako: [b]'.name_group($sgid));
        $queryCore ->clientKick($user['clid'], $kickMode = 'channel', $kickmsg = 'Zostałeś zarejestrowany jako: '.name_group($sgid)); 
      }
    }
  }
}


function removeChannel() {
  global $queryCore;
  global $setup;

  $channelList = $queryCore ->channelList('-topic -limits');
  $time['now'] = date('d-m-Y');
  $time['near'] = date('d-m-Y',strtotime('+1 day'));
  $channelToLengthen = array(); $i=0;$channelToRemove = array(); $j=0;$channelCloseRemove = array(); $k=0; $channelCount=0;
  foreach ($channelList['data'] as $channel) {
    if ($channel['channel_topic'] == $setup['work']['removeChannel']['freeChannelTopic']) ++$channelCount;
    if ($setup['work']['removeChannel']['areaID'] == $channel['pid']) $cn = $channel['channel_name'];
    if ($setup['work']['removeChannel']['areaID'] == $channel['pid'] && $channel['channel_topic'] != $setup['work']['removeChannel']['freeChannelTopic'] && $channel['channel_topic'] != $setup['work']['removeChannel']['ignoreChannelTopic']) {
      if ($channel['total_clients_family'] > 0) {
        ++$i;
        $channelToLengthen[$i] = $channel['cid'];
      } elseif (date_difference($time['now'],$channel['channel_topic'])<=-7) {
        ++$j;
        $channelToRemove[$j] = array('cid' => $channel['cid'], 'name' => $channel['channel_name'], 'order' => $channel['channel_order']);
      } elseif (date_difference($time['near'],$channel['channel_topic'])<-6) {
        ++$k;
        $channelCloseRemove[$k] = array('cid' => $channel['cid'], 'name' => $channel['channel_name']);
      }
    }
  }

    if ($channelCount < $setup['work']['removeChannel']['minFreeChannel']) {
      $data4 = array('channel_topic' => $setup['work']['removeChannel']['freeChannelTopic'], 'channel_flag_maxclients_unlimited' => 0,'channel_flag_maxfamilyclients_unlimited' =>0 ,'channel_flag_maxfamilyclients_inherited' => 0, 'channel_flag_permanent' => 1, 'cpid' => $setup['work']['removeChannel']['areaID']);
      for ($i=(integer)$cn;$i<$setup['work']['removeChannel']['minFreeChannel']+(integer)$cn;$i++) { 
        $data4['channel_name'] = ($i+1).'. '.$setup['work']['removeChannel']['freeChannelName'];
        $queryCore ->channelCreate($data4);
      }
    }

    if (array_key_exists(1, $channelToLengthen)) {
      $data = array('channel_topic' => date('d-m-Y',strtotime('+'.$setup['work']['removeChannel']['lengthen'].' day')));
      foreach ($channelToLengthen as $cid) {
        $ci = $queryCore ->channelInfo($cid);
          if ($ci['data']['channel_topic']!=$data['channel_topic']) $queryCore ->channelEdit($cid, $data);
      }
    }
    if (array_key_exists(1, $channelToRemove)) {
      $data3 = array('channel_topic' => $setup['work']['removeChannel']['freeChannelTopic'], 'channel_flag_maxclients_unlimited' => 0,'channel_flag_maxfamilyclients_unlimited' =>0 ,'channel_flag_maxfamilyclients_inherited' => 0, 'channel_flag_permanent' => 1, 'cpid' => $setup['work']['removeChannel']['areaID']);
      foreach ($channelToRemove as $cid) {
        $data3['channel_order'] = $cid['order'];
        $data3['channel_name'] = (integer)$cid['name'].'. '.$setup['work']['removeChannel']['freeChannelName'];
        $queryCore ->channelDelete($cid['cid'], $force = 1);
        $queryCore ->channelCreate($data3);
      }
    }
    $description = '[size=18]Kanały do usunięcia[/size]\n[size=10](zostaną usnięte w przeciągu 24h)[/size][list]';
    foreach ($channelCloseRemove as $key) {
      $description .= '[*][url=channelID://'.$key['cid'].']'.$key['name'].'[/url]';
    }
    $description .= '[/list][right][size=8]Wygenerowane przez:  [B]Query Core - Make it automatic[/B]
    [I]Free query application for automating server[/I][/size][/right]'; // * Dont remove this line (c) *
    $data2 = array('channel_description' => $description);
    $ci = $queryCore ->channelInfo($setup['work']['removeChannel']['closeRemoveChannelID']);
    if ($ci['data']['channel_description'] != $description) {
      $queryCore ->channelEdit($setup['work']['removeChannel']['closeRemoveChannelID'], $data2);
    }
}

function creatChannel() {
  global $queryCore;
  global $setup;

  $clientList = $queryCore ->clientList('-uid');
  $list = $queryCore->channelGroupClientList();
  $channelList = $queryCore ->channelList('-topic');
  foreach ($clientList['data'] as $user) {
    if ($user['client_unique_identifier'] == 'serveradmin') continue;
    if ($user['cid'] == $setup['work']['creatChannel']['channelId']) {
      foreach ($list['data'] as $key) {
        if ($key['cgid'] == $setup['work']['creatChannel']['channelAdminID'] && $key['cldbid']==$user['client_database_id']) {
          $queryCore ->clientKick($user['clid'],'channel','Posiadasz już kanał prywatny u nas.');
          $queryCore ->clientPoke($user['clid'], 'Posiadasz już kanał prywatny u nas.');
          continue 2;
        }
      }

      $data = array('channel_topic' => date('d-m-Y',strtotime('+2 day')), 'channel_flag_maxclients_unlimited' => 1,'channel_flag_maxfamilyclients_unlimited' =>1 ,'channel_flag_maxfamilyclients_inherited' => 0, 'channel_flag_permanent' => 1);
      foreach ($channelList['data'] as $channel) {
        if ($setup['work']['creatChannel']['areaID'] == $channel['pid'] && $channel['channel_topic'] == $setup['work']['creatChannel']['freeChannelTopic']) {
          $data['channel_name'] = (integer)$channel['channel_name'].'. Kanał prywatny - '.$user['client_nickname'];
          $queryCore ->channelEdit($channel['cid'], $data);
          for($i=1; $i<=$setup['work']['creatChannel']['countSubChannels']; $i++) {
            $data2 = array('channel_flag_permanent' => 1, 'cpid' => $channel['cid'], 'channel_name' => ''.$i.'. Podkanał - '.$user['client_nickname']);
            $queryCore ->channelCreate($data2);
          }
          $queryCore ->clientMove($user['clid'], $channel['cid']);
          $queryCore ->clientPoke($user['clid'], 'Kanał został Ci przydzielony. Numer kanału: '.(integer)$channel['channel_name']);
          $queryCore ->setClientChannelGroup($setup['work']['creatChannel']['channelAdminID'], $channel['cid'], $user['client_database_id']);
          continue 2;
        }
      }
      $queryCore ->clientKick($user['clid'],'channel','Aktualnie nie ma żadnych wolnych kanałów.');
      $queryCore ->clientPoke($user['clid'], 'Aktualnie nie ma żadnych wolnych kanałów.');
    }
  }
}

function welcomeMessage() {
  global $queryCore;
  global $setup;
  global $clients;

  $users = $queryCore ->clientList();
  $client = array();
  foreach ($users['data'] as $user) {
    array_push($client, $user['clid']);
  }

  $diff = array_diff($client, $clients);
  if ($diff!=0) {
    $userMessage = file_get_contents($setup['work']['welcomeMessage']['welcomeMessage'], true);
    $serverinfo = $queryCore ->serverInfo();
    $msg = simple_convert($userMessage);
    $msg = str_replace('[server_uptime]' ,$queryCore ->convertSecondsToStrTime($serverinfo['data']['virtualserver_uptime']) ,$msg);
    $msg = str_replace('[server_online]' ,$serverinfo['data']['virtualserver_clientsonline'] ,$msg);
    $msg = str_replace('[server_maxOnline]' ,$serverinfo['data']['virtualserver_maxclients'] ,$msg);
    $msg = str_replace('[server_name]' ,$serverinfo['data']['virtualserver_name'] ,$msg);
    foreach ($diff as $users) {
      $user = $queryCore ->clientInfo($users);     
      $msgr = str_replace('[client_name]' ,$user['data']['client_nickname'] ,$msg);
      $msgr = str_replace('[client_platform]' ,$user['data']['client_platform'] ,$msgr);
      $msgr = str_replace('[client_ip]' ,$user['data']['connection_client_ip'] ,$msgr);
      $msgr = str_replace('[client_lastconnected]' ,$user['data']['client_lastconnected'] ,$msgr);
      $msgr = str_replace('[client_totalconnections]' ,$user['data']['client_totalconnections'] ,$msgr);
      $msgr = str_replace('[client_country]' ,$user['data']['client_country'] ,$msgr);
      $msgr = str_replace('[uid]' ,$user['data']['client_unique_identifier'] ,$msgr);
      $queryCore ->sendMessage(1, $users, $msgr);
    }
  }
  $clients = $client;
}

function rangTime() {
  global $queryCore;
  global $setup;

  $clientList = $queryCore ->clientList('-groups');
  foreach ($clientList['data'] as $user) {
    $user['client_servergroups'] = explode(',', $user['client_servergroups']);
    foreach ($setup['work']['rangTime']['setup'] as $gid => $time) {
      if($user['client_type']==0 && !check_admin($user['client_servergroups'],array($gid))) {
        $info = $queryCore ->clientInfo($user['clid']);
        if (($info['data']['connection_connected_time']/1000) >= $time) {
          $queryCore ->serverGroupAddClient($gid, $info['data']['client_database_id']);
        }
      }
    }
  }
}

function adminChannelStatus() {
  global $queryCore;
  global $setup;

  $channelList = $queryCore ->channelList('-topic');
  foreach ($channelList['data'] as $channel) {
    $channel['channel_topic'] = explode(',', $channel['channel_topic']);
    if ($channel['channel_topic'][0] == 'status') {
      if (online_check($channel['channel_topic'][1])) {
        $status = $setup['work']['adminChannelStatus']['online'];
      } else {
        $status = $setup['work']['adminChannelStatus']['offline'];
      }
      $fix = str_replace('[status]' ,$status ,$setup['work']['adminChannelStatus']['fix']);
      switch ($setup['work']['adminChannelStatus']['method']) {
        case '1':
          $fix = $fix.$channel['channel_topic'][2];
          break;
        case '2':
          $fix = $channel['channel_topic'][2].$fix;
          break;      
      }
      if($channel['channel_name'] !== $fix) {
        $data = array('channel_name' => $fix);
        $queryCore ->channelEdit($channel['cid'], $data);
      }
    }
  }
}

function afk() {
  global $queryCore;
  global $setup;
  $userAFK = array(); $i=0;
  $clientList = $queryCore ->clientList('-away -voice -groups -times');
  foreach ($clientList['data'] as $user) {
    $user['client_servergroups'] = explode(',', $user['client_servergroups']);
    if (($user['client_output_muted'] || $user['client_away']) && !check_admin($setup['work']['afk']['groupIgnore'],$user['client_servergroups'])) {
      ++$i;
      $userAFK[$i] = array('clid' => $user['clid'], 'cid' => $user['cid'], 'time' => $user['client_idle_time']);
    }
  }
  if (array_key_exists(1, $userAFK)) {
    switch ($setup['work']['afk']['method']) {
      case '1':
        foreach ($userAFK as $user) {
          if ($user['cid'] != $setup['work']['afk']['afkChannel']) {
            $queryCore ->clientMove($user['clid'], $setup['work']['afk']['afkChannel']);
          }
        }
        break;

      case '2':
        foreach ($userAFK as $user) {
          if ($user['time']/1000 >= $setup['work']['afk']['timeToKick']) {
            $queryCore ->clientKick($user['clid'], "server", "Byłeś za długo AFK");
          }
        }
        break;
    }
  }
}
