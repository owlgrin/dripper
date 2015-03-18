<?php namespace Owlgrin\Dripper\Repos\Subscriber;

interface SubscriberInterface {
	public function find($id);
	public function all();
	public function forToday();
	public function subscribe($name, $email, $course, $isActive, $nextLesson);
	public function unsubscribe($id, $key);
	public function unsubscribeWithoutKey($id);
	public function updateNextLesson($id);
}