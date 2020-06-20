<?php
$api = $_GET['api'];

$config = [
'userbot' => "@Hard_Robot", // insert the username of your bot
'operatori_comandi' => ['/', '!', '.', '>', '?', '$', '-'], // cmd aliad
'parse_mode' => "HTML", // HTML or Markdown
'admins' => [], // ID bot admins
'disable_notification' => false, 
'disable_web_page_preview' => false, 
'request_timeout' => 2, 
'cambiare_info_del_gruppo' => false, 
'cancellare_messaggi' => true, 
'limitare_altri_utenti' => true, 
'fissare_messaggi' => true, 
'aggiungere_amministratori' => false 
];

# Informazioni del Bot
$botID = str_replace('bot', '', explode(":", $api)[0]); // ID del Bot
$admins = $config['admins']; // Amministratori del Bot


$parse_mode = $config['parse_mode'];


$disable_notification = $config['disable_notification'];


$disable_web_page_preview = $config['disable_web_page_preview'];

$can_change_info = $config['cambiare_info_del_gruppo'];
$can_delete_messages = $config['cancellare_messaggi'];
$can_restrict_members = $config['limitare_altri_utenti'];
$can_pin_messages = $config['fissare_messaggi'];
$can_promote_members = $config['aggiungere_amministratori'];


$request_timeout = $config['request_timeout'];
