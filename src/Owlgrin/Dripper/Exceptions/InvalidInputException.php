<?php namespace Owlgrin\Dripper\Exceptions;

class InvalidInputException extends \Exception {

	const MESSAGE = 'Invalid input';

	public function __construct($message = null)
	{
		parent::__construct($message ?: self::MESSAGE);
	}
}