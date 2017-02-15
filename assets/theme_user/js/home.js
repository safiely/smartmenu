$(document).ready(function(){
    
    if(sessionStorage.getItem('firstView')!='true') {
        new $.nd2Toast({
            message : "Découvrez notre carte en cliquant sur &nbsp;&nbsp<i class='zmdi zmdi-local-library'></i>",
            ttl : 3000
        });
        sessionStorage.setItem('firstView','true');
    }

    //Customize facebook link to switch fb website, or fb app
    if($('#fb-link').length){
       var fb_href = (window.isMobile.any()) ? "fb://page/"+$('#fb-link').data('fb-id') : "https://www.facebook.com/"+$('#fb-link').data('fb-id');
       $('#fb-link').prop('href', fb_href);
    }
    
});