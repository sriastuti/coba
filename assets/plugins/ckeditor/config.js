/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbar =
		[
		    { name: 'basicstyles', items : [ 'Bold','Italic','Underline','-', 'NumberedList','BulletedList','-','Maximize', 'ShowBlocks' ] }
		];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Se the most common block elements.
	CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
	// Make dialogs simpler.
	config.removeDialogTabs = 'image:advanced;link:advanced';
};
