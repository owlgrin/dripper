<?php namespace Owlgrin\Dripper\Exceptions;

class NotFoundException extends \Exception {

	const MESSAGE = 'Not found';

	public function __construct($message = null)
	{
		parent::__construct($message ?: self::MESSAGE);
	}
}