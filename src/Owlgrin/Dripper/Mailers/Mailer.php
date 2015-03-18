<?php namespace Owlgrin\Dripper\Mailers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

abstract class Mailer {
	public $from;
	public $to;
	public $email;
	public $subject;
	public $view;
	public $data;
	public $attachments;
	public $metadata;
	public $options;

	public function __construct()
	{
		$this->from = null;
		$this->attachments = array();
		$this->metadata = array();
		$this->options = null;
	}

	public function to($user)
	{
		$this->to = isset($user['name']) ? $user['name'] : '';
		$this->email = $user['email'];

		return $this;
	}

	public function from($sender)
	{
		$this->from = $sender;

		return $this;
	}

	public function metadata(array $metadata)
	{
		$this->metadata = json_encode($metadata);

		return $this;
	}

	public function send()
	{
		$self = $this;
		Mail::queue($this->view, $this->data, function($message) use($self)
		{
			$message->to($self->email, $self->to)->subject($self->subject);

			if(! is_null($self->from))
			{
				$message->from($self->from['email'], $self->from['name']);
			}

			if( ! empty($self->metadata))
			{
				$message->getHeaders()->addTextHeader('X-MC-Metadata', $self->metadata);
			}

			foreach($self->attachments as $attachment)
			{
				if($attachment['type'] == 'data')
					$message->attachData($attachment['content'], $attachment['name'], array('as' => $attachment['name'], 'mime' => $attachment['mime']));
				if($attachment['type'] == 'file')
					$message->attach($attachment['content'], array('as' => $attachment['name'], 'mime' => $attachment['mime']));
			}

			if(is_callable($self->options))
			{
				call_user_func($self->options, $message);
			}
		});
	}
}