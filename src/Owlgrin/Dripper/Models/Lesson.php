<?php namespace Owlgrin\Dripper\Models;

use Carbon\Carbon;
use Eloquent;
use Config;

class Lesson extends Eloquent {

	protected $fillable = array('course_id', 'sequence', 'name', 'view', 'interval');

	public function course()
	{
		return $this->belongsTo('Owlgrin\Dripper\Models\Course');
	}

	public function nextOn()
	{
		return Carbon::today()->addDays($this->interval);
	}

	public function getTable()
	{
		return Config::get('dripper::tables.lessons');
	}
}