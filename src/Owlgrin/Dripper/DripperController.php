<?php namespace Owlgrin\Dripper;

use BaseController;
use View;
use Dripper;

/**
 * Dripper Controller
 */
class DripperController extends BaseController {

	public function unsubscribe($id, $key)
	{
		try
		{
			Dripper::unsubscribe($id, $key);

			return View::make('dripper.unsubscribe.success');
		}
		catch(\Exception $e)
		{
			return View::make('dripper.unsubscribe.error');
		}
	}
}