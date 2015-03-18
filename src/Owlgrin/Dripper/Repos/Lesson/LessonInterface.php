<?php namespace Owlgrin\Dripper\Repos\Lesson;

use Owlgrin\Dripper\Models\Course;

interface LessonInterface {
	public function find($id);
	public function store(Course $course, $lesson);
}