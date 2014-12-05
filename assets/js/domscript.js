$( document ).ready(function() {


// Externe Links in neuem Fenster öffnen
    $('a.extern').click(function(){
        window.open($(this).attr('href'));
        return false;
    });


// Externe Links

$("a[href^='http://']").addClass('extern');
$("a[href^='https://']").addClass('extern');
$("a[href^='http://']").attr('target', '_blank');
$("a[href^='https://']").attr('target', '_blank');




    $("a.top").click(function() {
         $('html, body').animate({
             scrollTop: $("body").offset().top
         }, 500);
     });

});
