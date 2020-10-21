/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	// config.toolbar = [
	// 	{ name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
	// 	{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	// 	{ name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
	// 	{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
	// 	'/',
	// 	{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
	// 	{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
	// 	{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
	// 	{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
	// 	'/',
	// 	{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
	// 	{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
	// 	{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
	// 	{ name: 'about', items: [ 'About' ] }
	// ];
	//config.skin = 'office2013';
	//config.skin = 'kama';
	config.skin = 'moono_blue';
	config.toolbar = [
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript' ] },
		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList'] },
		{ name: 'styles', items: [ 'Font', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor', 'Image' ] },
		{ name: 'document', items: [ 'Source', '-', 'Templates', 'Table' ] },
		{ name: 'tools', items: [ 'Maximize'] }
	];

    config.allowedContent = true;

    config.filebrowserUploadMethod = 'form';

    //var path = CKEDITOR.basePath.split('/');
    //console.log(path);
    //path[ path.length-2 ] = 'upload_image';
    //config.filebrowserUploadUrl = path.join('/').replace(/\/+$/, '');


    // var url = '/upload_image';
    // config.filebrowserUploadUrl = url;

    // Add plugin
    config.extraPlugins = 'filebrowser';
};
