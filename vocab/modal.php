<?php
include("config.tematres.php");
$metadata=do_meta_tag();
//If tterm_id isset, is a foreing term
//falta elegir entre 3 tipos de fuente de metadata: tema_id,tterm_id, URL
$tterm_id=(is_numeric(@$_GET["tterm_id"])) ? $_GET["tterm_id"] : 0;
$metadata["arraydata"]=($tterm_id>0) ? ARRAYtargetTerm($metadata["arraydata"]["tema_id"],$tterm_id) : $metadata["arraydata"];
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

//is foreing term
if(isset($arrayTermData["arraydata"]["tterm_uri"])){
  require_once(T3_ABSPATH . 'common/include/vocabularyservices.php');

  $arrayTterm=ttermFullMetadata($arrayTermData["arraydata"]["tterm_uri"]);

  $arrayTerm=ARRAYttermData(getURLdata($arrayTermData["arraydata"]["tterm_uri"]));
  $arrayTermData["arraydata"]["titTema"]=$arrayTterm["tterm"]["string"];
  $arrayTermData["arraydata"]["tema_id"]=$arrayTterm["tterm"]["term_id"];
  $URL_ttermData=URIterm2array($arrayTermData["arraydata"]["tterm_uri"]);

  //$HTMLtermRelations=HTMLsimpleForeignTerm($arrayTermData,$URL_ttermData);
  $HTMLtermRelations=HTMLsimpleForeignTerm1($arrayTterm,$URL_ttermData);
  $HTMLlinkTerm='<a href="'.$URL_ttermData["tterm_url"].'" target="_blank" title="'.$arrayTermData["arraydata"]["titTema"].'">'.$arrayTermData["arraydata"]["titTema"].'</a>';
} else{
  $HTMLtermRelations= HTMLsimpleTerm($arrayTermData);
  $HTMLlinkTerm=HTMLlinkTerm(array("tema_id"=>$arrayTermData["arraydata"]["tema_id"],"tema"=>$arrayTermData["arraydata"]["titTema"]));
}



	$rows='<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                 <h4 class="modal-title">'.$HTMLlinkTerm.'</h4>
	            </div>
	            <div class="modal-body">
	            		<div class="te">'.$HTMLtermRelations["BTrows"].'</div>
	            		<div class="te">'.$HTMLtermRelations["UFrows"].'</div>
	            		<div class="te">'.$HTMLtermRelations["NTrows"].'</div>
	            		<div class="te">'.$HTMLtermRelations["RTrows"].'</div>
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

	return array("BTrows"=>$BTrows,
               "NTrows"=>$NTrows,
               "RTrows"=>$RTrows,
               "UFrows"=>$UFrows
             );
}


#
#  ARMADOR DE HTML CON DATOS DEL TERMINO
#
function HTMLsimpleForeignTerm($arrayTerm,$URL_ttermData){
	GLOBAL $CFG;
	$iNT=0;
	$iBT=0;
	$iRT=0;
	$iUF=0;
    /*NT*/
    $dataTE = getURLdata($URL_ttermData["URL_service"].'?task=fetchDown&arg='.$arrayTerm["arraydata"]["tema_id"]);
    if ($dataTE->resume->cant_result > 0) {
   	        foreach ($dataTE->result->term as $value) {
            $iNT=++$iNT;
      			$row_NT.=' <li '.$css_class_MT.' id="t'.$value->term_id.'"><abbr class="thesacronym"  title="'.TE_termino.' '.$value->rr_value.'">'.TE_acronimo.$value->rr_code.'</abbr> ';
      			$row_NT.=$value->string.'</li>';
		        };
    }
    //Fetch data about associated terms (BT,RT,UF)
    $dataDirectTerms = getURLdata($URL_ttermData["URL_service"].'?task=fetchDirectTerms&arg='.$arrayTerm["arraydata"]["tema_id"]);
    if ($dataDirectTerms->resume->cant_result > "0") {
        foreach ($dataDirectTerms->result->term as $value) {
            $i=++$i;
            $term_id=(int) $value->term_id;
            $term_string=(string) $value->string;
            switch ((int) $value->relation_type_id) {
                case '2':
                        $iRT=++$iRT;
    					          $row_RT.='<li><abbr id="edit_rel_id'.$term_id.'" style="display: inline" title="'.TR_acronimo.' '.$term_string.'" lang="'.LANG.'">'.TR_acronimo.$value->relation_code.'</abbr>  '.$term_string.'</li>';
                    break;
                case '3':
                        $iBT=++$iBT;
					              $row_BT.='<li><abbr id="edit_rel_id'.$term_id.'" style="display: inline" title="'.TG_termino.' '.$term_string.'" lang="'.LANG.'">'.TG_acronimo.$value->relation_code.'</abbr>  '.$term_string.'</li>';
                    break;
                case '4':
                    if ($value->relation_code != H) {
                        $iUF=++$iUF;
						            $row_UF.='<li><abbr id="edit_rel_id'.$term_id.'" style="display: inline" title="'.UP_acronimo.' '.$term_string.'" lang="'.LANG.'">'.UP_acronimo.$value->relation_code.'</abbr>  '.$term_string.'</li>';
                    }
                    break;
            }
        }
    };
	$BTrows=($iBT>0) ? '<h4>'.ucfirst(LABEL_broatherTerms).'</h4><ul class="list-unstyled" id="bt_data">'.$row_BT.'</ul>' :'';
	$NTrows=($iNT>0) ? '<h4>'.ucfirst(LABEL_narrowerTerms).'</h4><ul class="list-unstyled" id="nt_data">'.$row_NT.'</ul>':'';
	$RTrows=($iRT>0) ? '<h4>'.ucfirst(LABEL_relatedTerms).'</h4><ul class="list-unstyled" id="rt_data">'.$row_RT.'</ul>':'';
	$UFrows=($iUF>0) ? '<h4>'.ucfirst(LABEL_nonPreferedTerms).'</h4><ul class="list-unstyled" id="uf_data">'.$row_UF.'</ul>':'';

	return array("BTrows"=>$BTrows,"NTrows"=>$NTrows,"RTrows"=>$RTrows,"UFrows"=>$UFrows);
}

#
#  ARMADOR DE HTML CON DATOS DEL TERMINO
#
function HTMLsimpleForeignTerm1($arrayTerm,$URL_ttermData){
  $NTrows='';
  $BTrows='';
  $RTrows='';
  $UFrows='';

if(count($arrayTerm["ttermNT"])>0){
    foreach ($arrayTerm["ttermNT"] as $eachTerm) {
          			$row_NT.=' <li '.$css_class_MT.' id="t'.$eachTerm["term_id"].'"><abbr class="thesacronym"  title="'.TE_termino.' '.$eachTerm["rtype"].'">'.TE_acronimo.$eachTerm["rtype"].'</abbr> '.$eachTerm["string"].'</li>';
    }
  $NTrows='<h4>'.ucfirst(LABEL_narrowerTerms).'</h4><ul class="list-unstyled" id="nt_data">'.$row_NT.'</ul>';
  }

  if(count($arrayTerm["ttermBT"])>0){
    foreach ($arrayTerm["ttermBT"] as $eachTerm) {
          			$row_BT.=' <li '.$css_class_MT.' id="t'.$eachTerm[term_id].'"><abbr class="thesacronym"  title="'.TG_acronimo.' '.$eachTerm[rtype].'">'.TG_acronimo.$eachTerm[rtype].'</abbr> '.$eachTerm[string].'</li>';
    }
    $BTrows='<h4>'.ucfirst(LABEL_broatherTerms).'</h4><ul class="list-unstyled" id="bt_data">'.$row_BT.'</ul>';
  }

  if(count($arrayTerm["ttermRT"])>0){
    foreach ($arrayTerm["ttermRT"] as $eachTerm) {
          			$row_RT.=' <li '.$css_class_MT.' id="t'.$eachTerm[term_id].'"><abbr class="thesacronym"  title="'.TR_acronimo.' '.$eachTerm[rtype].'">'.TR_acronimo.$eachTerm[rtype].'</abbr> '.$eachTerm[string].'</li>';
    }
  $RTrows='<h4>'.ucfirst(LABEL_relatedTerms).'</h4><ul class="list-unstyled" id="rt_data">'.$row_RT.'</ul>';
  }

  if(count($arrayTerm["ttermUF"])>0){
    foreach ($arrayTerm["ttermUF"] as $eachTerm) {
          			$row_UF.=' <li  id="t'.$eachTerm[term_id].'"><abbr class="thesacronym"  title="'.UP_acronimo.' '.$eachTerm[rtype].'">'.UP_acronimo.$eachTerm[rtype].'</abbr> '.$eachTerm[string].'</li>';
    }
  $UFrows='<h4>'.ucfirst(LABEL_nonPreferedTerms).'</h4><ul class="list-unstyled" id="uf_data">'.$row_UF.'</ul>';
  }

return array("BTrows"=>$BTrows,"NTrows"=>$NTrows,"RTrows"=>$RTrows,"UFrows"=>$UFrows);
}
?>
