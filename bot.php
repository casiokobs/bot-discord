<?php
include __DIR__.'/vendor/autoload.php';
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;


$discord = new Discord([
    'token' => 'OTg0ODk2MTEwMzg2NjQyOTU0.GDFAvY.CVEqk0YiSiIQsnZQLZHm6S2TTYlXQ99ZZu6vpg',
]);

$discord->on('ready', function (Discord $discord) {
    echo "Bot is ready!", PHP_EOL;
    

    // Listen for messages.
    $discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) {
        if(!$message->author->bot){
            $search ='teste';
            if(preg_match("#\scomando#", $message->content) or preg_match("#\scomandos#", $message->content)  or $message->content =='comando' or $message->content =='comandos'){
                $message->channel->sendMessage("!data      -   Informa data e hora atual(fuso SP)".PHP_EOL.
                                               "!dolar     -   Informa o valor do Dolar atual (1 $ -> R$ X)".PHP_EOL.
                                               "!euro      -   Informa o valor do Euro atual (1 € -> R$ X)".PHP_EOL.
                                               "!bitcoin  -   Informa o valor do Bitcoin atual(1 BTC -> R$ X)".PHP_EOL.
                                               "!clima     -   Informa a previsao do tempo atual (Concórdia,SC)");
            }
            
            if(preg_match("#\s{$search}#", $message->content) or $message->content =='teste' ){
                $message->reply('Anti-vacuo bot, teste ok.');    
            }

            if(preg_match("#\sgraça#", $message->content)){
                $message->reply('https://tenor.com/view/stonks-up-stongs-meme-stocks-gif-15715298');
            }

            if ($message->content == "!data") {
                date_default_timezone_set('America/Sao_Paulo');      
                $message->reply("Atualmente são: ". date('H:i:s', time())." da data de: ".date('d/m/y', time()));    
            } 

            if ($message->content == "!dolar") {
                $url=json_decode(file_get_contents('https://economia.awesomeapi.com.br/json/last/USD-BRL'));
                $message->reply("O valor do ".$url->USDBRL->code." em ".$url->USDBRL->codein." é de : ".$url->USDBRL->bid);
            }  

            if ($message->content == "!euro") {
                $url=json_decode(file_get_contents('https://economia.awesomeapi.com.br/json/last/EUR-BRL'));
                $message->reply("O valor do ".$url->EURBRL->code." em ".$url->EURBRL->codein." é de : ".$url->EURBRL->bid);
            }

            if ($message->content == "!bitcoin") {
                $url=json_decode(file_get_contents('https://economia.awesomeapi.com.br/json/last/BTC-BRL'));
                $message->reply("O valor do ".$url->BTCBRL->code." em ".$url->BTCBRL->codein." é de : ".$url->USDBRL->bid);
            }

            if (date('H:i', time()) == '15:48') {
                $message->channel->sendMessage("São ". date('H:i', time()));
            }
            if ($message->content =="!clima"){
                $data=json_decode(file_get_contents('https://api.openweathermap.org/data/2.5/weather?appid=093ce6ecabbf25627b1b05217357a35d&q=concordia,BR&units=metric&lang=pt_br'));
                $message->channel->sendMessage("A previsão para ".$data->name.",". $data->sys->country." é de ".$data->weather[0]->description." com temperatura atual de ".$data->main->temp."°C e com humidade de: ".$data->main->humidity."%".PHP_EOL."http://openweathermap.org/img/wn/".$data->weather[0]->icon."@2x.png");
                //"
                # code...
            }
            
        }
        //echo "{$message->author->username}: {$message->content}", PHP_EOL;
    });
});

$discord->run();