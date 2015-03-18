<?php namespace Owlgrin\Dripper;

use Owlgrin\Dripper\Repos\Subscriber\SubscriberInterface;

class Dripper {

	protected $subscriberRepo;

	public function __construct(SubscriberInterface $subscriberRepo)
	{
		$this->subscriberRepo = $subscriberRepo;
	}

	public function subscribe($name, $email, $course, $isActive = true, $nextLesson = null)
	{
		return $this->subscriberRepo->subscribe($name, $email, $course, $isActive = true, $nextLesson = null);
	}

	public function unsubscribe($id, $key)
	{
		return $this->subscriberRepo->unsubscribe($id, $key);
	}
}