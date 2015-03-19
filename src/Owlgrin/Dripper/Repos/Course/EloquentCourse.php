<?php namespace Owlgrin\Dripper\Repos\Course;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Carbon\Carbon;

use Owlgrin\Dripper\Models\Course;
use Owlgrin\Dripper\Exceptions;

class EloquentCourse implements CourseInterface {

	public function find($id)
	{
		try
		{
			return Course::findOrFail($id);
		}
		catch(ModelNotFoundException $e)
		{
			throw new Exceptions\NotFoundException('Course not found.');
		}
		catch(\Exception $e)
		{
			throw new Exceptions\InternalException;
		}
	}

	public function all()
	{
		try
		{
			return Course::get();
		}
		catch(\Exception $e)
		{
			throw new Exceptions\InternalException;
		}
	}

	public function store($name)
	{
		try
		{
			return Course::create(array(
				'name' => $name,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			));
		}
		catch(MassAssignmentException $e)
		{
			throw $e;
		}
		catch(\Exception $e)
		{
			throw new Exceptions\InternalException;
		}
	}
}