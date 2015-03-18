<?php namespace Owlgrin\Dripper\Mailers;

class DripperMailer extends Mailer {

	public function lesson($data, $view, $subject)
	{
		$this->view = $view;
		$this->data = $data;
		$this->subject = $subject;

		return $this;
	}
}