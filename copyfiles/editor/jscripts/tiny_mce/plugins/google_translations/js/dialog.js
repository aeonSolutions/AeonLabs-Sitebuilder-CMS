tinyMCEPopup.requireLangPack();

var GoogleTranslationsDialog = {
	init : function() {
		var f = document.forms[0];

		// Get the selected contents as text and place it in the input
		f.source.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});			
		 doTranslate();
		},

	translate : function() {
		doTranslate();
	},
		
	insert : function() {
		// Insert the contents from the input into the document
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, document.forms[0].translated.value);		
		tinyMCEPopup.close();
	}
};

function doTranslate() {
	sLang = tinyMCEPopup.getWin().document.getElementById('sLang').value; 
	dLang = tinyMCEPopup.getWin().document.getElementById('dLang').value;
	if(sLang!=dLang){
	google.language.translate(document.forms[0].source.value, sLang, dLang,function(result) {
				  if (!result.error) {
				  ret =  result.translation;
				  document.forms[0].translated.value = ret;
				  } else if(!silent) alert(result.error.message);	  	  					  
		});
	} else {
		document.forms[0].insert.style.visibility="hidden";
		document.forms[0].update.style.visibility="hidden";
	}
}

tinyMCEPopup.onInit.add(GoogleTranslationsDialog.init, GoogleTranslationsDialog);
