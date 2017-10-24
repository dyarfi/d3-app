<?php

return [

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

	// Company name default
	'company_name'	=> 'Company Name',

	// Administrator label name
	'admin_app' => 'Admin Panel',

	// Administrator url
	'admin_url' => 'admin-panel',

	/*
	 |--------------------------------------------------------------------------
	 | Access Controller Lists in administrator panel modules
	 |--------------------------------------------------------------------------
	 |
	 | Modify or add new configuration
	 | Always add new array [action],[controller] for registering new controller
	 |
	 */

	'modules' => [
				// Admin modules will be in the App Modules directory
				['Admin' => [
						//------ Admin users controller @ see ModuleServiceProviders for flagged User Module
						['Users' => [
								// Action for first index
								'action' => ['users.index'],
								// Controller method list
								'method' => ['users.index','users.edit','users.update','users.change','users.create','users.trash','users.delete','users.restored','users.store','users.show','users.export','users.dashboard'],
							]
						],
						//------ Admin roles controller
						['Roles' => [
								// Action for first index
								'action' => ['roles.index'],
								// Controller method list
								'method' => ['roles.index','roles.edit','roles.update','roles.change','roles.create','roles.trash','roles.delete','roles.restored','roles.store','roles.show']
							]
						],
						//------ User teams controller
						['Teams' => [
								// Action for first index
								'action' => ['teams.index'],
								// Controller method list
								'method' => ['teams.index','teams.edit','teams.update','teams.change','teams.create','teams.delete','teams.restored','teams.trash','teams.store','teams.show','teams.invite','teams.invitation','teams.attach','teams.detach']
							]
						],
						//------ Admin permissions controller
						['Permissions' => [
								// Action for first index
								'action' => ['permissions.index'],
								// Controller method list
								'method' => ['permissions.index','permissions.edit','permissions.create','permissions.store','permissions.change','permissions.show']
							]
						],
						//------ Admin settings controller
						['Settings' => [
								// Action for first index
								'action' => ['settings.index'],
								// Controller method list
								'method' => ['settings.index','settings.edit','settings.update','settings.create','settings.store','settings.trash','settings.delete','settings.restored','settings.show','settings.change']
							]
						],
						//------ Admin logs controller
						['Logs' => [
								// Action for first index
								'action' => ['logs.index'],
								// Controller method list
								'method' => ['logs.index','logs.edit','logs.create','logs.store','logs.export','logs.show']
							]
						]
					]
				],
				// Pages modules will be in the App Modules directory
				['Page' => [
						//------ Pages controller
						['Pages' => [
								// Action for first index
								'action' => ['pages.index'],
								// Controller method list
								'method' => ['pages.index','pages.edit','pages.update','pages.change','pages.create','pages.store','pages.show'],
							]
						],
						//------ Menus controller
						['Menus' => [
								// Action for first index
								'action' => ['menus.index'],
								// Controller method list
								'method' => ['menus.index','menus.edit','menus.update','menus.change','menus.create','menus.store','menus.show'],
							]
						],
					]
				],
				// Banner modules will be in the App Modules directory
				['Banner' => [
						//------ Banners controller
						['Banners' => [
								// Action for first index
								'action' => ['banners.index'],
								// Controller method list
								'method' => ['banners.index','banners.edit','banners.update','banners.change','banners.create','banners.store','banners.trash','banners.delete','banners.restored','banners.show','banners.datatable','banners.export']
							]
						]
					]
				],
				// Blog modules will be in the App Modules directory
				['Blog' => [
						//------ Blog controller
						['Blogs' => [
								// Action for first index
								'action' => ['blogs.index'],
								// Controller method list
								'method' => ['blogs.index','blogs.edit','blogs.update','blogs.change','blogs.create','blogs.store','blogs.trash','blogs.delete','blogs.restored','blogs.show','blogs.tags','blogs.tags.show','blogs.datatable','blogs.export']
							]
						],
						//------ Blog Category controller
						['Category' => [
								// Action for first index
								'action' => ['blogcategories.index'],
								// Controller method list
								'method' => ['blogcategories.index','blogcategories.edit','blogcategories.update','blogcategories.change','blogcategories.create','blogcategories.store','blogcategories.trash','blogcategories.delete','blogcategories.restored','blogcategories.show','blogcategories.datatable','blogcategories.export']
							]
						]
					]
				],
				// Tasks modules will be in the App Modules directory
				['Task' => [
						//------ Tasks controller
						['Tasks' => [
								// Action for first index
								'action' => ['tasks.index'],
								// Controller method list
								'method' => ['tasks.index','tasks.edit','tasks.update','tasks.change','tasks.create','tasks.store','tasks.trash','tasks.delete','tasks.restored','tasks.show']
							]
						]
					]
				],
				// Career modules will be in the App Modules directory
				['Career' => [
						//------ Career controller
						['Careers' => [
								// Action for first index
								'action' => ['careers.index'],
								// Controller method list
								'method' => ['careers.index','careers.edit','careers.update','careers.change','careers.create','careers.store','careers.trash','careers.delete','careers.restored','careers.show']
							]
						],
						//------ Division controller
						['Divisions' => [
								// Action for first index
								'action' => ['divisions.index'],
								// Controller method list
								'method' => ['divisions.index','divisions.edit','divisions.update','divisions.change','divisions.create','divisions.store','divisions.trash','divisions.delete','divisions.restored','divisions.show']
							]
						],
						//------ Applicant controller
						['Applicants' => [
								// Action for first index
								'action' => ['applicants.index'],
								// Controller method list
								'method' => ['applicants.index','applicants.edit','applicants.update','applicants.change','applicants.create','applicants.store','applicants.trash','applicants.delete','applicants.restored','applicants.show']
							]
						]
					]
				],
				// Contact modules will be in the App Modules directory
				['Contact' => [
						//------ Contact controller
						['Contacts' => [
								// Action for first index
								'action' => ['contacts.index'],
								// Controller method list
								'method' => ['contacts.index','contacts.edit','contacts.update','contacts.change','contacts.create','contacts.store','contacts.trash','contacts.delete','contacts.restored','contacts.show','contacts.datatable','contacts.export']
							]
						]
					]
				],
				// Participant modules will be in the App Modules directory
				['Participant' => [
						//------ Participants controller
						['Participants' => [
								// Action for first index
								'action' => ['participants.index'],
								// Controller method list
								'method' => ['participants.index','participants.edit','participants.update','participants.change','participants.create','participants.store','participants.trash','participants.delete','participants.restored','participants.show','participants.datatable','participants.export']
							]
						],
						//------ Participant Images controller
						['Images' => [
								// Action for first index
								'action' => ['images.index'],
								// Controller method list
								'method' => ['images.index','images.edit','images.update','images.change','images.create','images.store','images.trash','images.delete','images.restored','images.show']
							]
						]
					]
				],
				// Portfolio modules will be in the App Modules directory
				['Portfolio' => [
						//------ Clients controller
						['Clients' => [
								// Action for first index
								'action' => ['clients.index'],
								// Controller method list
								'method' => ['clients.index','clients.edit','clients.update','clients.change','clients.create','clients.store','clients.trash','clients.delete','clients.restored','clients.show','clients.datatable','clients.export']
							]
						],
						//------ Projects controller
						['Projects' => [
								// Action for first index
								'action' => ['projects.index'],
								// Controller method list
								'method' => ['projects.index','projects.edit','projects.update','projects.change','projects.create','projects.store','projects.trash','projects.delete','projects.restored','projects.show','projects.datatable','projects.export']
							]
						],
						//------ Portfolios controller
						['Portfolios' => [
								// Action for first index
								'action' => ['portfolios.index'],
								// Controller method list
								'method' => ['portfolios.index','portfolios.edit','portfolios.update','portfolios.change','portfolios.create','portfolios.store','portfolios.trash','portfolios.delete','portfolios.restored','portfolios.show','portfolios.tags','portfolios.tags.show','portfolios.datatable','portfolios.export']
							]
						]
					]
				]

	 ],


 	/*
	 |--------------------------------------------------------------------------
	 | Users attributes default in administrator panel
	 |--------------------------------------------------------------------------
	 |
	 | Modify or add new configuration
	 | Always add new array [attribute],[value] for registering new attribute
	 |
	 */

	 'attributes' => [
		['skins' =>
			['#438EB9' => true, '#222A2D' => false, '#C6487E' => false, '#D0D0D0' => false]
	 	],
	 	['show_email' =>
	 		['Yes' => 1, 'No' => 0]
	 	],
	 	['show_profile' =>
	 		['Yes' => 1, 'No' => 0]
	 	],
	 	['show_profile_image' =>
	 		['Yes' => 1, 'No' => 0]
	 	],
	],

	/*
	 |--------------------------------------------------------------------------
	 | Table status inactive or active attributes default in administrator panel
	 |--------------------------------------------------------------------------
	 |
	 | Modify or add new configuration
	 | Always add new array [attribute],[value] for registering new attribute
	 |
	 */
	 'status' =>
		[
			'1' => 'Active',
			'2' => 'Inactive'
		],

	'configure'	=> ['install' => true,'safe_mode'=> 'http://your-site.com/']
];
