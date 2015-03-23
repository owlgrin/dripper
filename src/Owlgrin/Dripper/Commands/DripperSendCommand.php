<?php namespace Owlgrin\Dripper\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Owlgrin\Dripper\Repos\Subscriber\SubscriberInterface;
use Owlgrin\Dripper\Models\Subscriber;
use Owlgrin\Dripper\Mailers\DripperMailer;

use Config;

class DripperSendCommand extends Command {

	/**
	 * Instance of hold subscriber repository
	 *
	 * @var Owlgrin\Dripper\Repos\Subscriber\SubscriberInterface
	 */
	protected $subscriberRepo;

	/**
	 * Instance to hold course mailer
	 *
	 * @var Owlgrin\Dripper\Mailers\DripperMailer
	 */
	protected $dripperMailer;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'dripper:send';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send the lesson of the course due for the day.';

	/**
	 * Create a new command instance
	 * @param SubscriberInterface $subscriberRepo
	 * @param DripperMailer        $dripperMailer
	 */
	public function __construct(SubscriberInterface $subscriberRepo, DripperMailer $dripperMailer)
	{
		$this->subscriberRepo = $subscriberRepo;
		$this->dripperMailer = $dripperMailer;
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$subscribers = $this->subscriberRepo->forToday();

		$sender = Config::get('dripper::sender');

		foreach($subscribers as $index => $subscriber)
		{
			$this->info('Sending to: ' . $subscriber->name . ' - ' . $subscriber->email . '(' . $subscriber->next_lesson->name . ')');

			$recipient = $this->getRecipients($subscriber);

			$unsubscribeLink = $this->getUnsubscribeLink($subscriber);

			$this->dripperMailer
				->to($recipient)
				->from($sender)
				->lesson(compact('recipient', 'unsubscribeLink'), $subscriber->next_lesson->view, $subscriber->next_lesson->name)
				->send();

			$this->subscriberRepo->updateNextLesson($subscriber->id);
		}
	}

	private function getRecipients(Subscriber $subscriber)
	{
		return array_only($subscriber->toArray(), array('name', 'email'));;
	}

	private function getUnsubscribeLink(Subscriber $subscriber)
	{
		return Config::get('dripper::url') . '/unsubscribe/' . $subscriber->id . '/' . $subscriber->secret_key;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			// array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			// array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
