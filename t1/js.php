<?php 
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#  
###############################################################################################################
#
include("config.tematres.php");
?>
function expand( id ) {
	var details = document.getElementById('masTE' + id );
	var enlaceMas= document.getElementById( 'expandTE' + id );
	var enlaceMenos= document.getElementById( 'contraeTE' + id );
	details.style.display = ( details.style.display == 'block' ) ? 'none' : 'block';
	enlaceMas.style.display = ( details.style.display == 'block' ) ? 'none' : 'inline';
	enlaceMenos.style.display = ( details.style.display == 'block' ) ? 'inline' : 'none';
}

function expandLink( id ) {
	var details = document.getElementById( id );
	var enlaceMas= document.getElementById( 'expandTE' + id );
	var enlaceMenos= document.getElementById( 'contraeTE' + id );
	details.style.display = ( details.style.display == 'block' ) ? 'none' : 'block';
	enlaceMas.style.display = ( details.style.display == 'block' ) ? 'none' : 'inline';
	enlaceMenos.style.display = ( details.style.display == 'block' ) ? 'inline' : 'none';
}


function montre(id) {
	  if (document.getElementById) {
		  document.getElementById(id).style.display="block";
		} else if (document.all) {
		  document.all[id].style.display="block";
		} else if (document.layers) {
		  document.layers[id].display="block";
		} } 

 function cache(id) {
	  if (document.getElementById) {
		  document.getElementById(id).style.display="none";
		} else if (document.all) {
		  document.all[id].style.display="none";
		} else if (document.layers) {
		  document.layers[id].display="none";
		} }



function checkrequired(which) {
    var pass=true;
    if (document.images) {
    for (i=0;i<which.length;i++) {
    var tempobj=which.elements[i];
    if (tempobj.name.substring(0,1)=="_") {
    if (((tempobj.type=="text"||tempobj.type=="textarea"||tempobj.type=="password")&&
    tempobj.value=='')||((tempobj.name=="<?php echo FORM_JS_confirmPass; ?>") && (document.login.<?php echo FORM_JS_pass; ?>.value!==tempobj.value))
    )
    {
    pass=false;
    break;
        }
    }
    }
    }
    if (!pass) {

    shortFieldName=tempobj.name.substring(1,25).toUpperCase();

    alert("<?php echo FORM_JS_check; ?>"+shortFieldName+".");

    return false;

}else
 return true;
}


function askData() {
        if (confirm('<?php echo FORM_JS_confirm ?>')){
        return true;
        }else
        return false;
}


/* ---------------------------- */
/* AJAX search suggest			*/
/* ---------------------------- */

$().ready(function() {

	function formatItem(row) {
		return row[0] + " (<?php echo LABEL_terminoExistente;?>)";
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}

	$("#search-q").autocomplete('searcher.php', {
		width: 260,
		minChars: <?php echo CFG_MIN_SEARCH_SIZE;?>,
		selectFirst: false
	});
	
	$("#search-q").result(function(event, data, formatted) {
		if (data)
			$(this).parent().next().find("input").val(data[1]);
	});

	$("#addExistTerm").autocomplete('searcher.php?t=e', {
		width: 260,
		minChars: <?php echo CFG_MIN_SEARCH_SIZE;?>,
		selectFirst: false
	});
	
	$("#addExistTerm").result(function(event, data, formatted) {
		if (data)
			$(this).parent().next().find("input").val(data[1]);
	});


	$("#addTerms").autocomplete('searcher.php', {
		width: 300,
		multiple: true,
		matchContains: true,
		formatItem: formatItem,
		formatResult: formatResult,
		multipleSeparator: "\n",
		minChars: <?php echo CFG_MIN_SEARCH_SIZE;?>
	});
	
	$(":text, textarea").result(log).next().click(function() {
		$(this).prev().search();
	});

	
	$("#clear").click(function() {
		$(":input").unautocomplete();
	});
});

