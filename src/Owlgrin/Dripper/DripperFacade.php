<?php namespace Owlgrin\Dripper;

use Illuminate\Support\Facades\Facade;

/**
 * The Dripper Facade
 */
class DripperFacade extends Facade
{
	/**
	 * Returns the binding in IoC container
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'dripper';
	}
}