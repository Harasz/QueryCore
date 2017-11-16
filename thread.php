<?php
/*
  * File thread.php 
  *
  * Author: Jakub
  * Copyright by author
  * You can edit file but you can not remove this comment
  *
*/
	

/*
  *  
  * Podstawowe ustawnienia wątku
  *
*/	

date_default_timezone_set('Europe/Warsaw');
ini_set('error_reporting', E_ALL);
ini_set('default_charset', 'UTF-8');
setlocale(LC_ALL, 'UTF-8');

/*
  *  
  * Wątek ładuje wszystkie potrzebne biblioteki
  *
*/

require 'setup.php';
require 'lib/ts3admin.class.php';
require 'function/works.php';
require 'function/function.php';


/*
  *  
  * Generator loga
  *
*/

echo <<<END

   _////                                      
  _//    _//                                   
_//       _//_//  _//   _//    _/ _///_//   _//
_//       _//_//  _// _/   _//  _//    _// _// 
_//       _//_//  _//_///// _// _//      _///  
  _// _/ _// _//  _//_/         _//       _//  
    _// //     _//_//  _////   _///      _//   
         _/                            _//     

    _//                              
 _//   _//                           
_//          _//    _/ _///   _//    
_//        _//  _//  _//    _/   _// 
_//       _//    _// _//   _///// _//
 _//   _// _//  _//  _//   _/        
   _////     _//    _///     _////   
                                     
                                by Jakub(@PGS)
                                www.jakub.ovh
\n\n
END;

/*
  *  
  * Wątek próbuje połączyć się z serwerem
  *
*/

$queryCore = new ts3admin($connect['ip'], $connect['port_query']); // * Tworzenie obiektu klasy ts3admin *

if($queryCore ->getElement('success', $queryCore->connect())) { // * Próba polączenia z serwerem *
		echo('(INFO) Poprawnie połączono z serwerem '.$connect['ip']."!\n");

		$queryCore ->login($connect['query_login'], $connect['query_password']); // * Próba zalogowania się na serwer *
		echo('(INFO) Zalogowano się na konto '.$connect['query_login']."\n");	

		$queryCore ->selectServer($connect['port']); // * Wybór serwera za pomocą portu *
		echo('(INFO) Wybrano serwer o porcie: '.$connect['port']."\n");

		$queryCore ->setName($connect['nickname']); // * Zmiana nazwa bota *
		echo('(INFO) Nazwa bota została zmieniona na '.$connect['nickname']."\n");

		$botInfo = $queryCore ->getElement('data', $queryCore->whoAmI()); // * Pobieranie informacj o kliecncie(bocie) *
		$queryCore ->clientMove($botInfo['client_id'], $connect['channel']); // * Przenoszenie klienta na określony kanał *
		echo('(INFO) Bot został przeniesiony na kanał '.$connect['channel']."\n");
		
		echo("(INFO) Wszystkie zadania zakończono sukcesem\n\nBot zaczał pracę!\n");

		if($setup['work']['welcomeMessage']['active']) {
			$cl = $queryCore ->clientList();
			$clients = array();
			foreach ($cl['data'] as $user) {
    			array_push($clients, $user['clid']);
  			}
  		}
		
		while(true)
		{
				$loop_time = date('Y-m-d G:i:s'); // * Czas wykonywania pętli *

					if($setup['work']['welcomeMessage']['active']) {
						welcomeMessage();
					}

					if($setup['work']['channelInfo']['time']['active']) {
						if(work_interval_check($loop_time, $setup['work']['channelInfo']['time']['dateZero'], convert_interval($setup['work']['channelInfo']['time']['interval']))) {
								channelTime();
								$setup['work']['channelInfo']['time']['dateZero'] = $loop_time;
						}
					}

					if($setup['work']['channelInfo']['clientsOnline']['active']) {
						if(work_interval_check($loop_time, $setup['work']['channelInfo']['clientsOnline']['dateZero'], convert_interval($setup['work']['channelInfo']['clientsOnline']['interval']))) {
								channelClientOnline();
								$setup['work']['channelInfo']['clientsOnline']['dateZero'] = $loop_time;
						}
					}

					if($setup['work']['channelInfo']['clientsRecord']['active']) {
						if(work_interval_check($loop_time, $setup['work']['channelInfo']['clientsRecord']['dateZero'], convert_interval($setup['work']['channelInfo']['clientsRecord']['interval']))) {
								channelClientRecord();
								$setup['work']['channelInfo']['clientsRecord']['dateZero'] = $loop_time;
						}
					}

					if($setup['work']['hostMessage']['active']) {
						if(work_interval_check($loop_time, $setup['work']['hostMessage']['dateZero'], convert_interval($setup['work']['hostMessage']['interval']))) {
								hostMessage();
								$setup['work']['hostMessage']['dateZero'] = $loop_time;
						}
					}

					if($setup['work']['listeners']['active']) {
						if(work_interval_check($loop_time, $setup['work']['listeners']['dateZero'], convert_interval($setup['work']['listeners']['interval']))) {
								listeners();
								$setup['work']['listeners']['dateZero'] = $loop_time;
						}
					}

					if($setup['work']['globalMessage']['active']) {
						if(work_interval_check($loop_time, $setup['work']['globalMessage']['dateZero'], convert_interval($setup['work']['globalMessage']['interval']))) {
								globalMessage();
								$setup['work']['globalMessage']['dateZero'] = $loop_time;
						}
					}

					if($setup['work']['serverName']['active']) {
						if(work_interval_check($loop_time, $setup['work']['serverName']['dateZero'], convert_interval($setup['work']['serverName']['interval']))) {
								serverName();
								$setup['work']['serverName']['dateZero'] = $loop_time;
						}
					}

					if($setup['work']['adminList']['active']) {
						if(work_interval_check($loop_time, $setup['work']['adminList']['dateZero'], convert_interval($setup['work']['adminList']['interval']))) {
								adminList();
								$setup['work']['adminList']['dateZero'] = $loop_time;
						}
					}

					if($setup['work']['userOnChannel']['active']) {
						if(work_interval_check($loop_time, $setup['work']['userOnChannel']['dateZero'], convert_interval($setup['work']['userOnChannel']['interval']))) {
								userOnChannel();
								$setup['work']['userOnChannel']['dateZero'] = $loop_time;
						}
					}

					if($setup['work']['channelRegister']['active']) {
						if(work_interval_check($loop_time, $setup['work']['channelRegister']['dateZero'], convert_interval($setup['work']['channelRegister']['interval']))) {
								channelRegister();
								$setup['work']['channelRegister']['dateZero'] = $loop_time;
						}
					}

					if($setup['work']['removeChannel']['active']) {
						if(work_interval_check($loop_time, $setup['work']['removeChannel']['dateZero'], convert_interval($setup['work']['removeChannel']['interval']))) {
								removeChannel();
								$setup['work']['removeChannel']['dateZero'] = $loop_time;
						}
					}

					if($setup['work']['creatChannel']['active']) {
						if(work_interval_check($loop_time, $setup['work']['creatChannel']['dateZero'], convert_interval($setup['work']['creatChannel']['interval']))) {
								creatChannel();
								$setup['work']['creatChannel']['dateZero'] = $loop_time;
						}
					}

					if($setup['work']['rangTime']['active']) {
						if(work_interval_check($loop_time, $setup['work']['rangTime']['dateZero'], convert_interval($setup['work']['rangTime']['interval']))) {
								rangTime();
								$setup['work']['rangTime']['dateZero'] = $loop_time;
						}
					}

					if($setup['work']['adminChannelStatus']['active']) {
						if(work_interval_check($loop_time, $setup['work']['adminChannelStatus']['dateZero'], convert_interval($setup['work']['adminChannelStatus']['interval']))) {
								adminChannelStatus();
								$setup['work']['adminChannelStatus']['dateZero'] = $loop_time;
						}
					}

					if($setup['work']['afk']['active']) {
						if(work_interval_check($loop_time, $setup['work']['afk']['dateZero'], convert_interval($setup['work']['afk']['interval']))) {
								afk();
								$setup['work']['afk']['dateZero'] = $loop_time;
						}
					}

					if(count($queryCore ->getDebugLog()) > 0) {
						foreach($queryCore ->getDebugLog() as $fail) {
							echo("\nBłąd: ".$fail);
						}
					}
					sleep(10);
		}
		
		
	
} else {

		echo('(Błąd) Nie można ustanowić polączenie z serwerem!\n');
		if(count($queryCore ->getDebugLog()) > 0) {
			foreach($queryCore ->getDebugLog() as $fail) {
				echo("\nBłąd: ".$fail);
			}
		}
		echo("(INFO) Upewnij się, że wprowadziłeś porpawne dane w setup.php\n");
}

?>