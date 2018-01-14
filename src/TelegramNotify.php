<?php
/**
 * Created by PhpStorm.
 * User: dbunt1tled
 * Date: 14.01.18
 * Time: 10:09
 *
 * Send All Contacts Message
 * $client = new yii\httpclient\Client();
 * $botTelegram = new TelegramNotify('512991499:AAFLnQSxee321ZrXAm8D8BikkeO4G7hO_Js',$client);
 * $botTelegram->sendMessage('Всем привет');
 *
 * @property string $_url Урл API Telegram
 * @property string $url Готовый Урл API Telegram
 * @property string $token Токен бота
 * @property mixin $client Клиент отправки запросов
 * @property mixin $bot Клиент отправки запросов
 *
 */

namespace dbunt1tled\telegramNotify;

use yii\httpclient\Client;

class TelegramNotify
{
	private $_url = 'https://api.telegram.org/';
	private $url = null;
	private $token = null;
	private static $client = null;
	private static $bot = null;
	public function __construct($token = null,Client $client = null) {
		$this->token = $token;
		$this->setUrl();
		if(is_null(self::$client)){
			self::$client = $client;
		}
		if(is_null(self::$bot)){
			$this->getMe();
		}
	}

	/**
	 * @return null
	 */
	public function getToken() {
		return $this->token;
	}

	/**
	 * @param string $token
	 */
	public function setUrl( $token = '' ) {
		if(is_null($token)){
			$this->url = $this->_url.'bot'.$this->token.'/';
		}else{
			$this->url = $this->_url.'bot'.$token.'/';
		}

	}

	public function sendMessage($message){
		$botData = $this->getUpdates();
		foreach ($botData as $data){
			self::$client->createRequest()
			             ->setMethod('post')
			             ->setUrl($this->url.'sendMessage')
			             ->setData([
				             'chat_id' => $data['message']['chat']['id'],
				             'text' => $message,
			             ])
			             ->send();
		}
	}

	/**
	 * @return mixin
	 *
	 */
	public function getMe() {
		$response = self::$client->createRequest()
		                         ->setMethod('post')
		                         ->setUrl($this->url.'getMe')
		                         ->setData([])
		                         ->send();

		if ($response->isOk) {
			return self::$bot = $response->data['result'];
		}else{
			throw new \DomainException('Телеграм Бот: не найден бот');
		}
	}

	/**
	 * @return mixin
	 *
	 */
	public function getUpdates() {
		$response = self::$client->createRequest()
		                         ->setMethod('post')
		                         ->setUrl($this->url.'getUpdates')
		                         ->setData([])
		                         ->send();

		if ($response->isOk) {
			return $response->data['result'];
		}else{
			throw new \DomainException('Телеграм Бот: данные не найдены');
		}
	}
}