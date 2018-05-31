<?php
require 'vendor/autoload.php';
use Slack\Message\{Attachment, AttachmentBuilder, AttachmentField};

$loop = React\EventLoop\Factory::create();

$client = new Slack\RealTimeClient($loop);
$client->setToken('');

$client->on('message', function ($data) use ($client) {
	
	if(stripos($data['text'], 'hola') === 0) {
		$client->getChannelGroupOrDMByID($data['channel'])->then(function ($channel) use ($client, $data) {
			$message = $client->getMessageBuilder()
						->setText('Hola <@'.$data['user'].'>')
						->setChannel($channel)
						->create();
			$client->postMessage($message);
		});
	}
	
	if(stripos($data['text'], 'es viernes') === 0) {
		$client->getChannelGroupOrDMByID($data['channel'])->then(function ($channel) use ($client, $data) {
			$message = $client->getMessageBuilder()
						->setText('Y tu cuerpo lo sabe! :man_dancing: :dancer: <@'.$data['user'].'>')
						->setChannel($channel)
						->create();
			$client->postMessage($message);
		});
	}
});

$client->connect()->then(function () {
    echo "Conectado!\n";
});

$loop->run();

?>