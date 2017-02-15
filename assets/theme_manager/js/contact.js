$(document).ready(function(){
    if(document.getElementById('mail_sended')!=null) {
      notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Nous avons bien reçu votre message, nous vous répondrons rapidement. Merci.');
    }
    
    
    if(document.getElementById('contact_form_error')!=null) {
        sweetAlertInitialize();
        swal({   
            title: "Échec de l'envoi",
            text: "Un problème est survenue dans l'envoi de votre message.",
            type: "error",
            showCancelButton: false,
            confirmButtonColor: "#4CAF50",
            confirmButtonText: "Quitter"
        }, function(){   
            location.href="/manager";
        });
    }
    
    
});