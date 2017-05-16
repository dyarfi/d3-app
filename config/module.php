<?php

	/*
	|--------------------------------------------------------------------------
	| Administrator panel settings
	|--------------------------------------------------------------------------
	|
	| Change this settings to desire name and defaults
	| this will be the url for administration CMS
	|
	|
	*/
	# config/module.php

	return  [
	    'modules' => [
	    		'Auth' => [
		       		// Controller
		       		'Controller' => '',
		       		// Model
		       		'Model' => ''
		       	],
		       	'User' => [
		       		// Controller
		       		'Controller' => ['Users','Roles','Settings'],
		       		// Model
		       		'Model' => ['User','Role','RoleUser','Setting']
		       	],
		       	'Page' => [
		       		// Controller
		       		'Controller' => ['Menus','Pages'],
		       		// Model
		       		'Model' => ['Menu','Page']
		       	],
		       	'Banner' => [
		       		// Controller
		       		'Controller' => ['Banners'],
		       		// Model
		       		'Model' => ['Banner']
		       	],
		       	'Task' => [
		       		// Controller
		       		'Controller' => ['Task'],
		       		// Model
		       		'Model' => ''
		       	],
		       	'Employee' => [
		       		// Controller
		       		'Controller' => ['Employees'],
		       		// Model
		       		'Model' => ''
		       	],
		       	'Career' => [
		       		// Controller
		       		'Controller' => ['Applicants','Careers','Divisions'],
		       		// Model
		       		'Model' => ['Applicant','Career','Division']
		       	],
		       	'Participant' => [
		       		// Controller
		       		'Controller' => ['Participants','Images'],
		       		// Model
		       		'Model' => ['Participant']
		       ]
	    ]
	];
