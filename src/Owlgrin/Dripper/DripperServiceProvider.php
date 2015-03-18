<?php namespace Owlgrin\Dripper;

use Illuminate\Support\ServiceProvider;

class DripperServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Owlgrin\Dripper\Repos\Subscriber\SubscriberInterface', 'Owlgrin\Dripper\Repos\Subscriber\EloquentSubscriber');

		$this->app->bind('Owlgrin\Dripper\Repos\Course\CourseInterface', 'Owlgrin\Dripper\Repos\Course\EloquentCourse');

		$this->app->bind('Owlgrin\Dripper\Repos\Lesson\LessonInterface', 'Owlgrin\Dripper\Repos\Lesson\EloquentLesson');

		// binding the command to generate the tables
		$this->app->bindShared('command.dripper.table', function($app)
		{
			return $app->make('Owlgrin\Dripper\Commands\DripperTableCommand');
		});

		// binding the command to send dripper course mail.
		$this->app->bindShared('command.dripper.send', function($app)
		{
			return $app->make('Owlgrin\Dripper\Commands\DripperSendCommand');
		});

		// binding the command to add dripper course.
		$this->app->bindShared('command.dripper.course', function($app)
		{
			return $app->make('Owlgrin\Dripper\Commands\AddDripperCourseCommand');
		});

		// binding the command to subscribe in dripper.
		$this->app->bindShared('command.dripper.subscribe', function($app)
		{
			return $app->make('Owlgrin\Dripper\Commands\DripperSubscribeCommand');
		});

		// binding the command to unsubscribe from dripper.
		$this->app->bindShared('command.dripper.unsubscribe', function($app)
		{
			return $app->make('Owlgrin\Dripper\Commands\DripperUnsubscribeCommand');
		});

		//	telling laravel what we are providing to the app using the package
		$this->commands('command.dripper.table');
		$this->commands('command.dripper.send');
		$this->commands('command.dripper.course');
		$this->commands('command.dripper.subscribe');
		$this->commands('command.dripper.unsubscribe');

		// we will bind as singleton as we want just one instance of the package
		// throughout the processing of whole request
		$this->app->singleton('dripper', 'Owlgrin\Dripper\Dripper');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

	public function boot()
	{
		$this->package('owlgrin/dripper');
	}

}
