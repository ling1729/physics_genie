
CKEDITOR.editorConfig = function( config ){
	config.extraPlugins += (config.extraPlugins.length == 0 ? '' : ',') + 'ckeditor_wiris';
	config.removePlugins = 'image,forms';
	config.toolbar = [
		{name: 'basic', items: ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', "Table", '-', 'Link', 'Unlink', '-', 'Source']},
		{name: 'wiris', items: ['ckeditor_wiris_formulaEditor', 'ckeditor_wiris_formulaEditorChemistry', 'ckeditor_wiris_CAS']}
	];
	config.width = '600px';
	config.allowedContent = true;
};
		