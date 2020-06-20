<?php
require_once 'index.php';

$update = json_decode(file_get_contents("php://input"), true);

if (isset($update)) { // Inizio delle variabili

if (isset($update['channel_post'])) { // Post inviato su un canale
if ($config['post_canali']) {
$update['message'] = $update['channel_post'];
$update['message']['chat']['typechat'] = 'channel';
} else {
exit;
}
}

if (isset($update['edited_channel_post'])) { // Post modificato su un canale
if ($config['post_canali']) {
$modificato = true;
$update['message'] = $update['edited_channel_post'];
$update['message']['chat']['typechat'] = 'channel';
} else {
exit;
}
}

if (isset($update['edited_message'])) { // Messaggio modificato
if ($config['modificato']) {
$modificato = true;
$update['message'] = $update['edited_message'];
} else {
exit;
}
}

# Imformazioni utente su un canale
if (isset($update['message']['author_signature']) and $config['post_canali']) {
    $firma = $update['message']['author_signature']; // Firma del Post su un canale
}

# Imformazioni utente su un messaggio inoltrato dal canale
if (isset($update['message']['forward_signature']) and $config['post_canali']) {
    $ffirma = $update['message']['forward_signature']; // Firma del Post su un canale
}

# Informazioni utente
if (isset($update['message']['from'])) {
$exists_user = true;
$userID = $update['message']['from']['id'];
$nome = $update['message']['from']['first_name'];
$cognome = $update['message']['from']['last_name'];
$username = $update['message']['from']['username'];
$lingua = $update['message']['from']['language_code'];
}

# Informazioni utente inoltrato
if (isset($update['message']['forward_from'])) {
$exists_fuser = true;
$fuserID = $update['message']['forward_from']['id'];
$fnome = $update['message']['forward_from']['first_name'];
$fcognome = $update['message']['forward_from']['last_name'];
$fusername = $update['message']['forward_from']['username'];
$flingua = $update['message']['forward_from']['language_code'];
}

# Messaggio sulla risposta
if (isset($update['message']['reply_to_message'])) {
$reply = true;
$rtext = $update['message']['reply_to_message']['text']; // Testo del messaggio al quale si risponde
$rentities = $update['message']['reply_to_message']['entities']; // Entità del messaggio al quale si risponde
$rmessage_id = $update['message']['reply_to_message']['message_id']; // ID del messaggio al quale si risponde
$rdata = $update['message']['reply_to_message']['date']; // Data del messaggio in reply

# Informazioni utente sulla reply
if (isset($update['message']['reply_to_message']['from'])) {
$exists_ruser = true;
$ruserID = $update['message']['reply_to_message']['from']['id'];
$rnome = $update['message']['reply_to_message']['from']['first_name'];
$rcognome = $update['message']['reply_to_message']['from']['last_name'];
$rusername = $update['message']['reply_to_message']['from']['username'];
$rlingua = $update['message']['reply_to_message']['from']['language_code'];
}

# Informazioni utente inoltrato sulla reply
if (isset($update['message']['reply_to_message']['forward_from'])) {
$exists_rfuser = true;
$rfuserID = $update['message']['reply_to_message']['forward_from']['id'];
$rfnome = $update['message']['reply_to_message']['forward_from']['first_name'];
$rfcognome = $update['message']['reply_to_message']['forward_from']['last_name'];
$rfusername = $update['message']['reply_to_message']['forward_from']['username'];
$rflingua = $update['message']['reply_to_message']['forward_from']['language_code'];
}
}

 # Messaggio inviato
$text = $update['message']['text']; // Testo del messaggio inviato (Vale anche per quelli inoltrati)
$entities = $update['message']['entities']; // Entità del messaggio inviato (Vale anche per quelli inoltrati)
$message_id = $update['message']['message_id']; // ID del messaggio inviato
$caption = $update['message']['caption']; // Testo che si trova nei file media

# Date e orari [Timestamp]
$data = $update['message']['date']; // Data dell'invio del Messaggio (Vale anche per quelli inoltrati)
if (isset($modificato)) {
$edata = $update['message']['edit_date']['date']; // Data dell'ultima modifica sul messagio
}
$fdata = $update['message']['forward_date']; // Data del messaggio inoltrato

# Gruppi e Canali
$chat_id = $update['message']['chat']['id'];  // ID del gruppo/canale
$typechat = $update['message']['chat']['type']; // Tipo di chat (private, group, supergroup, channel)
if ($typechat !== "private") {
$title = $update['message']['chat']['title']; // Titolo del gruppo/canale
$usernamechat = $update['message']['chat']['username']; // Username del gruppo/canale
}

# Informazioni chat inoltrate
if (isset($update['message']['forward_from_chat'])) {
$fchat_id = $update['message']['forward_from_chat']['chat']['id']; // ID del gruppo/canale del messaggio inoltrato
$ftypechat = $update['message']['forward_from_chat']['chat']['type']; // Tipo ci chat (private, group, supergroup, channel) (In base all' inoltro)
if ($ftypechat !== "private") {
$ftitle = $update['message']['forward_from_chat']['chat']['title']; // Titolo del canale da cui è stato inoltrato
$fusernamechat = $update['message']['forward_from_chat']['chat']['username']; // Username del canale da cui è stato inoltrato
}
}

# CallBack Query
if (isset($update["callback_query"])) {
$cbid = $update["callback_query"]["id"]; // ID della query
$cbdata = $update["callback_query"]["data"]; // Messaggio della query
$messageType = "callback_query";

# Informazioni Chat
$chat_id = $update["callback_query"]['message']['chat']['id'];  // ID del gruppo/canale
$typechat = $update["callback_query"]['message']['chat']['type']; // Tipo di chat (private, group, supergroup, channel)
if ($typechat !== "private") {
$title = $update["callback_query"]['message']['chat']['title']; // Titolo del gruppo/canale
$usernamechat = $update["callback_query"]['message']['chat']['username']; // Username del gruppo/canale
}

# Informazioni utente
if (isset($update['callback_query']['from'])) {
$exists_user = true;
$userID = $update['callback_query']['from']['id'];
$nome = $update['callback_query']['from']['first_name'];
$cognome = $update['callback_query']['from']['last_name'];
$username = $update['callback_query']['from']['username'];
$lingua = $update['callback_query']['from']['language_code'];
}

if (isset($update["callback_query"]["inline_message_id"])) { // CallBack per i messaggi inline
$cbmid = $update["callback_query"]["inline_message_id"]; // ID del messaggio mandato inline nella query
} else {
$cbmid = $update["callback_query"]["message"]["message_id"]; // ID del messaggio nella query
$chat_id = $update["callback_query"]["message"]["chat"]["id"]; // ID della Chat sulla query
}
}

# Media
if (isset($update["message"]["poll"])) {
$messageType = "poll";
$poll_id = $update["message"]["poll"]["id"]; // ID del sondaggio inviato
$p_titolo = $update["message"]["poll"]["question"]; // Domanda del sondaggio
$p_opzioni = $update["message"]["poll"]["options"]; // Opzioni da votare del sondaggio
$p_closed = $update["message"]["poll"]["is_closed"]; // Sondaggio chiuse/aperto
} elseif (isset($update["message"]["voice"])) {
$messageType = "voice";
$vocale = $update["message"]["voice"]["file_id"]; // ID del audio vocale inviato
} elseif (isset($update["message"]["animation"])) {
$messageType = "gif";
$gif = $update["message"]["animation"]["file_id"]; // ID della GIF inviata
} elseif (isset($update["message"]["photo"])) {
$messageType = "photo";
$foto = $update["message"]["photo"][0]["file_id"]; // ID della foto inviata a minima qualità
} elseif (isset($update["message"]["video"])) {
$video = $update["message"]["video"]['file_id']; // ID del video inviato
$messageType = "video";
} elseif (isset($update["message"]["video_note"])) {
$video_note = $update["message"]["video_note"]['file_id']; // ID del video rotondo inviato
$messageType = "video_note";
} elseif (isset($update["message"]["audio"])) {
$audio = $update["message"]["audio"]["file_id"]; // ID del file audio inviato
$messageType = "audio";
} elseif (isset($update["message"]["location"])) {
$messageType = "location";
$posizione = $update["message"]['location']; // Posizione del GPS inviata
} elseif (isset($update["message"]["sticker"])) {
$messageType = "sticker";
$s_setname = $update["message"]["sticker"]["set_name"]; // Nome del Pacchetto Sticker
$sticker = $update["message"]["sticker"]["file_id"]; // ID dello Sticker inviato
$is_animated = $update["message"]["sticker"]["is_animated"]; // Definisce se è una sticker animata o meno
if ($is_animated) {
$messageType = "animated sticker";
}
$s_emoji = $update["message"]["sticker"]["emoji"]; // Emoji attribuito allo Sticker inviato
$s_x = $update["message"]["sticker"]["width"]; // Larghezza dell'immagine Sticker
$s_y = $update["message"]["sticker"]["height"]; // Altezza dell'immagine Sticker
$s_bytes = $update["message"]["sticker"]["file_size"]; // Peso dello Sticker espresso in byte
} elseif (isset($update["message"]["contact"])) {
$messageType = "contact";
$contact = $update['message']['contact']['phone_number']; // Numero del contatto
$cnome = $update['message']['contact']['first_name']; // Nome del Contatto
$ccognome = $update['message']['contact']['last_name']; // Cognome del Contatto
$cuserID = $update['message']['contact']['user_id']; // ID dell'utente del contatto
} elseif (isset($update["message"]["venue"])) {
$messageType = "venue";
$venue = true;
$posto = $update['message']['venue']['title']; // Titolo della posizione
$address = $update['message']['venue']['address']; // Indirizzo della posizione
$posizione = $update['message']['venue']['location']; // Posizione del GPS inviata
} elseif (isset($update["message"]["document"])) {
$messageType = "document";
$file = $update["message"]["document"]["file_id"]; // ID del file inviato
} elseif (isset($update["inline_query"])) {
$messageType = "inline";
$chat_id = $userID = $update["inline_query"]["from"]["id"];
$nome = $update["inline_query"]["from"]["first_name"];
$cognome = $update["inline_query"]["from"]["last_name"];
$username = $update["inline_query"]["from"]["username"];
$lingua = $update["inline_query"]["from"]["language_code"];
$exists_user = true;
$inline = true;
} else {
$messageType = "text message";
}

if (in_array($text[0], $config['operatori_comandi'])) {
    $messageType = "command";
    $cmd = substr($text, 1, strlen($text));
    $cmd = str_replace("@" . $config['userbot'], '', $cmd); // Fix del Tag al Bot nei gruppi
}
