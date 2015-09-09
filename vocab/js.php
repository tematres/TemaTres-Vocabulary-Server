<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#
###############################################################################################################
#
header('Content-Type: application/javascript; charset=utf-8');
include("config.tematres.php");
/*
 * Load tinyMCE only if there are login
*/
if ($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]>0)
{
	?>
	<!-- Load TinyMCE -->
	$().ready(function() {
		$('#<?php echo LABEL_nota;?>').tinymce({
			// Location of TinyMCE script
			script_url : '<?php echo T3_WEBPATH;?>tiny_mce/tiny_mce.js',

			// General options
			language : "<?php echo LANG;?>",
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,|,bullist,numlist,|,undo,redo,|,link,unlink,image,|,removeformat,cleanup,code",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,cleanup,help,code,|",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			content_css : "<?php echo T3_WEBPATH;?>css/style.css",

			// Drop lists for link/image/media/template dialogs
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",
		});
	});
	<!-- /TinyMCE -->

	$(function() {
	 $(".editable_textarea").editable("searcher.php", {
		  indicator : '<img src="<?php echo T3_WEBPATH;?>images/indicator.gif"/>',
		  placeholder : '[<?php echo LABEL_CODE;?>]',
		  tooltip : '<?php echo LABEL_ClickEditar;?>',
		  style  : "inherit",
		  width : '100px',
		  id   : 'code_tema_id',
		  name : 'code_tema',
		  type   : 'text',
		  onblur : 'cancel',
		  submitdata: { _method: "put" },
		  select : true,
		  submit : '<?php echo ucfirst(LABEL_Guardar);?>',
		  cancel : '<?php echo ucfirst(LABEL_Cancelar);?>',
		  cssclass : "editable",
		  onerror : function(settings, original, xhr) {
			original.reset()
			alert(xhr.responseText)
		}
	  });

	 $(".edit_area_term").editable("searcher.php", {
		  indicator : '<img src="<?php echo T3_WEBPATH;?>images/indicator.gif"/>',
		  tooltip : '<?php echo LABEL_ClickEditar;?>',
		  id   : 'edit_tema_id',
		  name : 'edit_tema',
		  width : '300px',
		  rows : '1',
		  onblur : 'cancel',
		  type   : 'textarea',
		  submitdata: { _method: "put" },
		  select : true,
		  submit : '<?php echo ucfirst(LABEL_Guardar);?>',
		  cancel : '<?php echo ucfirst(LABEL_Cancelar);?>',
		  cssclass : "editable",
	  });
	  <?php

		$arrayCustumRelations["3"]["0"].=TG_acronimo;
		$arrayCustumRelations["4"]["0"].=UP_acronimo;
		$arrayCustumRelations["2"]["0"].=TR_acronimo;

		$SQLtypeRelations=SQLtypeRelations();
		while ($ARRAYtypeRelations=$SQLtypeRelations->FetchRow())
		{
				$arrayCustumRelations["$ARRAYtypeRelations[t_relation]"]["$ARRAYtypeRelations[rel_rel_id]"].= $ARRAYtypeRelations[rr_value];
		};

		//add reverse view or BT/NT relation
		$arrayCustumRelations["TE"]=$arrayCustumRelations["3"];
		$arrayCustumRelations["TE"]["0"]=TE_acronimo;

		?>
	  $(".editable_selectTE").editable("searcher.php", {
		indicator : '<img src="<?php echo T3_WEBPATH;?>images/indicator.gif">',
		data   : '<?php print json_encode($arrayCustumRelations["TE"]); ?>',
		id   : 'edit_rel_id',
		name : 'rel_rel_id',
		type   : "select",
		submit : "OK",
		style  : "inherit",
		submitdata : function() {
			return {
				tema_id : '<?php print $metadata["arraydata"]["tema_id"];?>',
				relativeLabel : 'X'
			};
			}
		});
	  $(".editable_select3").editable("searcher.php", {
		indicator : '<img src="<?php echo T3_WEBPATH;?>images/indicator.gif">',
		data   : '<?php print json_encode($arrayCustumRelations["3"]); ?>',
		id   : 'edit_rel_id',
		name : 'rel_rel_id',
		type   : "select",
		submit : "OK",
		style  : "inherit",
		submitdata : function() {
			return {tema_id : '<?php print $metadata["arraydata"]["tema_id"];?>' };
			}
		});
	  $(".editable_select2").editable("searcher.php", {
		indicator : '<img src="<?php echo T3_WEBPATH;?>images/indicator.gif">',
		data   : '<?php print json_encode($arrayCustumRelations["2"]); ?>',
		id   : 'edit_rel_id',
		name : 'rel_rel_id',
		type   : "select",
		submit : "OK",
		style  : "inherit",
		submitdata : function() {
			return {tema_id : '<?php print $metadata["arraydata"]["tema_id"];?>' };
			}
		});
	  $(".editable_select4").editable("searcher.php", {
		indicator : '<img src="<?php echo T3_WEBPATH;?>images/indicator.gif">',
		data   : '<?php print json_encode($arrayCustumRelations["4"]); ?>',
		id   : 'edit_rel_id',
		name : 'rel_rel_id',
		type   : "select",
		submit : "OK",
		style  : "inherit",
		submitdata : function() {
			return {tema_id : '<?php print $metadata["arraydata"]["tema_id"];?>' };
			}
		});
	});
<?php
}// session
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
	details.style.display = ( details.style.display == 'block' ) ? 'none' : 'block';

}


function checkrequired(which) {
    var pass=true;
    if (document.images) {
    for (i=0;i < which.length;i++) {
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
/* AJAX tree view  				*/
/* ---------------------------- */
$(function() {
         var $tree = $('#treeTerm');
	     $tree.tree({
           dragAndDrop: false,
           autoEscape: false,
           useContextMenu: false
           });
});

/* ---------------------------- */
/* AJAX search suggest			*/
/* ---------------------------- */


var options, a;
var onSelect = function(val, data) { $('#simple-search #id').val(data); $('#simple-search').submit(); };
jQuery(function(){

	function formatItem(row) {
		return row["value"] + " (<?php echo '<strong>'.LABEL_terminoExistente.'</strong>';?>)";
	}

	    options = {
		    serviceUrl:'suggest.php' ,
		    minChars:2,
		    delimiter: /(,|;)\s*/, // regex or character
		    maxHeight:400,
		    width:600,
		    zIndex: 9999,
		    deferRequestBy: 0, //miliseconds
		    noCache: false, //default is false, set to true to disable caching
		    // callback function:
		    onSelect: onSelect,
	    	};
	    a = $('#query').autocomplete(options);

	    var ac = $('#addTerms').autocomplete({
		    minChars:2,
		    serviceUrl:'suggest.php?t=0&amp;',
		    delimiter: /(,|;)\s*/, // regex or character
		    maxHeight:400,
		    width:600,
		    zIndex: 9999,
		    formatResult: formatItem,
		    delimiter: "\n",
		    deferRequestBy: 0, //miliseconds
		    noCache: false, //default is false, set to true to disable caching
  			});
	});



/* ---------------------------- */
/* OBSERVATORIO					*/
/* ---------------------------- */

function recargaedit(a,b,c,d){
	document.getElementById("value").value=a;
	document.getElementById("orden").value=b;
	document.getElementById("alias").value=c;
	document.getElementById("valueid").value=d;
	document.getElementById("doAdmin").value='modUserNotes';
	document.getElementById("alias").disabled=1;
}


function envianota(){
	document.getElementById("alias").disabled=0;
	document.getElementById("morenotas").submit();
}


function preparaborrado2(a){
  if (confirm("<?php echo ucfirst(FORM_JS_confirmDeleteTypeNote)?>")==true) {
	document.getElementById("value").value=a;
	document.getElementById("doAdmin").value='deleteUserNotes';
	document.getElementById("morenotas").submit();
	}
}


function addrt(a,b,c){
	document.getElementById("rema_id").value=a;
	document.getElementById("tema").value=b;
	document.getElementById("taskrelations").value=c;
	document.getElementById("taskterm").value=c;
	document.getElementById("addRelations").submit();
}

function recargaeditRel(a,b,c,d,e){
	document.getElementById("rr_value").value=a;
	document.getElementById("t_relacion").value=b;
	document.getElementById("t_relacion").disabled=true;
	document.getElementById("rr_code").value=c;
	document.getElementById("rr_id").value=d;
	document.getElementById("rr_ord").value=e;
	document.getElementById("doAdminR").value='modUserRelations';
	document.getElementById("alias").disabled=1;
}





function enviaRel(){
	document.getElementById("doAdminR").value='modUserRelations';
	document.getElementById("morerelations").submit();
}


function preparaborradoRel(a){
  if (confirm("<?php echo ucfirst(FORM_JS_confirmDeleteTypeRelation)?>")==true) {
	document.getElementById("rr_id").value=a;
	document.getElementById("doAdminR").value='deleteUserRelations';
	document.getElementById("morerelations").submit();
	}
}


function recargaeditURI(a,b,c){
	document.getElementById("uri_value").value=a;
	document.getElementById("uri_code").value=b;
	document.getElementById("uri_type_id").value=c;
	document.getElementById("doAdminU").value='modURIdefinition';
}


function enviaURI(){
	document.getElementById("doAdminU").value='modURIdefinition';
	document.getElementById("moreURI").submit();
}


function preparaborradoURI(a){
  if (confirm("<?php echo ucfirst(FORM_JS_confirmDeleteURIdefinition)?>")==true) {
	document.getElementById("uri_type_id").value=a;
	document.getElementById("doAdminU").value='deleteURIdefinition';
	document.getElementById("moreURI").submit();
	}
}



//Checkbox
$(document).ready(function(){
			 	//Checkbox
				$("input[name=checktodos]").change(function(){
					$("input[type=checkbox]").each( function() {
						if($("input[name=checktodos]:checked").length == 1){
							this.checked = true;
						} else {
							this.checked = false;
						}
					});
				});

			});

//filter table http://jsfiddle.net/giorgitbs/52ak9/1/
$(document).ready(function () {

    (function ($) {

        $('#filter').keyup(function () {

            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();

        })

    }(jQuery));

});
