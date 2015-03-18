<?php namespace Owlgrin\Dripper\Repos\Course;

interface CourseInterface {
	public function find($id);
	public function all();
	public function store($name);
}