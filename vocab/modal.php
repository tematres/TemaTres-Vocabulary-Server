<?php
require "config.tematres.php";

require_once T3_ABSPATH . 'common/include/vocabularyservices.php';

// If tterm_id isset, is a foreing term
// falta elegir entre 3 tipos de fuente de metadata: tema_id,tterm_id, URL

// Case 1: target term referenced in our vocab
if ((is_numeric(@$_GET["tvocab_id"]))) {
    $metadata["arraydata"]["tterm_uri"] = vars2tterm_uri($_GET["tvocab_id"], $_GET["term_id"]);
} elseif (is_numeric(@$_GET["tterm_id"])) {
    $metadata["arraydata"] = ARRAYtargetTerm($_GET["tema"], $_GET["tterm_id"]);
} else {
    $metadata=do_meta_tag();
}

?>
<!DOCTYPE html>
<html lang="<?php echo LANG;?>">
    <head>
        <?php echo HTMLheader($metadata);?>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
        <?php echo     '<script src="'.T3_WEBPATH.'bootstrap/js/bootstrap.min.js"></script>';?>
    </head>
    <body>
        <?php if (is_array($metadata["arraydata"])) { echo HTMLmodalTerm($metadata);
        }?>
    </body>
</html>
<?php

// modal body for simple Term data
function HTMLmodalTerm($arrayTermData)
{
    // is foreing term
    if (isset($arrayTermData["arraydata"]["tterm_uri"])) {
        $arrayTterm = ttermFullMetadata($arrayTermData["arraydata"]["tterm_uri"]);
        $arrayTermData["arraydata"]["titTema"] = $arrayTterm["tterm"]["string"];
        $arrayTermData["arraydata"]["tema_id"] = $arrayTterm["tterm"]["term_id"];

        $HTMLtermRelations = HTMLsimpleForeignTerm($arrayTterm, $arrayTterm["URL_ttermData"]);
        $HTMLlinkTerm = '<a href="'.$arrayTterm["URL_ttermData"]["tterm_url"].'" target="_blank" title="'.$arrayTermData["arraydata"]["titTema"].'">'.$arrayTermData["arraydata"]["titTema"].'</a>';
        $HTMLlinkTerm .= ' @ '.$arrayTterm["tvocab"]["tvocab_title"];
    } else {
        $HTMLtermRelations= HTMLsimpleTerm($arrayTermData);
        $HTMLlinkTerm=HTMLlinkTerm(array("tema_id"=>$arrayTermData["arraydata"]["tema_id"], "tema"=>$arrayTermData["arraydata"]["titTema"]));
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

?>
