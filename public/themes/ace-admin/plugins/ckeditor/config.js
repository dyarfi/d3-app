/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links',  groups: [ 'mediaembed' ] },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		//{ name: 'about' }
	];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	config.extraPlugins = 'mediaembed';

	// Whether to escape HTML when the editor updates the original input element.
	config.htmlEncodeOutput = false;

	config.filebrowserBrowseUrl = base_URL + '/themes/ace-admin/plugins/kcfinder/browse.php?opener=ckeditor&type=files';
	config.filebrowserImageBrowseUrl = base_URL + '/themes/ace-admin/plugins/kcfinder/browse.php?opener=ckeditor&type=images';
	config.filebrowserFlashBrowseUrl = base_URL + '/themes/ace-admin/plugins/kcfinder/browse.php?opener=ckeditor&type=flash';
	config.filebrowserUploadUrl = base_URL + '/themes/ace-admin/plugins/kcfinder/upload.php?opener=ckeditor&type=files';
	config.filebrowserImageUploadUrl = base_URL + '/themes/ace-admin/plugins/kcfinder/upload.php?opener=ckeditor&type=images';
	config.filebrowserFlashUploadUrl = base_URL + '/themes/ace-admin/plugins/kcfinder/upload.php?opener=ckeditor&type=flash';
};
