/**
 * JavaScript file with CKEditor integration for the "Embedded answers" Wiris Quizzes getting started example.
 */

/**
 * Initialize CKEditor with the button to create embedded answer fields.
 **/
function ckeditor_init(embeddedAnswersEditor) {
    // Instantiate CKEditor with custom toolbar.
    var ckeditor = CKEDITOR.replace("htmleditor", {
		toolbar : [
            {name : "edit", items : ["Bold", "Italic", "-", "NumberedList", "BulletedList", "Table", "-", "Link", "Unlink", "-", "Source"]},
            {name : "wiris", items : ["ckeditor_wiris_formulaEditor", "ckeditor_wiris_formulaEditorChemistry", "AddAnswer"]}
        ],
    allowedContent : true,
    });
    
    // Create the "add answer" editor command.
    ckeditor.addCommand("addanswer", {
        // Handler function for event triggered when user clicks the button in
        // CKEditor to add embedded answer field.
        exec : function(editor) {
            // Create authoring field.
            var authoringElement = embeddedAnswersEditor.newEmbeddedAuthoringElement();
            // Convert standard DOM element into CKEditor DOM element.
            var element = CKEDITOR.dom.element.get(authoringElement);
            // Insert field in question text.
            editor.insertElement(element);
            // Call analyzeHTML() after inserting the embedded answer.
            embeddedAnswersEditor.analyzeHTML();
        },
    });
    
    // Add new button and bind the command to it.
    ckeditor.ui.addButton("AddAnswer", {
        label : "Add embedded answer - Wiris Quizzes",
        command : "addanswer",
        icon : com.wiris.quizzes.api.Quizzes.getInstance().getResourceUrl("quizzes16.png"), 
    });
    
    // Link the Wiris Quizzes EmbeddedAnswersEditor with the document on ckeditor.
    ckeditor.on("contentDom", function () {
        embeddedAnswersEditor.setEditableElement(ckeditor.document.$);
    });
    
    ckeditor.on("change", function () {
        embeddedAnswersEditor.setEditableElement(ckeditor.document.$);
    });
	
	// Remove the attribute contenteditable="false" on input elements set by CKEditor in setData().
	ckeditor.on("instanceReady", function () {
		ckeditor.dataProcessor.dataFilter.addRules({
			elements: {
				input: function(elem) {
					delete elem.attributes.contenteditable;
				}
			}
		});
		
	});
    
    // Return the configured CKEditor instance.
    return ckeditor;
}

function ckeditor_setdata(ckeditor, text) {
	ckeditor.setData(text);
}

function ckeditor_getdata(ckeditor) {
    return ckeditor.getData();
}