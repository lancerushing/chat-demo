<?php


class Message {
	public $name, $message;

	public function __construct($name, $message) {
		$this->name = $name;
		$this->message = $message;
	}
}