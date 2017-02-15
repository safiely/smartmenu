$(document).ready(function(){
   
    var url = document.location.toString();
    if (url.match('#')) {
        $('.tab-nav a[href=#'+url.split('#')[1]+']').tab('show') ;
    }
    
});