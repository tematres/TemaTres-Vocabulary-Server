<?php

include("config.tematres.php");
$metadata=do_meta_tag();
?>
<!DOCTYPE html>
<html lang="<?php echo LANG;?>">
  <head>
  	<?php echo HTMLheader($metadata);?>
	<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
	<?php echo     '<script src="'.T3_WEBPATH.'bootstrap/js/bootstrap.min.js"></script>';?>
 </head>
 <body>
	<?php if (is_array($metadata["arraydata"])) echo HTMLmodalTerm($metadata);?>
</body>
</html>
<?php
#modal body for simple Term data
function HTMLmodalTerm($arrayTermData){

	$termCard=HTMLsimpleTerm($arrayTermData);

	$rows='<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                 <h4 class="modal-title"><a href="index.php?tema='.$arrayTermData["arraydata"]["tema_id"].'" title="'.LABEL_verDetalle.$arrayTermData["arraydata"]["titTema"].'" target="_blank">'.$arrayTermData["arraydata"]["titTema"].'</a></h4>
	            </div>
	            <div class="modal-body">
	            		<div class="te">'.$termCard["BTrows"].'</div>
	            		<div class="te">'.$termCard["UFrows"].'</div>
	            		<div class="te">'.$termCard["NTrows"].'</div>
	            		<div class="te">'.$termCard["RTrows"].'</div>
	            		<div class="notas">'.HTMLNotasTermino($arrayTermData["arraydata"]).'</div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">'.ucfirst(LABEL_close).'</button>
	            </div>
	        </div>
	        <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->';

	return $rows;

}


#
#  ARMADOR DE HTML CON DATOS DEL TERMINO
#
function HTMLsimpleTerm($arrayTerm){

	GLOBAL $CFG;
	$iNT=0;
	$iBT=0;
	$iRT=0;
	$iUF=0;

	//Terminos específicos
	$sqlNT=SQLverTerminosE($arrayTerm["arraydata"]["tema_id"]);

	while ($datosNT=$sqlNT->FetchRow()){
		$iNT=++$iNT;
			$css_class_MT=($datosNT["isMetaTerm"]==1) ? ' class="metaTerm" ' : '';

			$row_NT.=' <li '.$css_class_MT.' id="t'.$datosNT["id_tema"].'"><abbr class="thesacronym" id="r'.$datosNT["rel_id"].'" title="'.TE_termino.' '.$datosNT["rr_value"].'" lang="'.LANG.'">'.TE_acronimo.$datosNT["rr_code"].'</abbr> ';
			//ver  código
			$row_NT.=($CFG["_SHOW_CODE"]=='1') ? ' '.$datosNT["code"].' ' : '';

			$row_NT.=$datosNT["tema"].'</li>';
			};
	// Terminos TG, UF y TR
	$sqlTotalRelacionados=SQLverTerminoRelaciones($arrayTerm["arraydata"]["tema_id"]);

	while($datosTotalRelacionados= $sqlTotalRelacionados->FetchRow()){

		$classAcrnoyn='thesacronym';

		#Change to metaTerm attributes
		if(($datosTotalRelacionados["BT_isMetaTerm"]==1)){
			$css_class_MT= ' class="metaTerm" ';
			$label_MT=NOTE_isMetaTerm;
		}		else		{
			$css_class_MT= '';
			$label_MT='';
		}


		switch($datosTotalRelacionados["t_relacion"]){
			case '3':// TG
			$iBT=++$iBT;
			$row_BT.='<li><abbr class="'.$classAcrnoyn.'" id="edit_rel_id'.$datosTotalRelacionados["rel_id"].'" style="display: inline" title="'.TG_termino.' '.$datosTotalRelacionados[rr_value].'" lang="'.LANG.'">'.TG_acronimo.$datosTotalRelacionados["rr_code"].'</abbr>  '.$datosTotalRelacionados["tema"].'</li>';
			break;

			case '4':// UF
			//hide hidden equivalent terms
			$iUF=++$iUF;
				$row_UF.='<li><abbr class="'.$classAcrnoyn.'" id="edit_rel_id'.$datosTotalRelacionados["rel_id"].'" style="display: inline" title="'.UP_termino.' '.$datosTotalRelacionados["rr_value"].'" lang="'.LANG.'">'.UP_acronimo.$datosTotalRelacionados["rr_code"].'</abbr>   '.$datosTotalRelacionados["tema"].'</li>';
			break;

			case '2':// TR
			$iRT=++$iRT;
			$row_RT.='<li><abbr class="'.$classAcrnoyn.'" id="edit_rel_id'.$datosTotalRelacionados["rel_id"].'" style="display: inline" title="'.TR_termino.' '.$datosTotalRelacionados["rr_value"].'" lang="'.LANG.'">'.TR_acronimo.$datosTotalRelacionados["rr_code"].'</abbr>  '.$datosTotalRelacionados["tema"].'</li>';
			break;
		}
	};


	$BTrows=($iBT>0) ? '<h4>'.ucfirst(LABEL_broatherTerms).'</h4><ul class="list-unstyled" id="bt_data">'.$row_BT.'</ul>' :'';
	$NTrows=($iNT>0) ? '<h4>'.ucfirst(LABEL_narrowerTerms).'</h4><ul class="list-unstyled" id="nt_data">'.$row_NT.'</ul>':'';
	$RTrows=($iRT>0) ? '<h4>'.ucfirst(LABEL_relatedTerms).'</h4><ul class="list-unstyled" id="rt_data">'.$row_RT.'</ul>':'';
	$UFrows=($iUF>0) ? '<h4>'.ucfirst(LABEL_nonPreferedTerms).'</h4><ul class="list-unstyled" id="uf_data">'.$row_UF.'</ul>':'';

	return array("BTrows"=>$BTrows,"NTrows"=>$NTrows,"RTrows"=>$RTrows,"UFrows"=>$UFrows);
}

?>
