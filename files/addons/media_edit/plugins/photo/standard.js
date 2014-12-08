


jQuery(document).ready(function($)
//jQuery(window).load(function($)
{
  var $max_w = 700;

  var jcrop_api;
  var i, ac;

  initJcrop();
  function initJcrop()
  {
    jcrop_api = $.Jcrop('#cropbox');
    jcrop_api.setOptions(
    {
      onChange: showPreview,
      onSelect: showPreview
		});
		changePreview();
		jcrop_api.release();
  };

  /*
	$('#cropbox').Jcrop({
		aspectRatio: 1,
		onChange: showPreview,
		onSelect: showPreview
	});
	*/


  // Wenn Vorgabe geaendert wird -> Daten anpassen
  $('#photo_ratio').change(function(e)
  {
    changePreview();
    changeFilename();
  });


  function changePreview()
  {
    var sizes = getSizes();

    $('#photo_ratio_w').attr('value', sizes[0]);
    $('#photo_ratio_h').attr('value', sizes[1]);
    $('#preview').css({
      width: sizes[0] + 'px',
      height: sizes[1] + 'px'
    });

    jcrop_api.setOptions({ aspectRatio: sizes[0]/sizes[1] });
    jcrop_api.focus();
  }


  // Preview
  var $preview = $('#previewbox');
  function showPreview(coords)
  {
    updateCoords(coords);
    if (parseInt(coords.w) > 0)
    {
      var photo_w = $('#cropbox').width();
      var photo_h = $('#cropbox').height();

      var photo_ratio_w = $('#photo_ratio_w').attr('value');
      var photo_ratio_h = $('#photo_ratio_h').attr('value');

      var rx = photo_ratio_w / coords.w;
      var ry = photo_ratio_h / coords.h;


      $preview.css({
        width: Math.round(rx * photo_w) + 'px',
        height: Math.round(ry * photo_h) + 'px',
        marginLeft: '-' + Math.round(rx * coords.x) + 'px',
        marginTop: '-' + Math.round(ry * coords.y) + 'px'
      });


      var photo_org = $('#photo_org').attr('value');
      var photo_org_w = $('#photo_org_w').attr('value') * 1;
      var photo_org_h = $('#photo_org_h').attr('value') * 1;


      var preview_w = $('#preview').width();
      var preview_h = $('#preview').height();

      var check = false;
      var check_w = Math.round(coords.w * photo_org_w / $max_w);
      var check_h = Math.round(coords.h * photo_org_h / (photo_org_h * $max_w / photo_org_w));
      if (photo_org == 1)
      {
        // Bild wird in Originalgroesse dargestellt
        check_w = Math.round(coords.w);
        check_h = Math.round(coords.h);
      }


      if (check_w < preview_w)
        check = true;

      if (check_h < preview_h)
        check = true;

      var text = '';
      if (check)
      {
        text += '<div class="rex-form-row"><p class="rex-form-col-a rex-form-read">';
        text += '<label><b>Achtung:</b></label><span class="rex-form-read">Das Bild wird hochskaliert</span>';
        text += '</p></div>';

        text += '<div class="rex-form-row"><p class="rex-form-col-a rex-form-read">';
        text += '<label>Einstellung:</label><span class="rex-form-read">' + preview_w + ' x ' + preview_h + ' px</span>';
        text += '</p></div>';

        text += '<div class="rex-form-row"><p class="rex-form-col-a rex-form-read">';
        text += '<label>Auswahl:</label><span class="rex-form-read">' + check_w + ' x ' + check_h + ' px</span>';
        text += '</p></div>';

        $('#photo_notice_js').html(text);
      }
      else
      {
        $('#photo_notice_js').html('');
      }
    }
  };



  function getSizes()
  {
    var sizes = '';
    $('#photo_ratio option:selected').each(function(){
      sizes = $(this).attr('value');
    });

    sizes = sizes.split('x');

    return sizes;
  }


  function changeFilename()
  {
    var sizes = getSizes();

    var file_name = $('#photo_file_name').attr('value');
    var suffix_save = $('#photo_suffix_save').attr('value');
    var suffix = $('#photo_suffix_' + sizes[0] + 'x' + sizes[1]).attr('value');

    file_name = file_name.replace(suffix_save, suffix);

    $('#photo_file_name').attr('value', file_name);
    $('#photo_suffix_save').attr('value', suffix);

  }


});


function updateCoords(c)
{
	jQuery('#x').val(c.x);
	jQuery('#y').val(c.y);
  jQuery('#x2').val(c.x2);
  jQuery('#y2').val(c.y2);
	jQuery('#w').val(c.w);
	jQuery('#h').val(c.h);
};

function checkCoords()
{
	if (parseInt(jQuery('#w').val())>0)
	 return true;

	alert('Vor dem Speichern eine Auswahl definieren!');
	return false;
};
