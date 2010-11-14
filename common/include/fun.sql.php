<?php
#   TemaTres : aplicaciÃ³n para la gestiÃ³n de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versiÃ³n 2 (de junio de 1.991) Free Software Foundation
#  
###############################################################################################################
# funciones de consulta SQL #

#
# Cantidad de términos relacionados generales y por usuarios
#
function SQLcantTR($tipo,$idUser=""){
GLOBAL $DBCFG;

$idUser=secure_data($idUser,"sql");

if($tipo=='U'){
	$clausula="where uid='$idUser'";
	};

	$sql=SQL("select","relaciones.t_relacion,count(relaciones.id) as cant
		from $DBCFG[DBprefix]tabla_rel as relaciones
		$clausula
		group by relaciones.t_relacion");
	return $sql;
};


#
# Cantidad de términos generales y por usuarios
#
function SQLcantTerminos($tipo,$idUser=""){
GLOBAL $DBCFG;
$idUser=secure_data($idUser,"sql");

if($tipo=='U'){
	$clausula="where tema.uid='$idUser'";
	};
$sql=SQL("select","count(tema.tema_id) as cant,count(c.tema_id) as cant_candidato,count(r.tema_id) as cant_rechazado
		from $DBCFG[DBprefix]tema as tema
		left join $DBCFG[DBprefix]tema as c on tema.tema_id=c.tema_id and c.estado_id='12'
		left join $DBCFG[DBprefix]tema as r on tema.tema_id=r.tema_id and r.estado_id='14'
		$clausula");
return $sql;
};


#
# Cantidad de notas generales y por usuarios
#
function SQLcantNotas($user_id="0"){
GLOBAL $DBCFG;

$user_id=secure_data($user_id,"sql");

	$w = ($user_id>0) ? " where n.uid='$user_id' " : "";


$sql=SQL("select","count(n.id) as cant, n.tipo_nota
			from $DBCFG[DBprefix]notas n
			$w
			group by tipo_nota");
return $sql;

};

#
# Cantidad de términos mapeados (externos), por usuario y por vocabulario
#
function ARRAYcant_term2tterm($tvocab_id="0",$user_id="0"){
GLOBAL $DBCFG;

$user_id=secure_data($user_id,"sql");
$tvocab_id=secure_data($tvocab_id,"sql");

	$w = ($user_id>0) ? " and tt.uid='$user_id' " : "";
	$w.= ($user_id>0) ? " and tt.tvocab_id='$tvocab_id' " : "";


$sql=SQL("select","count(*) as cant
			from $DBCFG[DBprefix]term2tterm
			where 1=1
			$w");

return mysqli_fetch_array($sql[datos]);


};

#
# Búsqueda de términos hacia arriba desde un tema.
#
function SQLbucleArriba($tema_id){
GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

$sql=SQL("select","rel_abajo.id_mayor as id_abajo,
	tema.tema_id as id_tema,tema.tema as Ttema,relaciones.id
	from $DBCFG[DBprefix]tabla_rel as relaciones,$DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as rel_abajo on rel_abajo.id_menor=tema.tema_id
	and rel_abajo.t_relacion='3'
	where
	relaciones.id_menor=tema.tema_id
	and relaciones.id_menor='$tema_id'
	group by id_tema
	order by lower(tema.tema)");
return $sql;
};



#
# Búsqueda de términos hacia abajo desde un tema.
#

function SQLbucleAbajo($tema_id){
	
GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

$sql=SQL("select","rel_abajo.id_menor as id_abajo,
			tema.tema_id as id_tema,tema.tema as Ttema,relaciones.id
			from $DBCFG[DBprefix]tabla_rel as relaciones,$DBCFG[DBprefix]tema as tema
			left join $DBCFG[DBprefix]tabla_rel as rel_abajo on rel_abajo.id_mayor=tema.tema_id
			and rel_abajo.t_relacion='3'
			where
			relaciones.id_menor=tema.tema_id
			and relaciones.id_mayor='$tema_id'
			group by id_tema
			order by id_abajo desc");
	return $sql;
};


#
# Buscador general según string
#
function SQLbuscaSimple($texto){
GLOBAL $DBCFG;

$texto=trim($texto);

$texto=secure_data($texto,"sql");


$codUP=UP_acronimo;

//Control de estados
(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and tema.estado_id='13' " : $where="";

$sql=SQL("select","if(temasPreferidos.tema_id is not null,relaciones.id_menor,tema.tema_id) id_definitivo, 
		tema.tema_id,
		tema.tema,
		relaciones.t_relacion,
		temasPreferidos.tema as termino_preferido,
		if('$texto'=tema.tema,1,0) as rank,
		i.indice
			from $DBCFG[DBprefix]tema as tema
			left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id
			left join $DBCFG[DBprefix]tema as temasPreferidos on temasPreferidos.tema_id=relaciones.id_menor
	and tema.tema_id=relaciones.id_mayor
	and relaciones.t_relacion in (4,5,6,7,8)
	left join $DBCFG[DBprefix]indice i on i.tema_id=tema.tema_id
		where
		tema.tema like '%$texto%'
		$where
		group by tema.tema_id
		order by rank desc,lower(tema.tema)");

return $sql;
};

#
# Buscador general según string SIN UF ni términos EQ
#
function SQLSimpleSearchTrueTerms($texto,$limit="20"){
GLOBAL $DBCFG;

$texto=trim($texto);

$texto=secure_data($texto,"sql");

return SQL("select","t.tema as id_definitivo, 
	t.tema_id,
	t.tema,
	if('$texto'=t.tema,1,0) as rank,
	i.indice
from $DBCFG[DBprefix]indice i,$DBCFG[DBprefix]tema t
left join $DBCFG[DBprefix]tabla_rel r on r.t_relacion in ('4','5','6','7') 
	and r.id_mayor=t.tema_id
where
	t.tema like '%$texto%'
	and t.estado_id='13' 
	and i.tema_id=t.tema_id
	and r.id is null
order by rank desc,lower(t.tema)
limit 0,$limit");
};


function SQLbuscaExacta($texto){
GLOBAL $DBCFG;
$texto=trim($texto);
$texto=secure_data($texto,"sql");

$codUP=UP_acronimo;

//Control de estados
(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and tema.estado_id='13' " : $where="";

$sql=SQL("select","if(relaciones.t_relacion=4,relaciones.id_menor,tema.tema_id) as id_definitivo,tema.tema_id,
	if(relaciones.t_relacion=4,concat(tema.tema,' ($codUP)'),tema.tema) as tema,
	relaciones.t_relacion,if(relaciones.id is null and relacionesMenor.id is null,'SI','NO') as esTerminoLibre
	from $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id
	left join $DBCFG[DBprefix]tabla_rel as relacionesMenor on relacionesMenor.id_menor=tema.tema_id
	where
	tema.tema = '$texto'
	$where
	group by tema.tema_id
	order by lower(tema.tema),relaciones.t_relacion desc");
return $sql;
};



#
# ARRAY de cada términos sin relaciones
# Retrive simple term data for id
#
function ARRAYverTerminoBasico($tema_id){

GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

$sql=SQL("select","tema.tema_id as idTema,tema.code,tema.tema titTema,tema.tema, tema.estado_id,tema.cuando_estado,tema.cuando,tema.cuando_final
	from $DBCFG[DBprefix]tema as tema
	where
	tema.tema_id='$tema_id'");
	return mysqli_fetch_array($sql[datos]);
};


#
# ARRAY de datos de una nota
#

function ARRAYdatosNota($idNota){
GLOBAL $DBCFG;

$idNota=secure_data($idNota);

$sql=SQL("select","notas.id as idNota, notas.tipo_nota,notas.nota,notas.lang_nota,
		tema.tema_id as idTema,tema.tema
		from $DBCFG[DBprefix]notas as notas,$DBCFG[DBprefix]tema as tema
		where
		notas.id_tema=tema.tema_id
		and notas.id='$idNota'");

$array=mysqli_fetch_array($sql[datos]);

return $array;
};



#
# SQL de datos de notas de un término
#

function SQLdatosTerminoNotas($tema_id,$array_tipo_nota=""){
GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

if($array_tipo_nota)
	{
	//es una array de tipos de notas
	if(is_array($array_tipo_nota))
		{
		for($i=0; $i<count($array_tipo_nota);++$i){
			$where_in.='\''.$array_tipo_nota[$i].'\',';
			};
		$where_in=substr("$where_in",0,-1);
		$where=" and notas.tipo_nota in ($where_in) ";
		}
		else
		{
		$where=" and notas.tipo_nota='$array_tipo_nota' ";
		}
	}

// (@$tipo_nota) ? $where=" and notas.tipo_nota='$tipo_nota' " : $where="";

if(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id])
	 $where.=" and notas.tipo_nota!='NP' ";

return SQL("select","notas.id as nota_id, notas.tipo_nota,notas.nota,notas.lang_nota,
		tema.tema_id as tema_id,tema.tema,tema.estado_id,tema.cuando_estado
		from $DBCFG[DBprefix]notas as notas,$DBCFG[DBprefix]tema as tema
		where
		notas.id_tema=tema.tema_id
		and tema.tema_id='$tema_id'
		$where
		order by notas.tipo_nota,notas.cuando");
};


#
# Búsqueda de términos relacionados candidatos para un término según un string
#
function SQLbuscaTR($tema_id,$string){
GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

//Solo terminos aceptados == estado_id ='13'

$sql=SQL("select","if(terminosUP.id is not null,terminosUP.id_menor,tema.tema_id) as idTema,tema.tema,relaciones.id as idRel
	FROM $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as terminosUP on terminosUP.id_mayor=tema.tema_id
	and terminosUP.t_relacion='4'
	left join $DBCFG[DBprefix]tabla_rel as relaciones on '$tema_id' in (relaciones.id_menor,relaciones.id_mayor)
	and tema.tema_id in (relaciones.id_menor,relaciones.id_mayor)
	WHERE tema.tema
	LIKE '%$string%'
	and tema.tema_id!='$tema_id'
	and tema.estado_id='13'
	and tema.tesauro_id='$_SESSION[id_tesa]'	
	and relaciones.id is null
	and terminosUP.id is null
	ORDER BY lower(tema.tema)");

return $sql;
};


#
# Datos de cada términos con su tipificaciÃ³n y notas
#

function ARRAYverDatosTermino($tema_id){
GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

$sql=SQL("select","tema.tema_id as idTema,
	    tema.code,
		tema.tema,
		if(relaciones.id is null,'TT','PT') as tipo_termino,
		tema.cuando,
		tema.uid,
		tema.cuando_final,
		uid_final,
		relaciones.id_mayor,
		tema.estado_id,
		v.value_code as estado_code,
		tema.cuando_estado
		from $DBCFG[DBprefix]values v,$DBCFG[DBprefix]tema as tema
		left join $DBCFG[DBprefix]tabla_rel as relaciones on tema.tema_id=relaciones.id_menor
		and relaciones.t_relacion='3'
		where
		tema.tema_id='$tema_id'
		and v.value_type='t_estado'
		and v.value_id=tema.estado_id");

while($array=mysqli_fetch_array($sql[datos])){
	$i=++$i;
	$arrayDatos["idTema"]=$array[idTema];
	$arrayDatos["tema_id"]=$array[idTema];
	$arrayDatos["code"]=$array[code];
	$arrayDatos["titTema"]=$array[tema];
	$arrayDatos["descTema"]=$array[desc_tema];
	$arrayDatos["tipoTema"]=$array[tipo_termino];
	$arrayDatos["supraTema"]=$array[id_mayor];
	$arrayDatos["estado_id"]=$array[estado_id];
	$arrayDatos["estado_code"]=$array[estado_code];
	$arrayDatos["cuando_estado"]=$array[cuando_estado];
	$arrayDatos["cuando"]=$array[cuando];
	$arrayDatos["uid"]=$array[uid];
	$arrayDatos["cuando_final"]=$array[cuando_final];
	$arrayDatos["uid_final"]=$array[uid_final];
	$arrayDatos["last"]=$array[last];
	};

$arrayNotas=array();

$sqlNotas=SQLdatosTerminoNotas($tema_id);

while($array=mysqli_fetch_array($sqlNotas[datos])){
	if($array[nota_id]){
		array_push($arrayNotas,array(
			"id"=>$array[nota_id],
			"tipoNota"=>$array[tipo_nota],
			"lang_nota"=>$array[lang_nota],
			"nota"=>$array[nota]));
		};
	};
$arrayDatos["notas"]=$arrayNotas;
return $arrayDatos;
}


#
# BUSCADOR DE DATOS DE UN TERMINO Y SUS TERMINOS RELACIONADOS
#
function SQLverTerminoRelaciones($tema_id){

GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

$sql=SQL("select","relaciones.t_relacion,BT.tema_id as id,BT.tema,BT.cuando as t1_cuando,tema.tema_id as id_tema,
	relaciones.id as id_relacion,c.titulo,c.autor,c.idioma
	from $DBCFG[DBprefix]config c, $DBCFG[DBprefix]tema as tema,$DBCFG[DBprefix]tabla_rel as relaciones,$DBCFG[DBprefix]tema as BT
	where
	relaciones.id_menor=tema.tema_id
	and relaciones.id_menor='$tema_id'
	and BT.tema_id=relaciones.id_mayor
	and c.id=BT.tesauro_id
	order by relaciones.t_relacion,lower(BT.tema)");
return $sql;
};


#
# DATOS DE UN TERMINO (id y string) Y SUS TERMINOS RELACIONADOS (id) y tipo de relacion
#
function SQLTerminoRelacionesIDs($tema_id=""){

GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

(@$tema_id) ? $where=" and '$tema_id' in (t1.tema_id,t2.tema_id)" : $where="";

# SQL busca terminos con relaciones TG-TE, UP-USE, TR
$sql=SQL("select","t1.tema_id as id1,t1.tema as tema1,t2.tema_id as id2,t2.tema as t2,rel.t_relacion FROM
$DBCFG[DBprefix]tema t1,$DBCFG[DBprefix]tema t2,$DBCFG[DBprefix]tabla_rel rel
where t1.tema_id=rel.id_mayor
and t2.tema_id=rel.id_menor
and rel.t_relacion in(2,3,4)
$where
group by id1,id2
order by t1.tema_id,rel.t_relacion");

return $sql;
};

#
# BUSCADOR DE TERMINOS RELACIONADOS DE UN TERMINO Y TIPOS DE TERMINOS
#
function SQLverTerminoRelacionesTipo($tema_id){

GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

$sql=SQL("select","relaciones.t_relacion,BT.tema_id as id_tema,BT.tema,
	relaciones.id as id_relacion,if(tipo_term.id is null,'TT','PT') as tipo_termino
	from $DBCFG[DBprefix]tema as tema,$DBCFG[DBprefix]tabla_rel as relaciones,$DBCFG[DBprefix]tema as BT
	left join $DBCFG[DBprefix]tabla_rel as tipo_term on tipo_term.id_menor=BT.tema_id
	where
	relaciones.id_menor=tema.tema_id
	and relaciones.id_menor='$tema_id'
	and BT.tema_id=relaciones.id_mayor
	group by BT.tema_id
	order by relaciones.t_relacion");

return $sql;
};


/*
Buscador de términos aceptados UF,TR y TG directo de tema_id == retrive accepted UF,TR and direct TG for tema_id
* Changelog v 1.1: no traÃ­a los tema_id que están a la derecha de tabla_rel
*/
function SQLterminosDirectos($tema_id){
	GLOBAL $DBCFG;
	//t_relacion in(2,3,4) = TR,TG,UF
	// estado_id = '13' = aceptado / accepted

$tema_id=secure_data($tema_id,"sql");
	
return SQL("select","if(t1.tema_id='$tema_id',t2.tema_id,t1.tema_id) as tema_id,
	if(t1.tema_id='$tema_id',t2.tema,t1.tema) as tema,
	rel.t_relacion 
	FROM
	$DBCFG[DBprefix]tabla_rel rel
	left join $DBCFG[DBprefix]tema t1 on t1.tema_id=rel.id_menor
	left join $DBCFG[DBprefix]tema t2 on t2.tema_id=rel.id_mayor
	where 
	rel.t_relacion in(2,3,4)
	and '$tema_id' in (rel.id_mayor,rel.id_menor)
	and rel.t_relacion in(2,3,4)
	and t1.estado_id='13'
	and t2.estado_id='13'
	group by t1.tema_id,t2.tema_id
	order by rel.t_relacion,lower(t1.tema)");	
};


#
# lista de términos ACEPTADOS totales (prederidos, no preferidos y mapeados) con el tema_id del referido
#
function SQLlistaTemas($tema_id="0"){
GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

//Control de estados
// (!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" where tema.estado_id='13' " : $where="";

$sql=SQL("select","tema.tema_id as id,tema.tema,tema.cuando,tema.uid,tema.cuando_final,r.t_relacion,r.id_menor as tema_id_referido
	from $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as r on tema.tema_id = r.id_mayor
	and r.t_relacion in (4,5,6,7,8)
	where tema.estado_id='13'
	group by tema.tema_id
	order by lower(tema.tema)");
return $sql;
};



#
# TERMINOS TOPES
#
function SQLverTopTerm(){
GLOBAL $DBCFG;

//Control de estados
(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and TT.estado_id='13' " : $where="";

$sql=SQL("select","TT.tema_id as id,TT.tema,TT.code,TT.tema_id
	from $DBCFG[DBprefix]tabla_rel as relaciones,$DBCFG[DBprefix]tema as TT
	left join $DBCFG[DBprefix]tabla_rel as no_menor on no_menor.id_menor=TT.tema_id
	and no_menor.t_relacion='3'
	where
	TT.tema_id=relaciones.id_mayor
	$where
	and relaciones.t_relacion='3'
	and no_menor.id is null
	group by TT.tema_id
	order by lower(TT.code),lower(TT.tema)
	");
return $sql;
};



#
# TERMINOS LIBRES
#
function SQLverTerminosLibres($tema_id="0"){

GLOBAL $DBCFG;

GLOBAL $CFG;

if($tema_id!=="0"){	
	$tema_id=secure_data($tema_id,"sql");
	$where=" and TT.tema_id='$tema_id'";
	}


$show_code=($CFG["_USE_CODE"]=='1') ? 'TT.code,' : '';

	
$sql=SQL("select","TT.tema_id, $show_code TT.tema,TT.cuando
			from $DBCFG[DBprefix]tema as TT
			left join $DBCFG[DBprefix]tabla_rel as no_menor on no_menor.id_menor=TT.tema_id
			left join $DBCFG[DBprefix]tabla_rel as no_mayor on no_mayor.id_mayor=TT.tema_id
			where
			no_menor.id is null
			and no_mayor.id is null
			$where
			order by lower(TT.tema)");
return $sql;
};



#
# Buscador de términos iguales
#
function SQLverTerminosRepetidos(){
GLOBAL $DBCFG;
$sql=SQL("select","tema.tema,count(*) as cant
	from $DBCFG[DBprefix]tema as tema
	group by tema.tema
	having cant >1
	order by cant desc,lower(tema.tema)");
return $sql;
};


#
# BUSCADOR DE TERMINOS especÃ­ficos de un término general
#
function SQLverTerminosE($tema_id){
GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

//Control de estados
(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and tema.estado_id='13' " : $where="";

$sql=SQL("select","tema.tema_id as id_tema,tema.code,tema.tema,relaciones.id as id_relacion,rel_abajo.id as id_te,relaciones.t_relacion
	from $DBCFG[DBprefix]tabla_rel as relaciones,$DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as rel_abajo on rel_abajo.id_mayor=tema.tema_id
	and rel_abajo.t_relacion='3'
	where relaciones.t_relacion='3'
	and relaciones.id_mayor='$tema_id'
	and relaciones.id_menor=tema.tema_id
	$where
	group by tema.tema_id
	order by lower(tema.code),lower(tema.tema)");
return $sql;
};


#
# Lista  de letras
#
function SQLlistaABC($letra=""){
GLOBAL $DBCFG;
//Control de estados
(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" where tema.estado_id='13' " : $where="";

$sql=SQL("select","ucase(LEFT(tema.tema,1)) as letra_orden,
	if(LEFT(tema.tema,1)='$letra', 1,0) as letra
	from $DBCFG[DBprefix]tema as tema
	$where
	group by letra_orden
	order by letra_orden");
return $sql;
};


#
# Lista de términos de una letra
#
function SQLmenuABC($letra){
GLOBAL $DBCFG;

$letra=secure_data($letra,"sql");

/*
 * alternative REGEXP for non alphabetic
LEFT(tema.tema,1) REGEXP '[^[:alpha:]]'
*/

/*
$where_letter=(ctype_alpha($letra)) ? " LEFT(tema.tema,1)='$letra' " : " LEFT(tema.tema,1) REGEXP '[[:digit:]]' ";
*/
$where_letter=(!ctype_digit($letra)) ? " LEFT(tema.tema,1)='$letra' " : " LEFT(tema.tema,1) REGEXP '[[:digit:]]' ";

//Control de estados
(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and tema.estado_id='13' " : $where="";

$sql=SQL("select","if(relaciones.id is not null,relaciones.id_menor,tema.tema_id) id_definitivo, 
		tema.tema_id,
		tema.tema,
		tema.estado_id,
		relaciones.t_relacion,
		temasPreferidos.tema as termino_preferido		
		from $DBCFG[DBprefix]tema as tema
		left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id and relaciones.t_relacion in (4,5,6,7,8)
		left join $DBCFG[DBprefix]tema as temasPreferidos on temasPreferidos.tema_id=relaciones.id_menor
		and tema.tema_id=relaciones.id_mayor
		where
		$where_letter
		$where
		group by tema.tema_id
		order by lower(tema.tema)");
		
		return $sql;
};

#
# Lista de términos de una secuencia de letras sin importar relaciones
#
function SQLbuscaTerminosSimple($string,$limit="20"){
GLOBAL $DBCFG;

$string=trim($string);

$string=secure_data($string,"sql");

//Control de estados
(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and t.estado_id='13' " : $where="";

$sql=SQL("select","t.tema_id,
				t.tema
			from $DBCFG[DBprefix]tema as t
			where
				t.tema like '$string%'
				$where
			group by t.tema	
			order by lower(t.tema)
			limit 0,$limit");
return $sql;
};


#
# Lista de Ids de términos válidos y aceptados (sin UF ni términos libres)
#
function SQLIdTerminosValidos(){
GLOBAL $DBCFG;

//Solo término aceptados
$where=" and tema.estado_id='13' ";

$sql=SQL("SELECT","tema.tema_id as id,tema.cuando,tema.uid,tema.cuando_final
	from $DBCFG[DBprefix]tema as tema,$DBCFG[DBprefix]tabla_rel as relaciones
	where
	tema.tema_id in (relaciones.id_menor,relaciones.id_mayor)
	and relaciones.t_relacion!='4'
	$where
	group by tema.tema_id
	order by lower(tema.tema)");
return $sql;
};


#
# Lista de términos válidos (sin UF ni términos libres)
#
function SQLTerminosValidos($tema_id=""){
GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

(@$tema_id) ? $where=" and tema.tema_id='$tema_id' " : $where="";

//Control de estados
(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where.=" and tema.estado_id='13' " : $where=$where;

$sql=SQL("SELECT","tema.tema_id as id,tema.tema,tema.cuando,tema.uid,tema.cuando_final
	from $DBCFG[DBprefix]tema as tema,$DBCFG[DBprefix]tabla_rel as relaciones
	where
	tema.tema_id in (relaciones.id_menor,relaciones.id_mayor)
	and relaciones.t_relacion!='4'
	$where
	group by tema.tema_id
	order by lower(tema.tema)");
return $sql;
};



#
# Lista de Ids de términos válidos y aceptados (sin UF ni términos libres) y con TE
#
function SQLIdTerminosIndice(){
GLOBAL $DBCFG;

//Solo término aceptados
$where=" and t.estado_id='13' ";

$sql=SQL("SELECT","t.tema_id as id,t.tema_id as tema_id,t.cuando,t.uid,t.cuando_final,i.indice
	from $DBCFG[DBprefix]tema as t,$DBCFG[DBprefix]indice as i
	where
	t.tema_id =i.tema_id
	$where");
return $sql;
};


#
# Lista de términos válidos (sin UF )
#
function SQLTerminosPreferidos($tema_id=""){
GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

(@$tema_id) ? $where=" and tema.tema_id='$tema_id' " : $where="";

//Control de estados
(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where.=" and tema.estado_id='13' " : $where=$where;

$sql=SQL("SELECT","tema.tema_id as id,tema.tema,tema.cuando,tema.uid,tema.cuando_final
	from $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on tema.tema_id = relaciones.id_mayor
	and relaciones.t_relacion='4'
	where
	relaciones.id is null
	$where
	group by tema.tema_id
	order by lower(tema.tema)");
return $sql;
};


#
# lista de términos según fechas
#
function SQLlistTermsfromDate($month,$year,$ord=""){
GLOBAL $DBCFG;

switch($ord){
	case 'F':
	$orderBy=" order by tema.cuando desc";
	break;

	case 'U':
	$orderBy=" order by usuario.APELLIDO,tema.cuando desc";
	break;

	case 'T':
	$orderBy=" order by tema.tema,tema.cuando desc";
	break;

	default:
	$orderBy=" order by tema.cuando desc";

}
	$codUP=UP_acronimo;

	$month=secure_data($month,"sql");
	$year=secure_data($year,"sql");

	$sql=SQL("select","if(relaciones.t_relacion=4,relaciones.id_menor,tema.tema_id) as id_tema,
		if(relaciones.t_relacion=4,concat(tema.tema,' ($codUP)'),tema.tema) as tema,
		tema.cuando,
		usuario.id as id_usuario,usuario.apellido,usuario.nombres,usuario.orga
		from $DBCFG[DBprefix]usuario as usuario,$DBCFG[DBprefix]tema as tema
		left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id
		where
		tema.uid=usuario.id
		and month(tema.cuando) ='$month'
		and year(tema.cuando) ='$year'
		group by tema.tema_id
	$orderBy");

	return $sql;
};


#
# lista de términos recientes
#
function SQLlastTerms($limit="30"){
GLOBAL $DBCFG;
$codUP=UP_acronimo;

$limit=secure_data($limit,"sql");

$sql=SQL("select","if(relaciones.t_relacion=4,relaciones.id_menor,tema.tema_id) as tema_id,
	if(relaciones.t_relacion=4,concat(tema.tema,' ($codUP)'),tema.tema) as tema,
	tema.cuando,tema.cuando_final
	from $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id
	group by tema.tema_id
	order by tema.cuando_final,tema.cuando desc
	limit $limit");

return $sql;
};



#
# lista de términos según estados 
#
function SQLterminosEstado($estado_id,$limite=""){
GLOBAL $DBCFG;

$codUP=UP_acronimo;

if(@$limite)
{
	$limite=secure_data($limite,"sql");
	$limit= " limit 0,$limite";
}
	

$sql=SQL("select","if(relaciones.t_relacion=4,relaciones.id_menor,tema.tema_id) as tema_id,
	if(relaciones.t_relacion=4,concat(tema.tema,' ($codUP)'),tema.tema) as tema,tema.estado_id,
	tema.cuando,tema.cuando_final
	from $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id
	where tema.estado_id='$estado_id'
	group by tema.tema_id
	order by tema.cuando_final,tema.cuando desc
	$limit");

return $sql;
};


#
# Lista de términos según meses y aÃ±os
#
function SQLtermsByDate(){

GLOBAL $DBCFG;

$sql=SQL("select","year(tema.cuando) as years,month(tema.cuando) as months,tema.cuando,count(*) as cant
from $DBCFG[DBprefix]tema as tema
group by year(tema.cuando),month(tema.cuando)
order by year(tema.cuando),month(tema.cuando)");
return $sql;
};

#
# Lista de datos según usuarios
#
function SQLdatosUsuarios($user_id=""){
GLOBAL $DBCFG;
if($id){
	$where=" where usuario.id='$user_id'";
	};
$sql=SQL("select","usuario.id,usuario.apellido,usuario.nombres,usuario.orga,usuario.mail,usuario.cuando,usuario.hasta,usuario.estado,usuario.pass,if(usuario.estado=1,'caducar','habilitar') as enlace, count(tema.tema_id) as cant_terminos
	from $DBCFG[DBprefix]usuario as usuario
	left join $DBCFG[DBprefix]tema as tema on tema.uid=usuario.id
	$where
	group by usuario.id
	order by usuario.apellido");
return $sql;
};

#
# Lista de términos según usuarios
#
function SQLlistTermsfromUser($id_user,$ord=""){
GLOBAL $DBCFG;
switch($ord){
	case 'F':
	$orderBy=" order by tema.cuando desc";
	break;

	case 'U':
	$orderBy=" order by usuario.APELLIDO,tema.cuando desc";
	break;

	case 'T':
	$orderBy=" order by tema.tema,tema.cuando desc";
	break;

	default:
	$orderBy=" order by tema.cuando desc";
	}
$codUP=UP_acronimo;

$id_user=secure_data($id_user,"sql");

$sql=SQL("select","if(relaciones.t_relacion=4,relaciones.id_menor,tema.tema_id) as id_tema,
	if(relaciones.t_relacion=4,concat(tema.tema,' ($codUP)'),tema.tema) as tema,
	tema.cuando,
	usuario.id as id_usuario,usuario.apellido,usuario.nombres,usuario.orga
	from $DBCFG[DBprefix]usuario as usuario,$DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id
	where
	tema.uid=usuario.id
	and usuario.id ='$id_user'
	group by tema.tema_id
	$orderBy");
return $sql;
}


#
# Resúmen de datos del tesauro
#
function ARRAYresumen($id_tesa,$tipo,$idUser=""){


$sql_cant_rel=SQLcantTR($tipo,$idUser);

while($cant_rel=mysqli_fetch_row($sql_cant_rel[datos])){
	if($cant_rel[0]=='2')
	{
		$cant_terminos_relacionados=$cant_rel[1];
	}
	elseif($cant_rel[0]=='4')
	{
		$cant_terminos_up=$cant_rel[1];
	};
};

$sql_cant_term=SQLcantTerminos($tipo,$idUser);
$cant_term=mysqli_fetch_array($sql_cant_term[datos]);


$sqlCantNotas=SQLcantNotas();
while ($arrayCantNotas=mysqli_fetch_array($sqlCantNotas[datos])) 
{
	$cant_notas[$arrayCantNotas[tipo_nota]] = $arrayCantNotas[cant];
}


$ARRAYcant_term2tterm=ARRAYcant_term2tterm();

$resumen=array("cant_rel"=>$cant_terminos_relacionados,
			"cant_up"=>$cant_terminos_up,
			"cant_total"=>$cant_term[cant],
			"cant_candidato"=>$cant_term[cant_candidato],
			"cant_rechazado"=>$cant_term[cant_rechazado],
			"cant_notas"=>$cant_notas,
			"cant_term2tterm"=>$ARRAYcant_term2tterm[cant]
			);
return $resumen;
};


#
# Sql que arma arbol de temas
#
function SQLarbolTema($tema_id){
GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

$ARRAYtema_indice=ARRAYIndexTema($tema_id);
if($ARRAYtema_indice){
	$temas_ids=str_replace('|', ',',$ARRAYtema_indice[indice]);
	$temas_ids=substr($temas_ids,1);

	$sql=SQL("select","t.tema_id as tema_id,t.tema
		from $DBCFG[DBprefix]tema t
		where t.tema_id in ($temas_ids)
		order by FIELD(t.tema_id, $temas_ids)");
	return $sql;
	};
};



#
# SQL lista terminos que contienen en algún momento de sus arbol un tema
#
function SQLtieneTema($tema_id){
GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

$sql=SQL("select","i.tema_id,i.indice from $DBCFG[DBprefix]indice i where i.indice like '%|$tema_id|%'");
return $sql;
};



#
# array de tema y el indice de su arbol
#
function ARRAYIndexTema($tema_id){

GLOBAL $DBCFG;
	
$tema_id=secure_data($tema_id,"sql");

$sql=SQL("select","i.tema_id,i.indice from $DBCFG[DBprefix]indice i where i.tema_id='$tema_id'");	
	return mysqli_fetch_array($sql[datos]);
};


#
# sql de expansiÃ³n sobre un tema (expansiÃ³n hacia arriba expansio to TG)
#
function SQLexpansionTema($tema_id){
GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

//Control de estados
(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and t.estado_id='13' " : $where="";

return SQL("select","t.tema_id as tema_id,t.tema,i.indice,length(i.indice) as distancia
from $DBCFG[DBprefix]indice i,$DBCFG[DBprefix]tema t
where i.indice like '%|$tema_id%'
and i.tema_id=t.tema_id
$where
order by distancia");
};


#
# sql de expansiÃ³n sobre una lista de ids hacia temas relacionados (expansion to TR)
#
function SQLexpansionTR($lista_temas_id){
GLOBAL $DBCFG;
$id_TR=id_TR;

//Control de estados
(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and t.estado_id='13' " : $where="";

return SQL("select","t.tema_id as tema_id,t.tema, count(t.tema_id) as cant_rel
	from $DBCFG[DBprefix]tema t, $DBCFG[DBprefix]tabla_rel tr
	where
	tr.id_menor in ($lista_temas_id)
	and tr.id_mayor=t.tema_id
	and t.tema_id not in ($lista_temas_id)
	and tr.t_relacion='$id_TR'
	$where
	group by t.tema_id
	order by cant_rel,t.tema");
};


#
# sql de busqueda sobre una lista de ids
#
function SQLlistaTema_id($lista_temas_id){
GLOBAL $DBCFG;

//Control de estados
(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and t.estado_id='13' " : $where="";

return SQL("select","t.tema_id as tema_id,t.tema from $DBCFG[DBprefix]tema t where t.tema_id in ($lista_temas_id) $where order by t.tema");
};

#
# sql de datos de tesauro
#
function SQLdatosVocabulario($vocabulario_id=""){
GLOBAL $DBCFG;
if(@$vocabulario_id){
	$where=" where id='$vocabulario_id'";
	}
return SQL("select","id as vocabulario_id,titulo,autor,idioma,cobertura,keywords,tipo,cuando,url_base,polijerarquia from $DBCFG[DBprefix]config $where order by vocabulario_id");
};


#
# sql de datos inversos de un UF o todos los UF
#
function SQLterminosValidosUF($tema_id="0"){
GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");

$where=($tema_id!=="0") ? " and relaciones.id_mayor='$tema_id' " : " ";

return SQL("select","relaciones.t_relacion,
			t1.tema_id as tema_pref_id,
			t1.tema as tema_pref,
			t2.tema_id as tema_id,
			t2.tema,
			c.id as vocabulario_id,
			c.titulo,c.autor,c.idioma
			from $DBCFG[DBprefix]config c, $DBCFG[DBprefix]tema as t1,$DBCFG[DBprefix]tabla_rel as relaciones,$DBCFG[DBprefix]tema as t2
			where
			relaciones.id_menor=t1.tema_id
			$where
			and t2.tema_id=relaciones.id_mayor
			and c.id=t2.tesauro_id
			and t_relacion in ('4','5','6','7')
			group by t2.tema_id
			order by relaciones.t_relacion,tema");
};


function ARRAYdatosUser($user_id){
GLOBAL $DBCFG;
$sql=SQL("select","u.id,u.id as user_id,u.apellido,u.nombres,u.orga,u.mail,u.cuando,u.hasta,u.estado,u.pass, if(u.estado=1,'caducar','habilitar') as enlace,u.nivel from $DBCFG[DBprefix]usuario u where u.id='$user_id'");
return mysqli_fetch_array($sql[datos]);
}



#
# Busca lista de términos para evaluar similitud de una expresiona de búsqueda
#
function SQLsimiliar($texto,$lista_temas_id="0"){
GLOBAL $DBCFG;
/*
El termino a evaluar debe ser mayor o menor en no más de 2 caracteres con respecto al texto de búsqueda
El termino a evaluar no debe estar en la lista de resultados
13 = estado aceptado
*/
$texto=trim($texto);


$maxstrlen = strlen($texto)+2;
$minstrlen = strlen($texto)-2;

//Hubo resultados de búsqueda
if(count(explode("|",$lista_temas_id))>1){

	$lista_temas_id=str_replace("|",",",$lista_temas_id);
	$lista_temas_id=substr($lista_temas_id,0,-1);
	$where = " 	and t.tema_id not in ($lista_temas_id) ";
	} else {
	$where = "";
	}

$sql=SQL("select","t.tema,length(t.tema) as largo
		from $DBCFG[DBprefix]tema as t
		where
		length(t.tema) between $minstrlen and $maxstrlen
		and t.estado_id ='13'
		$where
		order by tema,largo","1");
return $sql;
};


/*
 * Verificar que no sea un no-termino o un término de otro vocabularios. Check if isnt no-term
 * Verficar que sea un término válido para relaciones y notas > no (UF,EQ,EQP,NEQ)
 */
function SQLcheckIsValidTerm($tema_id)
{
	GLOBAL $DBCFG;
	
	$tema_id=secure_data($tema_id,"sql");
	
	return SQL("select","id, 
			id_mayor,
			id_menor,
			t_relacion 
			from $DBCFG[DBprefix]tabla_rel 
			where t_relacion in ('4','5','6','7') 
			and id_mayor='$tema_id'");
};


/*
 * Search free terms for associate as UF or NT. Created by SafetyLit and Monarch Media 
 * 
*/
function SQLsearchFreeTerms($search_term){

GLOBAL $DBCFG;

$search_term=secure_data($search_term,"sql");

return SQL("select","TT.tema_id as id,TT.tema
			from $DBCFG[DBprefix]tema as TT
			left join $DBCFG[DBprefix]tabla_rel as no_menor on no_menor.id_menor=TT.tema_id
			left join $DBCFG[DBprefix]tabla_rel as no_mayor on no_mayor.id_mayor=TT.tema_id
			where
			no_menor.id is null
			and no_mayor.id is null
			and TT.estado_id='13'
			and TT.tesauro_id='$_SESSION[id_tesa]'
			and TT.tema like '%$search_term%'
			order by TT.tema");
};



//Retrive simple term data for code
function ARRAYCode($code) 
{
	GLOBAL $DBCFG;
	
	$code=secure_data($code,"sql");

	$sql=SQL("select","t.tema_id,t.tema,t.code 
	from $DBCFG[DBprefix]tema t where t.code='$code'");
	//return $sql;
	return mysqli_fetch_array($sql[datos]);
}


#
# Retrive summary about deep terms
#
function SQLTermDeep($tema_id="0") 
{
	GLOBAL $DBCFG;
	
	$w=($tema_id>0) ? " where i.tema_id='$tema_id'" : "";
	
	return SQL("select","LENGTH(i.indice) - LENGTH(REPLACE(i.indice, '|', '')) AS tdeep, count(*) as cant
		from $DBCFG[DBprefix]indice i
		$w
		group by tdeep
		order by tdeep");
}

#
# SQL for advanced search
#
function SQLadvancedSearch($array)
{
GLOBAL $DBCFG;

#has top term X
$array[hasTopTerm]=secure_data($array[hasTopTerm],"sql");
if($array[hasTopTerm]>0)
{
	$size_i=strlen($array[hasTopTerm])+2;
	$from=",$DBCFG[DBprefix]indice tti";
	$where="	and t.tema_id=tti.tema_id";
	$where.="	and left(tti.indice,$size_i)='|$array[hasTopTerm]|'";
}

#has note type X
$array[hasNote]=secure_data($array[hasNote],"sql");
if($array[hasNote])
{
	$from.=",$DBCFG[DBprefix]notas n";
	$where.="		and n.id_tema=t.tema_id";
	$where.="		and n.tipo_nota='$array[hasNote]'";
}

#time filter
$array[fromDate]=secure_data($array[fromDate],"sql");
if($array[fromDate])
{
	$where.="		and (t.cuando between '$array[fromDate]-01' and now())";
}


#deep level
$array[termDeep]=secure_data($array[termDeep],"sql");
if($array[termDeep]>0)
{
	$select=",LENGTH(i.indice) - LENGTH(REPLACE(i.indice, '|', '')) AS tdeep";
	$from.=	"	,$DBCFG[DBprefix]indice i";
	$where.="	and t.tema_id=i.tema_id";
	$having.="	having tdeep='$array[termDeep]'";
}

/*
#is UF
if($array[isUF]=='1')
{
	$select.=",UFt.tema_id as uf_tema_id,UFt.tema as uf_tema,r.t_relacion";
	$from.=	"	,$DBCFG[DBprefix]tabla_rel r";
	$from.=	"	,$DBCFG[DBprefix]tema UFt";
	$where.="	and r.id_menor=t.tema_id";
	$where.="	and r.id_mayor=UFt.tema_id";
	$where.="	and r.t_relacion='4'";
}
 
*/
#time update filter
#and (cuando_final between '2010-05-19' and now())

$array[xstring]=secure_data($array[xstring],"sql");
switch ($array[ws]) {
	case 't'://term
	$initial_where=($array[isExactMatch]=='1') ? " t.tema='$array[xstring]' " : " t.tema like '%$array[xstring]%' ";
	break;

	case 'uf':// no term
	$initial_where=($array[isExactMatch]=='1') ? " UFt.tema='$array[xstring]' " : " UFt.tema like '%$array[xstring]%' ";
	$select.=",UFt.tema_id as uf_tema_id,UFt.tema as uf_tema,r.t_relacion";
	$from.=	"	,$DBCFG[DBprefix]tabla_rel r";
	$from.=	"	,$DBCFG[DBprefix]tema UFt";
	$where.="	and r.id_menor=t.tema_id";
	$where.="	and r.id_mayor=UFt.tema_id";
	$where.="	and r.t_relacion='4'";
	break;

	case 'c':// code
	$initial_where=($array[isExactMatch]=='1') ? " t.code='$array[xstring]' " : " t.code like '%$array[xstring]%' ";
	break;

	case 'n':// note
	$initial_where=($array[isExactMatch]=='1') ? " ns.nota='$array[xstring]' " : " ns.nota like '%$array[xstring]%' ";
	$from.=	"	,$DBCFG[DBprefix]notas ns";
	$where.="	and t.tema_id=ns.id_tema";
	break;

	case 'tgt':// target term from target vocabulary (foreign term)
	$initial_where=($array[isExactMatch]=='1') ? " tt.tterm_string='$array[xstring]' " : " tt.tterm_string like '%$array[xstring]%' ";
	$from.=	"	,$DBCFG[DBprefix]term2tterm tt";
	$where.="	and t.tema_id=tt.tema_id";
	break;

	default ://term
	$initial_where=($array[isExactMatch]=='1') ? " t.tema='$array[xstring]' " : " t.tema like '%$array[xstring]%' ";

	break;
}



return SQL("select","t.tema_id,t.tema,t.cuando,t.cuando_final,t.estado_id $select		
		from $DBCFG[DBprefix]tema t		
		$from
		where 
		$initial_where		
		$where
		group by t.tema_id
		$having		
		order by t.tema");
}




#
# SQL for term reporter
#
function SQLadvancedTermReport($array)
{
GLOBAL $DBCFG;
GLOBAL $CFG;

#has top term X
$array[hasTopTerm]=secure_data($array[hasTopTerm],"sql");
if($array[hasTopTerm]>0)
{
	$size_i=strlen($array[hasTopTerm])+2;
	$from="$DBCFG[DBprefix]indice tti,";
	$where="	and t.tema_id=tti.tema_id";
	$where.="	and left(tti.indice,$size_i)='|$array[hasTopTerm]|'";
}

#has note type X
$array[hasNote]=secure_data($array[hasNote],"sql");
if($array[hasNote])
{
	$from.="$DBCFG[DBprefix]notas n,";
	$where.="		and n.id_tema=t.tema_id";
	$where.="		and n.tipo_nota='$array[hasNote]'";
}

#time filter
$array[fromDate]=secure_data($array[fromDate],"sql");
if($array[fromDate])
{
	$where.="		and (t.cuando between '$array[fromDate]-01' and now())";
}
#time update filter
#and (cuando_final between '2010-05-19' and now())

#user filter
$array[byuser_id]=secure_data($array[byuser_id],"sql");
if(($array[byuser_id]) && ($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]=='1'))
{
	$where.="		and '$array[byuser_id]' in (t.uid,t.uid_final)";
}


#string filter
$array[csvstring]=secure_data(trim($array[csvstring]),"sql");
if((strlen($array[csvstring])>1) && (in_array($array[w_string],array('s','e'))))
{
	if ($array[w_string]=='s') 
	{
		$where.="		and (t.tema like '% $array[csvstring]%' or t.tema like '$array[csvstring]%')";
	}
	else 
	{
		$where.="		and (t.tema like '%$array[csvstring] %' or t.tema like '%$array[csvstring]')";		
	}
	
}


#mapped terms
$array[csv_tvocab_id]=secure_data($array[csv_tvocab_id],"sql");
if($array[csv_tvocab_id]) 
{
	if ($array[mapped]=='n') 
	{	
		$leftJoin=" left join $DBCFG[DBprefix]term2tterm tt on tt.tema_id=t.tema_id and tt.tvocab_id='$array[csv_tvocab_id]'";
		$leftJoin.=" left join $DBCFG[DBprefix]tabla_rel as r on t.tema_id in (r.id_menor,r.id_mayor) ";
		$leftJoin.=" and r.t_relacion in (4,5,6,7)";
		$where.=" and	r.id is null";
		$where.=" and tt.tterm_id is null";
		$where.=" and t.tesauro_id='$_SESSION[id_tesa]'";	
	}
	else 
	{
		$select=" ,tv.tvocab_title as target_vocabulary_title,tt.tterm_string as target_vocabulary_term,tt.cuando as date_mapped";
		$from.=" $DBCFG[DBprefix]tvocab tv,$DBCFG[DBprefix]term2tterm tt,";
		$where.=" and tt.tema_id=t.tema_id and tt.tvocab_id='$array[csv_tvocab_id]'";
		$where.=" and tt.tvocab_id=tv.tvocab_id";
	}
}

$LABEL_Candidato=LABEL_Candidato;
$LABEL_Aceptado=LABEL_Aceptado;
$LABEL_Rechazado=LABEL_Rechazado;

$show_code=($CFG["_USE_CODE"]=='1') ? 't.code,' : '';


return SQL("select","t.tema_id, $show_code t.tema,t.cuando as created_date,if(t.cuando_final is null,t.cuando,t.cuando_final) last_change,
		elt(field(t.estado_id,'12','13','14'),'$LABEL_Candidato','$LABEL_Aceptado','$LABEL_Rechazado') as status,concat(u.APELLIDO,', ',u.NOMBRES) as user_data $select		
		from $from $DBCFG[DBprefix]values v,$DBCFG[DBprefix]usuario u, $DBCFG[DBprefix]tema t
		$leftJoin
		where t.uid=u.id 
		and t.estado_id=v.value_id
		and v.value_type='t_estado'
		$initial_where		
		$where
		group by t.tema_id
		$having		
		order by t.tema");
}

/*
regenerate indice table => only in case of corrupt database or import thesaurus vÃ­a dump
*/
function SQLreCreateTermIndex() 
{
 
 GLOBAL $DBCFG;
 
 $sqlTerminosValidos=SQLIdTerminosValidos();

 $sqlTruncate=SQL("truncate","$DBCFG[DBprefix]indice");

  while($array=mysqli_fetch_row($sqlTerminosValidos[datos])){
	$i=++$i;
	
	$este_tema_id=$array[0];
	$tema_ids_inverso=generaIndices($array[0]);
  	$tema_ids_inverso=array_reverse(explode("|",$tema_ids_inverso));
	foreach($tema_ids_inverso as $tema_id){
		$indice[$este_tema_id].='|'.$tema_id;
		}
  	$esteindice=substr($indice[$este_tema_id],1);
	
	$sql=SQL("insert","into $DBCFG[DBprefix]indice values ('$array[0]','$esteindice')");
    };
    
    return array("cant_terms_index"=>$i);
}


#
# Optimiza tablas == $tablas
#
function SQLoptimizarTablas($tablas){

GLOBAL $DBCFG;

$db = mysqli_connect("$DBCFG[Server]", "$DBCFG[DBLogin]", "$DBCFG[DBPass]");

mysqli_select_db($db,"$DBCFG[DBName]");

$sql=mysqli_query($db,"OPTIMIZE TABLE $tablas");

return $sql;
};



#
# actualiza version // update version
#
function SQLupdateTemaTresVersion($ver2ver){

GLOBAL $DBCFG;

$linkDB = mysqli_connect("$DBCFG[Server]", "$DBCFG[DBLogin]", "$DBCFG[DBPass]");

$prefix=$DBCFG['DBprefix'] ;


// Si se establecio un charset para la conexion
if(@$DBCFG["DBcharset"]){
	mysqli_query($linkDB,"SET NAMES $DBCFG[DBcharset]");
	}

mysqli_select_db($linkDB,"$DBCFG[DBName]");


switch ($ver2ver) {
	case '1_1x1_2' :
		$result61 = mysqli_query($linkDB,"CREATE TABLE IF NOT EXISTS `".$prefix."term2tterm` (
			 `tterm_id` int(22) NOT NULL AUTO_INCREMENT,
			  `tvocab_id` int(22) NOT NULL,
			  `tterm_url` varchar(200) NOT NULL,
			  `tterm_uri` varchar(200) NOT NULL,
			  `tterm_string` varchar(250) NOT NULL,
			  `cuando` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  `cuando_last` timestamp NULL DEFAULT NULL,
			  `uid` int(22) NOT NULL,
			  `tema_id` int(22) NOT NULL,
			  PRIMARY KEY (`tterm_id`),
			  KEY `tvocab_id` (`tvocab_id`,`cuando`,`cuando_last`,`uid`),
			  KEY `tema_id` (`tema_id`),
			  KEY `tterm_string` (`tterm_string`)
			) ENGINE=MyISAM") ;

		$result62 = mysqli_query($linkDB,"CREATE TABLE IF NOT EXISTS `".$prefix."tvocab` (
				  `tvocab_id` int(22) NOT NULL AUTO_INCREMENT,
				  `tvocab_label` varchar(150) NOT NULL,
				  `tvocab_tag` varchar(5) NOT NULL,
				  `tvocab_lang` VARCHAR( 5 ),
				  `tvocab_title` varchar(200) NOT NULL,
				  `tvocab_url` varchar(250) NOT NULL,
				  `tvocab_uri_service` varchar(250) NOT NULL,
				  `tvocab_status` tinyint(1) NOT NULL,
				  `cuando` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  `uid` int(22) NOT NULL,
				  PRIMARY KEY (`tvocab_id`),
				  KEY `uid` (`uid`),
				  KEY `status` (`tvocab_status`)
				) ENGINE=MyISAM ;") ;

		$result622 = mysqli_query($linkDB,"ALTER TABLE `".$prefix."notas` ADD FULLTEXT `notas` (`nota`);");		

	$logTask["1_1x1_2"] = $result61+$result62+$result622;
	break;

	default :
	return false;
	break;
	}

	return $logTask;
}





function ARRAYtargetVocabulary($tvocab_id)
{
GLOBAL $DBCFG;
$sql=SQLtargetVocabulary("X",$tvocab_id);

return mysqli_fetch_array($sql[datos]);
}

/*
data about target vocabularies providers
*/
function SQLtargetVocabulary($tvocab_status="1",$tvocab_id="0")
{
GLOBAL $DBCFG;

$tvocab_id=secure_data($tvocab_id,"sql");

$tvocab_status=(in_array($tvocab_status,array(1,0))) ? $tvocab_status : 1;

$where= ($tvocab_status=='1') ? " where tv.tvocab_status='1' " : " where tv.tvocab_status is not null";

$where.= ($tvocab_id>0) ? " and tv.tvocab_id='$tvocab_id' " : "";

return SQL("select","tv.tvocab_id,tv.tvocab_label,tv.tvocab_tag,tv.tvocab_lang,
		tv.tvocab_title,tv.tvocab_url,tv.tvocab_uri_service,tv.tvocab_status,tv.cuando,tv.uid,
		count(t2t.tterm_id) as cant
		from $DBCFG[DBprefix]tvocab tv
		left join $DBCFG[DBprefix]term2tterm t2t on tv.tvocab_id=t2t.tvocab_id
		$where
		group by tv.tvocab_id
		order by tv.tvocab_tag,tv.tvocab_title");
}


function SQLtargetTerms($tema_id,$tterm_id="0")
{
GLOBAL $DBCFG;

$tema_id=secure_data($tema_id,"sql");
$tterm_id=secure_data($tterm_id,"sql");

$where = ($tterm_id>0) ? " and t2tt.tterm_id ='$tterm_id' " : "";

return SQL("select","tv.tvocab_id,tv.tvocab_label,tv.tvocab_tag,tv.tvocab_lang,
		tv.tvocab_title,tv.tvocab_url,tv.tvocab_uri_service,tv.cuando as tvoacb_cuando,tv.uid,
		t2tt.tema_id,t2tt.tterm_id,t2tt.tterm_url,t2tt.tterm_uri,t2tt.tterm_string,t2tt.cuando,t2tt.cuando_last
		from $DBCFG[DBprefix]tvocab tv,$DBCFG[DBprefix]term2tterm t2tt
		where tv.tvocab_id=t2tt.tvocab_id
		and t2tt.tema_id='$tema_id'
		$where
		order by tv.tvocab_tag,t2tt.tterm_string");
}


function ARRAYtargetTerm($tema_id,$tterm_id)
{
GLOBAL $DBCFG;

$sql=SQLtargetTerms($tema_id,$tterm_id);

return mysqli_fetch_array($sql[datos]);
}

function SQLtargetTermsVocabulary($tvocab_id,$from="0",$limit="20")
{
GLOBAL $DBCFG;

$tvocab_id=secure_data($tvocab_id,"sql");

$from=(is_numeric($from)) ? $from : "0";

$limit=(is_numeric($limit)) ? $limit : "20";

$idUser=secure_data($idUser,"sql");
return SQL("select","tv.tvocab_id,tv.tvocab_label,tv.tvocab_tag,tv.tvocab_lang,
		tv.tvocab_title,tv.tvocab_url,tv.tvocab_uri_service,tv.cuando,tv.uid,
		t2tt.tterm_id,t2tt.tterm_url,t2tt.tterm_uri,t2tt.tterm_string,t2tt.cuando,t2tt.cuando_last,
		t.tema_id,t.tema
		from $DBCFG[DBprefix]tvocab tv,$DBCFG[DBprefix]term2tterm t2tt,$DBCFG[DBprefix]tema t
		where tv.tvocab_id=t2tt.tvocab_id
		and t2tt.tema_id=t.tema_id
		and tv.tvocab_id='$tvocab_id'
		order by tv.tvocab_tag,t2tt.tterm_string
		limit $from,$limit");
}

/*
terms who arent mapped to specific external target vocabulary 
*/
function SQLtermsNoMapped($tesauro_id,$tvocab_id) 
{
	GLOBAL $DBCFG;
	$tvocab_id=secure_data($tvocab_id,"sql");

	//term no mapped and no UF or EQ
	return SQL("select","t.tema_id,t.tema,t.cuando,t.cuando_final
	from $DBCFG[DBprefix]tema as t
	left join $DBCFG[DBprefix]term2tterm tt on tt.tema_id=t.tema_id and tt.tvocab_id='$tvocab_id' 
	left join $DBCFG[DBprefix]tabla_rel as r on t.tema_id in (r.id_menor,r.id_mayor) 
	and r.t_relacion in (4,5,6,7)
	where
	r.id is null
	and tt.tterm_id is null
	and t.tesauro_id='$tesauro_id'
	group by t.tema_id
	order by lower(t.tema)");
}


/*
terms by status (only candidate or reject)
*/
function SQLtermsXstatus($tesauro_id,$status_id) 
{
	GLOBAL $DBCFG;
	GLOBAL $CFG;
	
	$tesauro_id=secure_data($tesauro_id,"sql");
	
	$status_id=($status_id=='12') ? '12' : '14';	


	$show_code=($CFG["_USE_CODE"]=='1') ? 't.code,' : '';



	//term no mapped and no UF or EQ
	return SQL("select","t.tema_id, $show_code t.tema,t.cuando,concat(u.APELLIDO,', ',u.NOMBRES) as user_data,v.value as status,t.cuando_estado 
	from $DBCFG[DBprefix]usuario u,$DBCFG[DBprefix]values v,$DBCFG[DBprefix]tema as t
	where
	t.tesauro_id='$tesauro_id'
	and u.id=t.uid
	and v.value_id=t.estado_id
	and v.value_type='t_estado'
	and t.estado_id='$status_id'
	order by lower(t.tema)");
}



/*
terms with more than one BT
*/
function SQLpoliBT() 
{
	GLOBAL $DBCFG;
	
	return SQL("select","t.tema_id,t.tema,t.cuando,count(t.tema_id) as cantBT
		from $DBCFG[DBprefix]tema t,$DBCFG[DBprefix]usuario u, $DBCFG[DBprefix]tabla_rel r
		where t.uid=u.id 
		and t.tema_id=r.id_menor
		and t_relacion='3'
		group by t.tema_id
		having cantBT>1
		order by t.tema");
}

?>
