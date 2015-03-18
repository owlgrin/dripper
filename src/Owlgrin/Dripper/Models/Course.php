<?php namespace Owlgrin\Dripper\Models;

use Eloquent;
use Config;

class Course extends Eloquent {

	protected $fillable = array('name');

	protected function lessons()
	{
		return $this->hasMany('Owlgrin\Dripper\Models\Lesson');
	}

	protected function subscribers()
	{
		return $this->hasMany('Owlgrin\Dripper\Models\Subscriber');
	}

	public function firstLesson()
	{
		return $this->lesson(1);
	}

	public function lesson($sequence)
	{
		return $this->lessons()->where('sequence', $sequence)->first();
	}

	public function getTable()
	{
		return Config::get('dripper::tables.courses');
	}
}