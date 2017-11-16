<?PHP
/*
  * File config.php 
  *
  * Author: Jakub
  * Copyright by author
  * You can edit file but you cant remove this comment
  *
*/

/*
  *  
  * Dane do połączenia z serwerem
  *
*/
$connect['ip']= "127.0.0.1"; // * Adres IP twojego serwera *

$connect['port']= "9987"; // * Port UDP twojego serwera *

$connect['port_query']= "10011"; // * Port TCP twojego serwera *

$connect['query_login']= "serveradmin"; // * Login dla konta query (Zalecane używać serveradmin by wszystkie funkcje działały poprawnie) *

$connect['query_password']= "kuba"; // * Hasło do tego konta *

$connect['channel']= "2"; // * Kanał z którym bot ma się łączyć *

$connect['nickname']= "TS-KAKTUS.pl @ Aktualizator"; // * Nazwa bota na serwerze *


/*
  *  
  * Rozpoczęcie konfiguracji funkcji bota
  *
  * Wszystkie funkcje bota dokładnie opisane są w manualu dołączonym do paczki.
*/



/*
  * Wiadomość powitalna
*/
$setup['work']['welcomeMessage'] = array(

  'active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

  'welcomeMessage' => 'message/welcomeMessage.txt', // * ID kanału na którym ma wyświetlać godzine *

  );

/*
  * Godzina
*/
$setup['work']['channelInfo']['time'] = array(

  'active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

  'channelId' => 4, // * ID kanału na którym ma wyświetlać godzine *

  'channelName' => "Godzina: [time]", // * Nazwa na jaką ma zmienic | [time] w tym miejsciu będzie wyświetlana godzina *

  'interval' => array('days' => 0, // * Co ile ma zmieniać godzinę na kanale *
                      'hours' => 0,
                      'minutes' => 1,
                      'seconds' => 0),

  'dateZero' => "1970-01-01 00:00:00",
  );

/*
  * Ilość klientów online
*/
$setup['work']['channelInfo']['clientsOnline'] = array(

  'active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

  'channelId' => 2, // * ID kanału na którym ma wyświetlać aktualną liczbę osób online *

  'channelName' => "• Online: [online] •", // * Nazwa na jaką ma zmienic | [online] w tym miejsciu będzie wyświetlana aktualna liczba osób online *

  'interval' => array('days' => 0, // * Co ile ma zmieniać ilość osób online na kanale *
                      'hours' => 0,
                      'minutes' => 0,
                      'seconds' => 50),

  'dateZero' => "1970-01-01 00:00:00",
  );

/*
  * Rekord użytkowników online
*/
$setup['work']['channelInfo']['clientsRecord'] = array(

  'active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

  'channelId' => 3, // * ID kanału na którym ma wyświetlać aktualny rekord osób online *

  'channelName' => " • Rekord online: [record] •", // * Nazwa na jaką ma zmienic | [record] w tym miejsciu będzie wyświetlany aktualny rekord osób online *

  'interval' => array('days' => 0, // * Co ile ma sprawdzać rekord ludzi na serwerze *
                      'hours' => 0,
                      'minutes' => 0,
                      'seconds' => 50),

  'dateZero' => "1970-01-01 00:00:00",
  );

/*
  * Zmiana nazwy serwera
*/
$setup['work']['serverName'] = array(

  'active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

  'serverName' => "TS-EXAMPLE.com [Online: [online]/[total]]", // * Nazwa na jaką ma zmieniać | [online] w tym miejsciu będzie wyświetlany aktualny liczba osób online | [total] w tym miejscu będzie wyświetlana ilośc slotów na serwerze*

  'interval' => array('days' => 0, // * Co ile ma zmieniać nazwę serwera *
                      'hours' => 0,
                      'minutes' => 2,
                      'seconds' => 50),

  'dateZero' => "1970-01-01 00:00:00",
);

/*
  * Wiadomość Hosta (Host Message)
*/
$setup['work']['hostMessage'] = array(

  'active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

  'message' => "message/host.txt", // * Ścieżka do pliku z którego będzie pobierana wiadomość hosta *

  'interval' => array('days' => 0, // * Co ile ma aktualizować wiadomość hosta *
                      'hours' => 0,
                      'minutes' => 4,
                      'seconds' => 50),

  'dateZero' => "1970-01-01 00:00:00",
);

/*
  * Liczba słuchaczy na kanale
*/
$setup['work']['listeners'] = array(

  'active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

  'area' => array( 1 => 113, ), // * ID_1 => ID_2 | ID_1 - Kanał z którego ma pobierać liczbę osoób, ID_2 - Kanał na którym ma wypisać liczbę osób na kanale *

  'channelName' => 'Aktualnie słuchaczy: [listeners]', // * Nazwa na jaką będzie zmieniać | [listeners] w tym miejscu będzie wyświetlana ilość osób na kanale *

  'offline' => 'Aktualnie bot jest offline', // * Nazwa w razie gdy bota nie będzie na kanale *

  'interval' => array('days' => 0, // * Co ile ma sprawdząć liczbę osób na kanle *
                      'hours' => 0,
                      'minutes' => 1,
                      'seconds' => 0),

  'dateZero' => "1970-01-01 00:00:00",
);

/*
  * Wiadomość na chat główny serwera
*/
$setup['work']['globalMessage'] = array(

  'active' => false, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

  'message' => "message/globalMessage.txt", // * Ścieżka do pliku z którego będzie pobierana wiadomość na chat globalny *

  'interval' => array('days' => 0, // * Co ile ma wysyłać wiadomość na czat globalny *
                      'hours' => 1,
                      'minutes' => 0,
                      'seconds' => 0),

  'dateZero' => "1970-01-01 00:00:00",
);

/*
  * Automatyczna lista administracji na kanale
  * dodatkowo możliwość zmiany nazwa kanału z ilością administracji online
*/
$setup['work']['adminList'] = array(

  'active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *
  
  'adminGroup' => array(6), // * ID grup Administracyjnych *

  'adminList' => 11, // * ID kanały na którym będzie aktualizowana lista administracji *

  // * Jest to opcja dodatkowa, wymaga włączonej opcji Listy administracji.
  'channelAdminCount' => array('active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

                                'channelName' => "Dostępnych Adminów: [count]", // * Nazwa na które będzie zmieniać | [count] w tym miejscu będzie wyświetlana ilość administracji online *

                               'channelNameNull' => "Brak dostępnych Adminów", // * Nazwa, która będzie ustawiana gdy nie będzię dostępnych administratorów *

                               'adminCountID' => 12,), // * ID kanału na którym będzie zmienia nazwa z ilościa administracji *

  'interval' => array('days' => 0, // * Co ile ma aktualizować listę administracji *
                      'hours' => 0,
                      'minutes' => 2,
                      'seconds' => 50),

  'dateZero' => "1970-01-01 00:00:00",
);

/*
  * Informacje w nazwie kanału o statusie administratora
*/
$setup['work']['adminChannelStatus'] = array(

  'active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *
  
  'method' => 2, // * 1 -  prefix, czyli przed nazwą kanalu | 2 - suffix, czyli po nazwie kanału *

  'fix' => ' ([status])', // * Jak ma wyglądać cześć, która jest dodawana | [status] - status administrator *

  'online' => 'ONLINE', // * Status gdy administrator jest na serwerze *

  'offline' => 'OFFLINE', // Status gdy administratora nie ma na serwerze *

  'interval' => array('days' => 0, // * Co ile ma aktualizować listę administracji *
                      'hours' => 0,
                      'minutes' => 5,
                      'seconds' => 0),

  'dateZero' => "1970-01-01 00:00:00",
);

/*
  * Informowanie administratora o oczekującym użytkowniku na kanale (potocznie zwane PokeBot)
*/
$setup['work']['userOnChannel'] = array(

  'active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

  'channels' => array(

    /* Wzór do skopiowania
        ID_Kanału => array('group' => array(2,6), // * Grupy, które ma poinformować *

                'method' => 1, // * 1 - Wysyłanie poków | 2 - wysyłanie wiadomości | 3 - Administrator dostaje poke, użytkownik dostaje wiadomość *

                'userMessage' => "message/userMessage.txt", // * Wiadomość wysyłana do osoby oczekującej na kanale *

                'adminMessage' => "message/adminMessage.txt", // * Wiadomość wysyłana do grupy, która ma zostać poinformowana *

                'adminOffline' => "message/nonAdminMessage.txt", // * Wiadomość wysyłana do uzytkownika gdy nie ma żadnego administratora na serwerze *
      ),
    */

    6 => array('group' => array(6), // * Grupy, które ma poinformować *

                'method' => 3, // * 1 - Wysyłanie poków | 2 - wysyłanie wiadomości | 3 - Administrator dostaje poke, użytkownik dostaje wiadomość *

                'userMessage' => "message/userMessage.txt", // * Wiadomość wysyłana do osoby oczekującej na kanale *

                'adminMessage' => "message/adminMessage.txt", // * Wiadomość wysyłana do grupy, która ma zostać poinformowana *

                'adminOffline' => "message/nonAdminMessage.txt", // * Wiadomość wysyłana do uzytkownika gdy nie ma żadnego administratora na serwerze *
      ),


    7 => array('group' => array(6), // * Grupy, które ma poinformować *

                'method' => 3, // * 1 - Wysyłanie poków | 2 - wysyłanie wiadomości | 3 - Administrator dostaje poke, użytkownik dostaje wiadomość *

                'userMessage' => "message/userMessage.txt", // * Wiadomość wysyłana do osoby oczekującej na kanale *

                'adminMessage' => "message/adminMessage.txt", // * Wiadomość wysyłana do grupy, która ma zostać poinformowana *

                'adminOffline' => "message/nonAdminMessage.txt", // * Wiadomość wysyłana do uzytkownika gdy nie ma żadnego administratora na serwerze *
      ),
    ),

  'interval' => array('days' => 0, // * Co ile ma sprawdzać czy użytkownik czeka na kanale *
                      'hours' => 0,
                      'minutes' => 0,
                      'seconds' => 5),

  'dateZero' => "1970-01-01 00:00:00",
);

/*
  * Automatyczna rejestracja po wejściu na kanał.
*/
$setup['work']['channelRegister'] = array(

  'active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

  'registerGroup' => array(// * ID_Grupy => ID_Kanału *(UWAGA) Uzytkownik może otrzymać tylko jedną z poniższych rang! *
                            9 => 9,
                            10 => 10),

  'interval' => array('days' => 0, // * Co ile ma przyznawać rangi osobą na kanle *
                      'hours' => 0,
                      'minutes' => 0,
                      'seconds' => 20),

  'dateZero' => "1970-01-01 00:00:00",
);

/*
  * Przydziela range po czasie czasie spędzonym na serwerze.
*/
$setup['work']['rangTime'] = array(

  'active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

  'setup' => array( 9 => '10', // * ID_rangi => 'czas w sekundach' | Ustawiamy, która range po jakim czasie ma nadać.
                    10 => '10',
    ),

  'interval' => array('days' => 0, // * Co ile ma sprawdzać kanały *
                      'hours' => 0,
                      'minutes' => 0,
                      'seconds' => 10),

  'dateZero' => "1970-01-01 00:00:00",
);

/*
  * Automatyczna sprawdzanie kanałów prywatnych
*/
$setup['work']['removeChannel'] = array(

  'active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

  'areaID' => 14, // * ID początku strefy prywatnej *

  'ignoreChannelTopic' => "Skip", // * Temat kanałów, które mają byc ignorowane *

  'lengthen' => 7, // * O ile dni ma przedłużyć date na kanale 

  'freeChannelTopic' => "Wolny", // * Temat kanału gdy jest wolny *

  'freeChannelName' => "Kanał prywatny - wolny", // * Nazwa kanału gdy jest wolny *

  'closeRemoveChannelID' => 18, // * ID kanału na którym ma wyświetlać kanały do usunięcia *

  'minFreeChannel' => 3, // * Minimalna ilość wolnych kanałów *

  'interval' => array('days' => 0, // * Co ile ma sprawdzać kanały *
                      'hours' => 0,
                      'minutes' => 10,
                      'seconds' => 0),

  'dateZero' => "1970-01-01 00:00:00",
);

/*
  * Automatyczne tworzenie kanałów w strefie prywatnej po wejściu na dany kanał
*/
$setup['work']['creatChannel'] = array(

  'active' => false, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

  'channelId' => 21, // * ID kanału z którego ma robić kanał

  'areaID' => 14, // * ID początku strefy prywatnej

  'channelAdminID' => 5, // * ID rangi channel admina

  'freeChannelTopic' => "Wolny", // * Temat kanału gdy jest wolny * 

  'countSubChannels' => 2, // * Temat kanału gdy jest wolny * 

  'interval' => array('days' => 0, // * Co ile ma sprawdzać kanały *
                      'hours' => 0,
                      'minutes' => 0,
                      'seconds' => 10),

  'dateZero' => "1970-01-01 00:00:00",
);

/*
  * Przenoszenie użytkowników, którzy mają status AFK
*/
$setup['work']['afk'] = array(

  'active' => true, // * Wartośc true - funkcja aktywna, wartość false - funkcja wyłączona *

  'groupIgnore' => array(11), // * Które grupy ma ignorować

  'method' => 1, // * 1 - Przenosi na kanał | 2 - wyrzuca z serwera * Wybór co ma robić z użytkownikiem gdy jest AFK *

  'afkChannel' => 102, // * ID kanału na, który ma przenosić użytkowników o statusie afk *

  'timeToKick' => 30, // * Jeśli została wybrana opcja 2 | Po jakim czasie ma wyrzucic w sekundach

  'interval' => array('days' => 0, // * Co ile ma sprawdzać kanały *
                      'hours' => 0,
                      'minutes' => 0,
                      'seconds' => 10),

  'dateZero' => "1970-01-01 00:00:00",
);

?>