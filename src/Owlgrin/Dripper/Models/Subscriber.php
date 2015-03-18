<?php namespace Owlgrin\Dripper\Models;

use Carbon\Carbon;
use Eloquent;
use Config;

class Subscriber extends Eloquent {

	protected $fillable = array('name', 'email', 'course_id', 'secret_key', 'is_active', 'next_lesson_id', 'next_lesson_on');

	public function course()
	{
		return $this->belongsTo('Owlgrin\Dripper\Models\Course');
	}

	public function next_lesson()
	{
		return $this->hasOne('Owlgrin\Dripper\Models\Lesson', 'id', 'next_lesson_id');
	}

	public function nextLesson()
	{
		return $this->course->lesson($this->next_lesson->sequence + 1);
	}

	public function scopeActive($query)
	{
		return $query->where('is_active', true);
	}

	public function scopeForToday($query)
	{
		return $query->where('next_lesson_on', Carbon::today()->toDateString());
	}

	public function getTable()
	{
		return Config::get('dripper::tables.subscribers');
	}
}