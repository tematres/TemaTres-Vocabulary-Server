<?php
/*
 *      TemaTres : aplicación para la gestión de lenguajes documentales
 *
 *      Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
 *      Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
 */

header('Content-Type: application/javascript; charset=utf-8');
require "config.tematres.php";

/*
 * Load tinyMCE only if there are login
 */
if ($_SESSION[$_SESSION["CFGURL"]]["ssuser_nivel"] > 0) {
    ?>
    <!-- Load TinyMCE -->
    tinymce.init({
        selector: "textarea#<?php echo LABEL_nota;?>",
        language : "<?php echo LANG;?>",
        plugins: [
            "advlist autolink autosave link image lists charmap preview hr anchor",
            "searchreplace wordcount autolink visualchars code insertdatetime media nonbreaking",
            "table contextmenu directionality textcolor paste  textcolor colorpicker autoresize preview save"
        ],
        toolbar1: " bold italic underline strikethrough |  cut copy paste pastetext removeformat | searchreplace| undo redo ",
        toolbar2: " bullist numlist | link unlink image media | preview code save ",
          code_dialog_width: 400,
        menubar: false,
        toolbar_items_size: 'small',
        entity_encoding : "raw",
        fix_list_elements : true,
        height: 200,
        extended_valid_elements: 'img[class=myclass|!src|border:0|alt|width|height]',
        invalid_elements: 'style,script,html,body',
        branding: false
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
          onerror : function(settings, original, xhr) {
            original.reset()
            alert(xhr.responseText)
        }

      });
        <?php

        $arrayCustumRelations["3"]["0"].=TG_acronimo;
        $arrayCustumRelations["4"]["0"].=UP_acronimo;
        $arrayCustumRelations["2"]["0"].=TR_acronimo;

        $SQLtypeRelations=SQLtypeRelations();
        while ($ARRAYtypeRelations=$SQLtypeRelations->FetchRow()) {
                $arrayCustumRelations["$ARRAYtypeRelations[t_relation]"]["$ARRAYtypeRelations[rel_rel_id]"].= $ARRAYtypeRelations["rr_value"];
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
} // session
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



function askData() {
        if (confirm('<?php echo FORM_JS_confirm ?>')){
        return true;
        }else
        return false;
}

/* ---------------------------- */
/* AJAX tree view               */
/* ---------------------------- */
$(function() {
         var $tree = $('#treeTerm');
         $tree.tree({
            buttonLeft: false,
            dragAndDrop: false,
            autoEscape: false,
            selectable: false,
            useContextMenu: false
           });
});

/* ---------------------------- */
/* AJAX search suggest          */
/* ---------------------------- */


var options, a;
var onSelect = function(val, data) { $('#simple-search #id').val(data); $('#simple-search').submit(); };

jQuery(function(){

    function formatItem(row) {
        return row["value"] + " (<?php echo '<strong>'.LABEL_terminoExistente.'</strong>';?>)";
    }

    function term_code(row) {
        return row["data"];
    }

        options = {
            serviceUrl:'suggest.php' ,
            minChars:2,
            delimiter: /(,|;)\s*/,
            maxHeight:400,
            width:600,
            zIndex: 9999,
            deferRequestBy: 0,
            formatResult: term_code,
            noCache: false,
            onSelect: onSelect,
            showNoSuggestionNotice: true,
            noSuggestionNotice: '<i><?php echo ucfirst(LABEL_noResults);?></i>',
            autoSelectFirst:true

            };

        a = $('#query').autocomplete(options);

        var ac = $('#addTerms').autocomplete({
            minChars:2,
            serviceUrl:'suggest.php?t=0&amp;',
            maxHeight:400,
            width:600,
            zIndex: 9999,
            formatResult: formatItem,
            delimiter: "\n",
            deferRequestBy: 0,
            triggerSelectOnValidInput:false,
            tabDisabled: true,
            noCache: false,
              });
    });

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


//To load remote URL in modal
(function(){
        // Create jQuery body object
        var $body = $('body'),

        // Use a tags with 'class="modalTrigger"' as the triggers
        $modalTriggers = $('a.modalTrigger'),

        // Trigger event handler
        openModal = function(evt) {
              var $trigger = $(this),                  // Trigger jQuery object

              modalPath = $trigger.attr('href'),       // Modal path is href of trigger

              $newModal,                               // Declare modal variable

              removeModal = function(evt) {            // Remove modal handler
                    $newModal.off('hidden.bs.modal');  // Turn off 'hide' event
                    $newModal.remove();                // Remove modal from DOM
              },

              showModal = function(data) {             // Ajax complete event handler
                    $body.append(data);                // Add to DOM
                    $newModal = $('.modal').last();    // Modal jQuery object
                    $newModal.modal('show');           // Showtime!
                    $newModal.on('hidden.bs.modal',removeModal); // Remove modal from DOM on hide
              };

              $.get(modalPath,showModal);             // Ajax request

              evt.preventDefault();                   // Prevent default a tag behavior
        };

        $modalTriggers.on('click',openModal);         // Add event handlers
  }());