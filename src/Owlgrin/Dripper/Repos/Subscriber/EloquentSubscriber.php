<?php namespace Owlgrin\Dripper\Repos\Subscriber;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\MassAssignmentException;

use Carbon\Carbon;

use Owlgrin\Dripper\Models\Subscriber;
use Owlgrin\Dripper\Exceptions;
use Owlgrin\Dripper\Repos\Lesson\LessonInterface;
use Owlgrin\Dripper\Repos\Course\CourseInterface;

class EloquentSubscriber implements SubscriberInterface {

	protected $courseRepo;
	protected $lessonRepo;

	public function __construct(CourseInterface $courseRepo, LessonInterface $lessonRepo)
	{
		$this->courseRepo = $courseRepo;
		$this->lessonRepo = $lessonRepo;
	}

	public function find($id)
	{
		try
		{
			return Subscriber::findOrFail($id);
		}
		catch(ModelNotFoundException $e)
		{
			throw new Exceptions\NotFoundException('Subscriber not found.');
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
			return Subscriber::with('course')->with('next_lesson')->get();
		}
		catch(\Exception $e)
		{
			throw new Exceptions\InternalException;
		}
	}

	public function forToday()
	{
		try
		{
			return Subscriber::with('course')->with('next_lesson')->active()->forToday()->get();
		}
		catch(\Exception $e)
		{
			throw new Exceptions\InternalException;
		}
	}

	public function subscribe($name, $email, $course, $isActive = true, $nextLesson = null)
	{
		try
		{
			$nextLesson = is_null($nextLesson)
				? $this->courseRepo->find($course)->firstLesson()
				: $this->lessonRepo->find($nextLesson);

			return Subscriber::create(array(
				'name' => $name,
				'email' => $email,
				'course_id' => $course,
				'secret_key' => md5(str_random(11)),
				'is_active' => $isActive,
				'next_lesson_id' => $nextLesson->id,
				'next_lesson_on' => $nextLesson->nextOn(),
				'unsubscribed_at' => null
			));
		}
		catch(Exceptions\NotFoundException $e)
		{
			throw $e;
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

	public function unsubscribe($id, $key)
	{
		try
		{
			$subscriber = Subscriber::where('id', $id)
				->where('secret_key', $key)
				->first();
			if( ! $subscriber) throw new Exceptions\NotFoundException('Subscriber not found');

			$subscriber->is_active = false;
			$subscriber->unsubscribed_at = Carbon::now();
			$subscriber->save();

			return $subscriber;
		}
		catch(Exceptions\NotFoundException $e)
		{
			throw $e;
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

	public function unsubscribeWithoutKey($id)
	{
		try
		{
			$subscriber = $this->find($id);

			$subscriber->is_active = false;
			$subscriber->unsubscribed_at = Carbon::now();
			$subscriber->save();

			return $subscriber;
		}
		catch(Exceptions\NotFoundException $e)
		{
			throw $e;
		}
		catch(MassAssignmentException $e)
		{
			throw new Exceptions\InvalidInputException('Invalid input data.');
		}
		catch(\Exception $e)
		{
			throw new Exceptions\InternalException;
		}
	}

	public function updateNextLesson($id)
	{
		try
		{
			$subscriber = Subscriber::with('course')->with('next_lesson')->find($id);
			if( ! $subscriber) throw new Exceptions\NotFoundException('Subscriber not found');

			$nextLesson = $subscriber->nextLesson();
			$subscriber->next_lesson_id = $nextLesson ? $nextLesson->id : null;
			$subscriber->next_lesson_on = $nextLesson ? $nextLesson->nextOn() : null;
			$subscriber->completed_at = is_null($nextLesson) ? Carbon::now() : null; // if there's no next lesson to schedule, we will mark it as completed
			$subscriber->save();

			return $subscriber;
		}
		catch(Exceptions\NotFoundException $e)
		{
			throw $e;
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