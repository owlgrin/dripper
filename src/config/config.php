<?php

return array(

	'sender' => array(
		/**
		*	Sender name to be mentioned in the dripper mails.
		*/
		'name' => 'Sender-Name',

		/**
		* Sender email to be used for sending dripper mails.
		*/
		'email' => 'Sender-Email'
	),

	'tables' => array(
		/**
		 * This table is required to keep track of the
		 * dripper subscribers.
		 */
		'subscribers' => '_dripper_subscribers',
		/**
		 * This table is required to keep track of the
		 * dripper courses.
		 */
		'courses' => '_dripper_courses',
		/**
		 * This table is required to keep track of the
		 * dripper lessons.
		 */
		'lessons' => '_dripper_lessons'
	)
);