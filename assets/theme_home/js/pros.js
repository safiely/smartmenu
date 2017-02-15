$(document).ready(function(){
    
    $(window).resize(main_image);
    function main_image(){
        if($(window).width()>1200) {
            $('.home_top').height($(window).height()-$('.navbar-header').height()-$('footer').height());
        } else {
            $('.home_top').height('auto');
        }
    }
    main_image();
    
    
    $('.arrow_demo').height(($('.div-right').height())/3.3);
    
    
    $(window).resize(test_link);
    function test_link(){
        $('span.demo_test').unbind('click');
        if($(window).width()<768){
            $('span.demo_test').on('click', function(){
                location.href="/home/demos_preview/user/demo-lefirenze";
            });            
        } else if($(window).width()<991){
            $('span.demo_test').on('click', function(){
                location.hash="demo";
            });            
        } else if($(window).width()<1200){
            $('span.demo_test').on('click', function(){
                $('.demo_test_content').css('border', 'solid 1px red');
            });
        }
        else {
            $('span.demo_test').on('click', function(){
                var cnt = 0;
                function blink_arrows(cnt) {
                    setTimeout(function () {
                        if ($('.arrow_demo').css('visibility') == 'hidden') {
                            $('.arrow_demo').css('visibility', 'visible');
                        } else {
                            $('.arrow_demo').css('visibility', 'hidden');
                        }
                        cnt++;
                        if (cnt<=5) {
                            blink_arrows(cnt);
                        }
                    }, 500);
                }
                blink_arrows(cnt);
            });
        }
    }
    test_link();
    
});