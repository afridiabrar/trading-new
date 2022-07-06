

$(document).ready(function(){
    $(".openMenu").click(function(){
        //alert('ss');
        $('section.sidebar').addClass('open');
    });

    $("span.close").click(function(){
        $('section.sidebar').removeClass('open');
    });
});

