$(document).ready(function(){
    $('.div-bottom').height($('.div-bottom').height()+25);
    $('.div-top').width($('#iframe_content').width()+$('.div-left').width()+$('.div-right').width());
    $('.div-left').height($('#iframe_content').height());
    $('.div-right').height($('#iframe_content').height());
    $('.div-bottom').width($('#iframe_content').width()+$('.div-left').width()+$('.div-right').width());
});