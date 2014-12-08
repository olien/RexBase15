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


$(document).on('submit', '#rex-xform form', function()
{
  $(this).ajaxSubmit({
  //  clearForm: true,
    success: function(responseText, statusText, xhr, $form)
    {

console.log(responseText);

      $('#rex-xform').replaceWith($('#rex-xform', responseText));
      $('input[type=submit]', this).removeClass('loading').removeAttr('disabled');
    }
  });


    $('input[type=submit]', this).attr('disabled','disabled').addClass('loading');
   return false;
});


});
