$(document).ready(function(){
    $('[role="toggle-drawer"]').bind('click', function(e){
        e.preventDefault();
        $('body').toggleClass('drawer-open');
    });

    $('.toggle-order-items').bind('click', function(e){
        e.preventDefault();
        $(this).parent().toggleClass('active');
    });

    $('li.selectable-option').bind('click', function(e){
        $(this).parent().children('li').removeClass('active');
        var $radio = $(this).children('div:first-child').children('div.form-group').children('input[type="radio"]');
        $radio.prop('checked', true).change();
        $(this).toggleClass('active');
    });

    $('.popup-with-zoom-anim').magnificPopup({
        type: 'inline',
        tClose: 'Fechar (Esc)',
        fixedContentPos: true,
        fixedBgPos: true,

        overflowY: 'auto',

        closeBtnInside: true,
        preloader: false,
        midClick: true,
        removalDelay: 200,
        mainClass: 'mfp-slide-bottom'
    });

    var c, currentScrollTop = 0,
        navbar = $('header');

    $(window).scroll(function () {
        var a = $(window).scrollTop();
        var b = navbar.height();

        currentScrollTop = a;

        if (c < currentScrollTop && a > b) {
            navbar.addClass("scrollUp");
        } else if (c > currentScrollTop && !(a <= b)) {
            navbar.removeClass("scrollUp");
        } else {
            navbar.removeClass("scrollUp");
        }
        c = currentScrollTop;
    });
});
