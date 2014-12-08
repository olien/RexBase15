<?php

function ep_include_responsiveimg($params) {
	global $REX;	
	$out = $params['subject'];	
	$tmp = '<script src="'.$REX['HTDOCS_PATH'].'files/addons/responsiveimg/js.js"></script></head>';
	$out = str_replace('</head>', $tmp, $out);
	return $out;
}

function ep_generate_responsiveimg_js($params) {
	global $REX;
	$tableName = $params['form']->tableName;
	if($tableName = $REX['TABLE_PREFIX'].'responsiveimg') {
		$sql = rex_sql::factory();
		$sql->getArray('SELECT DISTINCT minwidth FROM '.$REX['TABLE_PREFIX'].'responsiveimg ORDER BY minwidth DESC');
		$breakpoints = array();
		if($sql->getRows()>0) {
		    for($i=0;$i<$sql->getRows();$i++) {
		    	$breakpoints[] = $sql->getValue('minwidth');
		    	$sql->next();
		    }
		}
		$breakpoints[] = 1;
		$jscode = '
var bp = Array('.implode(',', $breakpoints).')
$.fn.respimg = function() {
	var ww = $(window).width();
	img = $(this)
	$(bp).each(function(key, val) {
		if(ww > val) {
		    	img.each(function() {
		    		MinSizeSrc = $(this).attr("data-min"+val);
		    		dataActive = $(this).attr("data-active");
		    		if(MinSizeSrc && (dataActive>ww || dataActive < val)) {
		    			$(this).attr("src", MinSizeSrc);
		    			$(this).attr("data-active", val);
		    		}	    		
		    	});
		}
	})  
};
$(document).ready(function() {
	$(".responsiveimg").respimg();
	    
    $(window).resize(function() {
        clearTimeout($.data(this, "resizeTimer"));
        
        $.data(this, "resizeTimer", setTimeout(function() {
            $(".responsiveimg").respimg();
        }, 100));
    });
});';
		$jsfile = $REX['HTDOCS_PATH'].'files/addons/responsiveimg/js.js';
		file_put_contents($jsfile, $jscode);		
	}
}

function ep_replace_responsiveimg($params) {
	global $REX;
	$out = $params['subject'];
	$sql = rex_sql::factory();
	$sql->getArray('SELECT * FROM '.$REX['TABLE_PREFIX'].'responsiveimg ORDER BY mobile_first ASC, minwidth ASC');
	$tmp_array = array();
	if($sql->getRows()>0) {
	    for($i=0;$i<$sql->getRows();$i++) {
	    $tmp_array[$sql->getValue('mobile_first')][intval($sql->getValue('minwidth'))] = $sql->getValue('responsive');
   	    $sql->next();
	    }
	}
	foreach ($tmp_array as $m1 => $breakpoints) {
		$alternate_src = 'class="responsiveimg" src="index.php?rex_img_type='.$m1.'&rex_img_file=\2" data-min1="index.php?rex_img_type='.$m1.'&rex_img_file=\2" data-active="9999"';
		foreach ($breakpoints as $minwidth => $responsive) {
			$alternate_src .= 'data-min'.$minwidth.'="index.php?rex_img_type='.$responsive.'&rex_img_file=\2" ';
		}
		$out = preg_replace('#src="index.php\?rex_img_type='.$m1.'&(amp;)?rex_img_file=(.*?)"#', $alternate_src, $out);
	}
	return $out;
}
	
?>