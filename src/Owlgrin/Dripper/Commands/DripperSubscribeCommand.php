<?php namespace Owlgrin\Dripper\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Dripper;

class DripperSubscribeCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'dripper:subscribe';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'To subscribe an user in Dripper.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info('Subscribing user in Dripper...');

		$name = $this->argument('name');
		$email = $this->argument('email');
		$course = $this->argument('course');

		Dripper::subscribe($name, $email, $course);

		$this->info('User subscribed successfully in Dripper...');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('name', InputArgument::REQUIRED, 'Name of the user to be subscribed.'),
			array('email', InputArgument::REQUIRED, 'Email of the user to be subscribed.'),
			array('course', InputArgument::REQUIRED, 'Course ID of the dripper course.')
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
