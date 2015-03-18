<?php namespace Owlgrin\Dripper\Repos\Lesson;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\MassAssignmentException;

use Carbon\Carbon;

use Owlgrin\Dripper\Models\Lesson;
use Owlgrin\Dripper\Models\Course;
use Owlgrin\Dripper\Exceptions;

class EloquentLesson implements LessonInterface {

	public function find($id)
	{
		try
		{
			return Lesson::findOrFail($id);
		}
		catch(ModelNotFoundException $e)
		{
			throw new Exceptions\NotFoundException('Lesson not found.');
		}
		catch(\Exception $e)
		{
			throw new Exceptions\InternalException;
		}
	}

	public function store(Course $course, $lesson)
	{
		try
		{
			return Lesson::create(array(
				'course_id' => $course->id,
				'sequence' => $lesson['sequence'],
				'name' => $lesson['name'],
				'view' => $lesson['view'],
				'interval' => $lesson['interval'],
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			));
		}
		catch(MassAssignmentException $e)
		{
			throw new Exceptions\InvalidInputException('Invalid input data.');
		}
		catch(\Exception $e)
		{
			dd($e->getMessage());
			throw new Exceptions\InternalException;
		}
	}
}