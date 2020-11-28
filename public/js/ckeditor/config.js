/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
    config.height = 100;
    config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
	];

	config.removeButtons = 'TextColor,Styles,Maximize,About,BGColor,ShowBlocks,Font,FontSize,Format,Flash,Image,Table,HorizontalRule,SpecialChar,PageBreak,Iframe,Anchor,Language,BidiRtl,BidiLtr,JustifyBlock,JustifyRight,JustifyCenter,JustifyLeft,CreateDiv,CopyFormatting,RemoveFormat,HiddenField,ImageButton,Button,Select,Textarea,TextField,Radio,Checkbox,Form,Replace,Find,PasteFromWord,Print,Preview,ExportPdf,NewPage,Save,Source,Templates';
};
