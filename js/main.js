$(function () {
    $('#form').on('submit', function (e) {
        // On empêche le navigateur de soumettre le formulaire
        e.preventDefault();
 		var CONST_ERROR_SIZE =  "errorSize";
		var CONST_ERROR_UPLOAD = "errorUpload";
		var CONST_ERROR_EXTENSION = "errorExtension";
		var CONST_ERROR_NOFILE = "errorNoFile";
        var $form = $(this);
        var img = $('#img-input').attr('name');

        $('#progress').show();
 
        $.ajax({
            url: "add-file.php",
            type: "post",
            dataType: 'text', // selon le retour attendu
            data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false, 
		    mimeType:"multipart/form-data",
            success: function (response) {
            	$('#progress').hide();
            	console.log(response);
            	response = response.trim();
                if(response == "ok"){
                	setMessage("Votre fichier a bien été uploadé !","success");
                } 
                else if(response == CONST_ERROR_SIZE){
                	setMessage("Echec de l'upload, la taille de votre fichier est trop gros. Max : 2 Mo", "error");
                }
                else if(response == CONST_ERROR_NOFILE){
                	setMessage("Veuillez selectionner une image avant d'uploader.","error");
                }
                else if(response == CONST_ERROR_EXTENSION ){
                	setMessage("Echec de l'upload, vérifier l'extension de votre image","error");
                }
            },

            resetForm : true
        });
    });
});
function setMessage(error, elementId){
	$('#'+elementId).text(error);
	setTimeout(function(){
		$('#'+elementId).text("");
	},3000)
}