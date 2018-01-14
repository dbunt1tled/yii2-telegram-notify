Telegram Notify Trigger
=======================
Send Notify Trigger All Contacts

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist dbunt1tled/yii2-telegram-notify "*"
```

or add

```
"dbunt1tled/yii2-telegram-notify": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?php
    $client = new yii\httpclient\Client();
    $botTelegram = new TelegramNotify($tokenYourBot,$client);
    $botTelegram->sendMessage('Всем привет'); 
?>
```