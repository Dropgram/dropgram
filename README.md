<p align="center">
    <a href="https://github.com/Dropgram/dropgram">
        <img src="https://i.imgur.com/IFOMh1L.png" alt="Dropgram">
    </a>
  <br>
a basic php framework for newbie bot developers

# get started
1) set webhook

# creating a command
1) create a file called command.php
2) insert this code
```php
<?php
require_once 'functions.php';
$dropgram = new dropgram();
```

3) in order to create your first command use this syntax

```php
if(stripos($cmd, 'command')===0)
{
$dropgram->sm($chat_id, "hello");
}
```
