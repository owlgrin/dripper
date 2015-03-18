<?php namespace Owlgrin\Dripper\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Dripper;

class DripperUnsubscribeCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'dripper:unsubscribe';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'To unsubscribe an user of Dripper.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info('Unubscribing user in Dripper...');

		$subscriberId = $this->argument('id');
		$subscriberKey = $this->argument('key');

		Dripper::unsubscribe($subscriberId, $subscriberKey);

		$this->info('User unsubscribed successfully in Dripper...');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('id', InputArgument::REQUIRED, 'Dripper subscriber ID to be unsubscribed.'),
			array('key', InputArgument::REQUIRED, 'Dripper subscriber secret key to be unsubscribed.')
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
