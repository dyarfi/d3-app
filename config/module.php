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
	    		'Admin' => [
		       		// Controller
		       		'Controller' => '',
		       		// Model
		       		'Model' => ''
		       	],
		       	'Banner' => [
		       		// Controller
		       		'Controller' => ['Banners'],
		       		// Model
		       		'Model' => ['Banner']
		       	],
		       	'Blog' => [
		       		// Controller
		       		'Controller' => ['Blogs','BlogCategories'],
		       		// Model
		       		'Model' => ['Blog','BlogCategory']
		       	],
		       	'Career' => [
		       		// Controller
		       		'Controller' => ['Applicants','Careers','Divisions'],
		       		// Model
		       		'Model' => ['Applicant','Career','Division']
		       	],
		       	'Contact' => [
		       		// Controller
		       		'Controller' => ['Contacts'],
		       		// Model
		       		'Model' => ['Contact']
		       	],
		       	//'Employee' => [
		       		// Controller
		       		//'Controller' => ['Employees'],
		       		// Model
		       		//'Model' => ''
		       	//],
		       	'Page' => [
		       		// Controller
		       		'Controller' => ['Menus','Pages'],
		       		// Model
		       		'Model' => ['Menu','Page']
		       	],
		       	'Participant' => [
		       		// Controller
		       		'Controller' => ['Participants','Images'],
		       		// Model
		       		'Model' => ['Participant']
		       	],
		       	'Portfolio' => [
		       		// Controller
		       		'Controller' => ['Portfolios','Projects','Clients'],
		       		// Model
		       		'Model' => ['Portfolio','Project','Client']
		       	],
		       	'Task' => [
		       		// Controller
		       		'Controller' => ['Task'],
		       		// Model
		       		'Model' => ''
		       	],
		       	'User' => [
		       		// Controller
		       		'Controller' => ['Users','Roles','Teams','Settings'],
		       		// Model
		       		'Model' => ['User','Role','Team','RoleUser','Setting']
		       	]
	    ]
	];
