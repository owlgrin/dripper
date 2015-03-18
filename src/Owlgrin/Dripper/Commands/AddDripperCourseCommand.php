<?php namespace Owlgrin\Dripper\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Owlgrin\Dripper\Repos\Course\CourseInterface;
use Owlgrin\Dripper\Repos\Lesson\LessonInterface;

class AddDripperCourseCommand extends Command {

	/**
	 * Instance of hold subscriber repository
	 *
	 * @var Owlgrin\Dripper\Repos\Course\CourseInterface
	 */
	protected $courseRepo;

	/**
	 * Instance to hold course mailer
	 *
	 * @var Owlgrin\Dripper\Repos\Lesson\LessonInterface
	 */
	protected $lessonRepo;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'dripper:add-course';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send the lesson of the course due for the day.';

	/**
	 * Create a new command instance
	 * @param CourseInterface $courseRepo
	 * @param LessonInterface $lessonRepo
	 */
	public function __construct(CourseInterface $courseRepo, LessonInterface $lessonRepo)
	{
		$this->courseRepo = $courseRepo;
		$this->lessonRepo = $lessonRepo;
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info('Adding course in database...');

		$input = json_decode($this->argument('course'), true);

		$course = $this->courseRepo->store($input['name']);

		foreach($input['lessons'] as $key => $lesson)
		{
			$this->lessonRepo->store($course, $lesson);
		}
		$this->info('Course added successfully in database...');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('course', InputArgument::REQUIRED, 'Json object of course to be added.'),
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
