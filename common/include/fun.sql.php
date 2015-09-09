<?php
if ((stristr( $_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) die("no access");
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2013 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#
###############################################################################################################
# funciones de consulta SQL #

#
# Cantidad de términos relacionados generales y por usuarios
#
function SQLcantTR($tipo,$idUser=""){

	GLOBAL $DBCFG;

	$idUser=secure_data($idUser,"int");

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

	$idUser=secure_data($idUser,"int");


	$clausula= ($tipo=='U') ? " where tema.uid='$idUser' " :"";

	return SQL("select","count(tema.tema_id) as cant,count(c.tema_id) as cant_candidato,count(r.tema_id) as cant_rechazado
	from $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tema as c on tema.tema_id=c.tema_id and c.estado_id='12'
	left join $DBCFG[DBprefix]tema as r on tema.tema_id=r.tema_id and r.estado_id='14'
	$clausula");
};


#
# Cantidad de términos generales aprobados y tesauro
#
function ARRAYcantTerms4Thes($tesauro_id){

	GLOBAL $DBCFG;

	$tesauro_id=secure_data($tesauro_id,"int");

	$sql=SQL("select","count(*) as cant
	from $DBCFG[DBprefix]tema t
	where t.estado_id='13'
	and t.tesauro_id='$tesauro_id'");

	$array=(is_object($sql)) ? $sql->FetchRow() : array("cant"=>0);

	return $array;
};


#
# Cantidad de notas generales y por usuarios
#
function SQLcantNotas($user_id="0"){
	GLOBAL $DBCFG;

	$user_id=secure_data($user_id,"int");

	$w = ($user_id>0) ? " and n.uid='$user_id' " : "";


	$sql=SQL("select","count(n.id) as cant, n.tipo_nota,
	v.value_id,v.value_type,v.value,v.value_order,v.value_code
	from $DBCFG[DBprefix]values v
	left join $DBCFG[DBprefix]notas n on v.value_code=n.tipo_nota
	where v.value_type='t_nota'
	$w
	group by v.value_id
	order by v.value_order,v.value_code");
	return $sql;

};

#
# Cantidad de términos mapeados (externos), por usuario y por vocabulario
#
function ARRAYcant_term2tterm($tvocab_id="0",$user_id="0"){

	GLOBAL $DBCFG;

	$user_id=secure_data($user_id,"int");
	$tvocab_id=secure_data($tvocab_id,"int");

	$w = ($user_id>0) ? " and tt.uid='$user_id' " : "";
	$w.= ($user_id>0) ? " and tt.tvocab_id='$tvocab_id' " : "";


	$sql=SQL("select","count(*) as cant
	from $DBCFG[DBprefix]term2tterm
	where 1=1 $w");

	return $sql->FetchRow();
};

#
# Búsqueda de términos hacia arriba desde un tema.
#
function SQLbucleArriba($tema_id){
	GLOBAL $DBCFG;

	$tema_id=secure_data($tema_id,"int");

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

	$tema_id=secure_data($tema_id,"int");

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

	$codUP=UP_acronimo;

	//Control de estados
	$where=(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? " and tema.estado_id='13' " : "";

	//Check is include or not meta terms
	$where.=(CFG_SEARCH_METATERM==0) ? " and tema.isMetaTerm=0 " : "";

	$sql=SQLo("select","if(temasPreferidos.tema_id is not null,relaciones.id_menor,tema.tema_id) id_definitivo,
	tema.tema_id,
	tema.tema,
	tema.estado_id,
	relaciones.t_relacion,
	temasPreferidos.tema as termino_preferido,
	if(?=tema.tema,1,0) as rank,
	i.indice,
	v.value_id as rel_rel_id,
	v.value as rr_value,
	v.value_code as rr_code
	from $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id
	left join $DBCFG[DBprefix]tema as temasPreferidos on temasPreferidos.tema_id=relaciones.id_menor
	and tema.tema_id=relaciones.id_mayor
	and relaciones.t_relacion in (4,5,6,7,8)
	left join $DBCFG[DBprefix]indice i on i.tema_id=tema.tema_id
	left join $DBCFG[DBprefix]values v on v.value_id = relaciones.rel_rel_id
	where
	tema.tema like ?
	$where
	group by id_definitivo
	order by rank desc,lower(tema.tema)",array($texto,"%$texto%"));

	return $sql;
};

#
# Buscador general según string
#
function SQLsearchInNotes($texto,$params=array()){
	GLOBAL $DBCFG;

	$texto=trim($texto);

	$codUP=UP_acronimo;

	//Control de estados
	$where=(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? " and tema.estado_id='13' " : "";

	//Check is include or not meta terms
	$where.=(CFG_SEARCH_METATERM==0) ? " and tema.isMetaTerm=0 " : "";

	$sql=SQLo("select","if(temasPreferidos.tema_id is not null,relaciones.id_menor,tema.tema_id) id_definitivo,
	tema.tema_id,
	tema.tema,
	tema.estado_id,
	relaciones.t_relacion,
	temasPreferidos.tema as termino_preferido,
	i.indice,
	v.value_id as rel_rel_id,
	v.value as rr_value,
	v.value_code as rr_code,
	MATCH (n.nota) AGAINST (?) AS relevance
	from $DBCFG[DBprefix]notas as n,
	$DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id
	left join $DBCFG[DBprefix]tema as temasPreferidos on temasPreferidos.tema_id=relaciones.id_menor
	and tema.tema_id=relaciones.id_mayor
	and relaciones.t_relacion in (4,5,6,7,8)
	left join $DBCFG[DBprefix]indice i on i.tema_id=tema.tema_id
	left join $DBCFG[DBprefix]values v on v.value_id = relaciones.rel_rel_id
	where
	n.id_tema=tema.tema_id
	and MATCH (tema.tema,n.nota)
	AGAINST (? IN BOOLEAN MODE)
	$where
	group by tema.tema_id
	order by relevance desc,lower(tema.tema)",array($texto,$texto));

	return $sql;
};

#
# Buscador términos que comienzan según string = terms beginning with string
#
function SQLstartWith($texto){

	GLOBAL $DBCFG;

	$texto=trim($texto);

	$texto=(CFG_SUGGESTxWORD==1) ? secure_data("[[:<:]]$texto","ADOsql") : secure_data("$texto%","ADOsql")  ;

	$codUP=UP_acronimo;

	//Control de estados
	$where=(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? " and tema.estado_id='13' " : "";

	//Check is include or not meta terms
	$where.=(CFG_SEARCH_METATERM==0) ? " and tema.isMetaTerm=0 " : "";


	$where_method=(CFG_SUGGESTxWORD==1) ? 'regexp' : 'like';

	$sql=SQL("select","if(temasPreferidos.tema_id is not null,relaciones.id_menor,tema.tema_id) id_definitivo,
	tema.tema_id,
	tema.tema,
	tema.estado_id,
	relaciones.t_relacion,
	temasPreferidos.tema as termino_preferido,
	i.indice,
	v.value_id as rel_rel_id,
	v.value as rr_value,
	v.value_code as rr_code
	from $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id
	left join $DBCFG[DBprefix]tema as temasPreferidos on temasPreferidos.tema_id=relaciones.id_menor
	and tema.tema_id=relaciones.id_mayor
	and relaciones.t_relacion in (4,5,6,7,8)
	left join $DBCFG[DBprefix]indice i on i.tema_id=tema.tema_id
	left join $DBCFG[DBprefix]values v on v.value_id = relaciones.rel_rel_id
	where
	tema.tema $where_method $texto
	$where
	group by tema.tema_id
	order by lower(tema.tema)");
	return $sql;
};

#
# Buscador general según string SIN UF ni términos EQ
#
function SQLSimpleSearchTrueTerms($texto,$limit="20"){
	GLOBAL $DBCFG;

	$texto=trim($texto);

	//Check is include or not meta terms
	$where=(CFG_SEARCH_METATERM==0) ? " and tema.isMetaTerm=0 " : "";

	return SQLo("select","t.tema as id_definitivo,
	t.tema_id,
	t.tema,
	t.isMetaTerm,
	if(?=t.tema,1,0) as rank,
	i.indice
	from $DBCFG[DBprefix]indice i,$DBCFG[DBprefix]tema t
	left join $DBCFG[DBprefix]tabla_rel r on r.t_relacion in ('4','5','6','7')
	and r.id_mayor=t.tema_id
	where
	t.tema like ?
	and t.estado_id='13'
	and i.tema_id=t.tema_id
	and r.id is null
	$where
	order by rank desc,lower(t.tema)
	limit 0,$limit",array($texto,"%$texto%"));
};


function SQLbuscaExacta($texto){

	GLOBAL $DBCFG;

	GLOBAL $DB;


	$texto=trim($texto);

	$texto=$DB->qstr($texto,get_magic_quotes_gpc());


	$codUP=UP_acronimo;

	//Control de estados
	$where=(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? " and tema.estado_id='13' " : "";

	//Check is include or not meta terms
	$where.=(CFG_SEARCH_METATERM==0) ? " and tema.isMetaTerm=0 " : "";

	$sql=SQL("select","if(relaciones.t_relacion=4,relaciones.id_menor,tema.tema_id) as id_definitivo,tema.tema_id,
	if(relaciones.t_relacion=4,concat(tema.tema,' ($codUP)'),tema.tema) as tema,tema.estado_id,
	relaciones.t_relacion,if(relaciones.id is null and relacionesMenor.id is null,'SI','NO') as esTerminoLibre
	from $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id
	left join $DBCFG[DBprefix]tabla_rel as relacionesMenor on relacionesMenor.id_menor=tema.tema_id
	where
	tema.tema = $texto
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

	$tema_id=secure_data($tema_id,"int");

	//Control de estados
	(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and tema.estado_id='13' " : $where="";

	$sql=SQL("select","tema.tema_id, tema.tema_id as idTema,
	tema.code,
	tema.tema titTema,
	tema.tema,
	tema.estado_id,
	tema.cuando_estado,
	tema.cuando,
	tema.cuando_final,
	tema.isMetaTerm,
	c.idioma,
	c.titulo
	from $DBCFG[DBprefix]tema as tema,
	$DBCFG[DBprefix]config as c
	where
	tema.tema_id='$tema_id'
	and c.id=tema.tesauro_id
	$where");

	return $sql->FetchRow();
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

	return $sql->FetchRow();
};



#
# SQL de datos de notas de un término
#

function SQLdatosTerminoNotas($tema_id,$array_tipo_nota=array()){

	GLOBAL $DBCFG;

	$tema_id=secure_data($tema_id,"int");

	if(count($array_tipo_nota)>0)
	{
		//es una array de tipos de notas
		for($i=0; $i<count($array_tipo_nota);++$i)
		{
			if(in_array($array_tipo_nota[$i],array('NA','NH','NC','NB','NP')))
			{
				$where_in.="'".$array_tipo_nota[$i]."',";
			}
		};
		$where_in=substr("$where_in",0,-1);

		$where=" and notas.tipo_nota in ( $where_in ) ";
		$param_where= $where_in ;
	}

	if(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id])
	$where.=" and notas.tipo_nota!='NP' ";

	return SQL("select","notas.id as nota_id, notas.tipo_nota,notas.nota,notas.lang_nota,notas.cuando,
	tema.tema_id as tema_id,tema.tema,tema.estado_id,tema.cuando_estado,tema.isMetaTerm,
	v.value as ntype, v.value_code as ntype_code,v.value_id as ntype_id
	from $DBCFG[DBprefix]values as v,$DBCFG[DBprefix]notas as notas,$DBCFG[DBprefix]tema as tema
	where
	notas.id_tema=tema.tema_id
	and notas.tipo_nota=v.value_code
	and tema.tema_id='$tema_id'
	$where
	order by v.value_order,notas.tipo_nota,notas.cuando");
};


#
# Búsqueda de términos relacionados candidatos para un término según un string
#
function SQLbuscaTR($tema_id,$string){
	GLOBAL $DBCFG;

	$tema_id=secure_data($tema_id,"int");

	$string=secure_data("%$string%","ADOsql");

	//Solo terminos aceptados == estado_id ='13'

	return SQL("select","if(terminosUP.id is not null,terminosUP.id_menor,tema.tema_id) as tema_id,tema.cuando,
	tema.tema,
	tema.isMetaTerm,
	relaciones.id as idRel
	FROM $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as terminosUP on terminosUP.id_mayor=tema.tema_id
	and terminosUP.t_relacion='4'
	left join $DBCFG[DBprefix]tabla_rel as relaciones on '$tema_id' in (relaciones.id_menor,relaciones.id_mayor)
	and tema.tema_id in (relaciones.id_menor,relaciones.id_mayor)
	WHERE tema.tema
	LIKE $string
	and tema.tema_id!= '$tema_id'
	and tema.estado_id='13'
	and tema.tesauro_id= '$_SESSION[id_tesa]'
	and relaciones.id is null
	and terminosUP.id is null
	ORDER BY lower(tema.tema)");

};


#
# Búsqueda de término relacionado candidato para un término según un string
#
function fetchTermId2RT($string,$tema_id){

	GLOBAL $DBCFG;

	$tema_id=secure_data($tema_id,"int");
	$thes_id=secure_data($_SESSION[id_tesa],"int");
	$string=secure_data($string,"ADOsql");

	//Solo terminos aceptados == estado_id ='13'

	$sql=SQL("select","if(terminosUP.id is not null,terminosUP.id_menor,tema.tema_id) as tema_id,tema.tema,tema.isMetaTerm
	FROM $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as terminosUP on terminosUP.id_mayor=tema.tema_id
	and terminosUP.t_relacion='4'
	left join $DBCFG[DBprefix]tabla_rel as terminosTG on '$tema_id' in (terminosTG.id_menor,terminosTG.id_mayor)
	and tema.tema_id in (terminosTG.id_menor,terminosTG.id_mayor)
	and terminosTG.t_relacion='3'
	WHERE tema.tema=$string
	and tema.tema_id!= '$tema_id'
	and tema.estado_id='13'
	and tema.tesauro_id= '$thes_id'
	and terminosTG.id is null
	and terminosUP.id is null");

	return $sql->FetchRow();
};




#
# Datos de cada términos con su tipificaciÃ³n y notas
#

function ARRAYverDatosTermino($tema_id){
	GLOBAL $DBCFG;

	$tema_id=secure_data($tema_id,"int");

	$sql=SQL("select","tema.tema_id as idTema,
	tema.code,
	tema.tema,
	if(relaciones.id is null,'TT','PT') as tipo_termino,
	tema.cuando,
	tema.uid,
	tema.cuando_final,
	tema.uid_final,
	tema.isMetaTerm,
	relaciones.id_mayor,
	tema.estado_id,
	v.value_code as estado_code,
	tema.cuando_estado,
	c.idioma
	from $DBCFG[DBprefix]values v,$DBCFG[DBprefix]config c, $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on tema.tema_id=relaciones.id_menor
	and relaciones.t_relacion='3'
	where
	tema.tema_id='$tema_id'
	and v.value_type='t_estado'
	and tema.tesauro_id=c.id
	and v.value_id=tema.estado_id");

	while($array=$sql->FetchRow()){
		$i=++$i;
		$arrayDatos["idTema"]=$array["idTema"];
		$arrayDatos["tema_id"]=$array["idTema"];
		$arrayDatos["code"]=$array["code"];
		$arrayDatos["titTema"]=$array["tema"];
		$arrayDatos["descTema"]=$array["desc_tema"];
		$arrayDatos["tipoTema"]=$array["tipo_termino"];
		$arrayDatos["supraTema"]=$array["id_mayor"];
		$arrayDatos["estado_id"]=$array["estado_id"];
		$arrayDatos["estado_code"]=$array["estado_code"];
		$arrayDatos["cuando_estado"]=$array["cuando_estado"];
		$arrayDatos["cuando"]=$array["cuando"];
		$arrayDatos["idioma"]=$array["idioma"];
		$arrayDatos["uid"]=$array["uid"];
		$arrayDatos["cuando_final"]=$array["cuando_final"];
		$arrayDatos["uid_final"]=$array["uid_final"];
		$arrayDatos["last"]=$array["last"];
		$arrayDatos["isMetaTerm"]=$array["isMetaTerm"];
	};

	$arrayNotas=array();

	$sqlNotas=SQLdatosTerminoNotas($tema_id);

	while($array=$sqlNotas->FetchRow()){
		if($array[nota_id]){
			array_push($arrayNotas,array(
				"id"=>$array[nota_id],
				"tipoNota"=>$array[ntype_code],
				"tipoNotaLabel"=>$array[ntype],
				"tipoNota_id"=>$array[ntype_id],
				"lang_nota"=>$array[lang_nota],
				"cuando_nota"=>$array[cuando],
				"nota"=>$array[nota]));
			};
		};
		$arrayDatos["notas"]=$arrayNotas;
		return $arrayDatos;
	}



	/*
	BUSCADOR DE DATOS DE UN TERMINO Y SUS TERMINOS RELACIONADOS
	* Retrieve BT,UF,RT,EQ. NOT RETRIEVE: NT,USE
	*/

	function SQLverTerminoRelaciones($tema_id){

		GLOBAL $DBCFG;

		$tema_id=secure_data($tema_id,"int");

		return SQL("select","r.t_relacion,
		BT.tema_id as tema_id,
		BT.tema,
		BT.code,
		BT.cuando as t1_cuando,
		tema.tema_id as id_tema,
		tema.isMetaTerm,
		BT.isMetaTerm as BT_isMetaTerm,
		r.id as id_relacion,
		c.titulo,c.autor,c.idioma,
		r.id as rel_id,
		r.rel_rel_id,
		trr.value as rr_value,
		trr.value_code as rr_code
		from $DBCFG[DBprefix]config c,
		$DBCFG[DBprefix]tema as tema,
		$DBCFG[DBprefix]tema as BT,
		$DBCFG[DBprefix]tabla_rel as r
		left join $DBCFG[DBprefix]values trr on trr.value_id=r.rel_rel_id
		where
		r.id_menor=tema.tema_id
		and r.id_menor='$tema_id'
		and BT.tema_id=r.id_mayor
		and c.id=BT.tesauro_id
		order by r.t_relacion,lower(BT.code),trr.value_order,lower(BT.tema)");
	};


	#
	# DATOS DE UN TERMINO (id y string) Y SUS TERMINOS RELACIONADOS (id) y tipo de relacion
	#
	function SQLTerminoRelacionesIDs($tema_id=""){

		GLOBAL $DBCFG;

		$tema_id=secure_data($tema_id,"int");

		(@$tema_id) ? $where=" and '$tema_id' in (t1.tema_id,t2.tema_id)" : $where="";

		# SQL busca terminos con relaciones TG-TE, UP-USE, TR
		$sql=SQL("select","t1.tema_id as id1,
		t1.tema as tema1,
		t2.tema_id as id2,
		t2.tema as t2,
		rel.t_relacion
		FROM
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

		$tema_id=secure_data($tema_id,"int");

		$sql=SQL("select","relaciones.t_relacion,BT.tema_id as id_tema,BT.tema,
		relaciones.id as id_relacion,if(tipo_term.id is null,'TT','PT') as tipo_termino,
		BT.isMetaTerm
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

		$tema_id=secure_data($tema_id,"int");

		return SQL("select","if(t1.tema_id='$tema_id',t2.tema_id,t1.tema_id) as tema_id,
		if(t1.tema_id='$tema_id',t2.tema,t1.tema) as tema,
		if(t1.tema_id='$tema_id',t2.isMetaTerm,t1.isMetaTerm) as isMetaTerm,
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
	function SQLlistaTemas($top_term_id="0"){

		GLOBAL $DBCFG;

		$top_term_id=secure_data($top_term_id,"int");

		if($top_term_id>0)
		{
			$size_i=strlen($top_term_id)+2;
			$from="$DBCFG[DBprefix]indice tti,";
			$where="	and tema.tema_id=tti.tema_id";
			$where.="	and left(tti.indice,$size_i)='|$top_term_id|'";
		}
		//Control de estados
		// (!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" where tema.estado_id='13' " : $where="";

		$sql=SQL("select","tema.tema_id as id,tema.tema,tema.code,tema.cuando,tema.uid,tema.cuando_final,tema.isMetaTerm,r.t_relacion,r.id_menor as tema_id_referido
		from $from $DBCFG[DBprefix]tema as tema
		left join $DBCFG[DBprefix]tabla_rel as r on tema.tema_id = r.id_mayor
		and r.t_relacion in (4,5,6,7,8)
		where tema.estado_id='13'
		$where
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

		$sql=SQL("select","TT.tema_id as id,TT.tema,TT.code,TT.tema_id,TT.isMetaTerm,c.idioma,c.titulo
		from $DBCFG[DBprefix]tabla_rel as relaciones,
		$DBCFG[DBprefix]config as c,
		$DBCFG[DBprefix]tema as TT
		left join $DBCFG[DBprefix]tabla_rel as no_menor on no_menor.id_menor=TT.tema_id
		and no_menor.t_relacion='3'
		where
		TT.tema_id=relaciones.id_mayor
		$where
		and relaciones.t_relacion='3'
		and no_menor.id is null
		and c.id=TT.tesauro_id
		group by TT.tema_id
		order by lower(TT.code),lower(TT.tema)");
		return $sql;
	};



	#
	# TERMINOS LIBRES
	#
	function SQLverTerminosLibres($tema_id=0){

		GLOBAL $DBCFG;

		GLOBAL $CFG;

		if($tema_id!==0){
			$tema_id=secure_data($tema_id,"int");
			$where=" and TT.tema_id='$tema_id'";
		}

		$show_code=($CFG["_USE_CODE"]=='1') ? 'TT.code,' : '';

		$thes_id=secure_data($_SESSION[id_tesa],"int");

		$sql=SQL("select","TT.tema_id, $show_code TT.tema,TT.estado_id,TT.cuando,TT.isMetaTerm
		from $DBCFG[DBprefix]tema as TT
		left join $DBCFG[DBprefix]tabla_rel as no_menor on no_menor.id_menor=TT.tema_id
		left join $DBCFG[DBprefix]tabla_rel as no_mayor on no_mayor.id_mayor=TT.tema_id
		where
		no_menor.id is null
		and no_mayor.id is null
		and TT.estado_id='13'
		and TT.tesauro_id='$thes_id'
		$where
		order by lower(TT.tema)");
		return $sql;
	};


	#
	# Check if one term is a free term
	#
	function SQLcheckFreeTerm($tema_id){

		GLOBAL $DBCFG;

		GLOBAL $CFG;

		$tema_id=secure_data($tema_id,"int");

		$show_code=($CFG["_USE_CODE"]=='1') ? 'TT.code,' : '';

		$sql=SQL("select","TT.tema_id, $show_code TT.tema,TT.estado_id,TT.cuando,TT.isMetaTerm
		from $DBCFG[DBprefix]tema as TT
		left join $DBCFG[DBprefix]tabla_rel as no_menor on no_menor.id_menor=TT.tema_id
		left join $DBCFG[DBprefix]tabla_rel as no_mayor on no_mayor.id_mayor=TT.tema_id
		where
		no_menor.id is null
		and no_mayor.id is null
		and TT.tema_id='$tema_id'
		order by lower(TT.tema)");
		return $sql;
	};



	#
	# Buscador de términos iguales
	#
	function SQLverTerminosRepetidos($tesauro_id=1){
		GLOBAL $DBCFG;
		$sql=SQL("select","tema.tema as string_term,count(*) as cant,tema2.tema,tema2.tema_id,tema2.isMetaTerm
		from $DBCFG[DBprefix]tema as tema, $DBCFG[DBprefix]tema as tema2
		where tema2.tema=tema.tema
		and tema.tesauro_id='$tesauro_id'
		and tema2.tesauro_id='$tesauro_id'
		group by tema.tema,tema2.tema_id
		having cant >1
		order by cant desc,lower(tema.tema),tema2.isMetaTerm");
		return $sql;
	};


	#
	# BUSCADOR DE TERMINOS especÃ­ficos de un término general
	#
	function SQLverTerminosE($tema_id){
		GLOBAL $DBCFG;

		$tema_id=secure_data($tema_id,"int");

		//Control de estados
		(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and tema.estado_id='13' " : $where="";

		$sql=SQL("select","tema.tema_id,tema.tema_id as id_tema,
		tema.code,
		tema.tema,
		tema.isMetaTerm,
		relaciones.id as id_relacion,
		relaciones.id as rel_id,
		rel_abajo.id as id_te,
		relaciones.t_relacion,
		trr.value_id as rr_id,
		trr.value_code as rr_code,
		trr.value as rr_value
		from $DBCFG[DBprefix]tema as tema,$DBCFG[DBprefix]tabla_rel as relaciones
		left join $DBCFG[DBprefix]tabla_rel as rel_abajo on rel_abajo.id_mayor=relaciones.id_menor
		and rel_abajo.t_relacion='3'
		left join $DBCFG[DBprefix]values trr on trr.value_id=relaciones.rel_rel_id
		where relaciones.t_relacion='3'
		and relaciones.id_mayor='$tema_id'
		and relaciones.id_menor=tema.tema_id
		$where
		group by tema.tema_id
		order by lower(tema.code),trr.value_order,lower(tema.tema)");
		return $sql;
	};



	#
	# Lista de términos de una letra
	#
	function SQLmenuABC($letra){
		GLOBAL $DBCFG;
		GLOBAL $CFG;

		$letra=(!ctype_digit($letra)) ? $letra : secure_data($letra,"ADOsql");



		$where_letter=(!ctype_digit($letra)) ? " LEFT(tema.tema,1)=? " : " LEFT(tema.tema,1) REGEXP '[[:digit:]]' ";

		//Control de estados
		(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and tema.estado_id='13' " : $where="";

		//hide hidden equivalent terms
		if((!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) && (count($CFG["HIDDEN_EQ"])>0))
		{
			$hidden_labels=implode("','", $CFG["HIDDEN_EQ"]);
			$hidden_labels='\''.$hidden_labels.'\'';
			$leftJoin="left join $DBCFG[DBprefix]values trr on trr.value_id=relaciones.rel_rel_id and trr.value_code in ($hidden_labels) ";
			$where.=" and trr.value_id is null ";
		}

		$sql=SQLo("select","if(relaciones.id is not null,relaciones.id_menor,tema.tema_id) id_definitivo,
		tema.tema_id,
		tema.tema,
		tema.estado_id,
		tema.isMetaTerm,
		relaciones.t_relacion,
		temasPreferidos.tema as termino_preferido
		from $DBCFG[DBprefix]tema as tema
		left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id and relaciones.t_relacion in (4,5,6,7,8)
		left join $DBCFG[DBprefix]tema as temasPreferidos on temasPreferidos.tema_id=relaciones.id_menor
		and tema.tema_id=relaciones.id_mayor
		$leftJoin
		where
		$where_letter
		$where
		group by tema.tema_id
		order by lower(tema.tema)",(!ctype_digit($letra)) ? array($letra) : array());

		return $sql;
	};


	#
	# Lista  de letras
	#
	function SQLlistaABC($letra=""){

		GLOBAL $DBCFG;
		GLOBAL $CFG;


		$where="";

		if(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id])
		{
			//Control de estados
			$where=" where tema.estado_id='13' ";

			//hide hidden equivalent terms
			if(count($CFG["HIDDEN_EQ"])>0)
			{
				$hidden_labels=implode("','", $CFG["HIDDEN_EQ"]);
				$hidden_labels='\''.$hidden_labels.'\'';
				$leftJoin="left join $DBCFG[DBprefix]values trr on trr.value_id=relaciones.rel_rel_id and trr.value_code in ($hidden_labels) ";
				$where.=" and trr.value_id is null ";
			}
		}


		$letra=secure_data($letra,"ADOsql");


		return SQL("select","ucase(LEFT(tema.tema,1)) as letra_orden,
		if(LEFT(tema.tema,1)=$letra, 1,0) as letra
		from $DBCFG[DBprefix]tema as tema
		left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id
		$leftJoin
		$where
		group by letra_orden
		order by letra_orden");
		;
	};


	#
	# Lista PAGINADA de términos de una letra
	#
	function SQLmenuABCpages($letra,$args = ''){

		GLOBAL $DBCFG;
		GLOBAL $CFG;

		$letra=(ctype_digit($letra)) ? $letra : secure_data($letra,"ADOsql");

		$defaults=array("min"=>0,
		"limit"=>50
	);

	$args = t3_parse_args( $args, $defaults );

	extract($args, EXTR_SKIP);

	$min = 0  < (int) $min ? (int) $min : 0;
	$limit = 50 <= (int) $limit ? (int) $limit : 50;

	$where_letter=(ctype_digit($letra)) ?  " LEFT(tema.tema,1) REGEXP '[[:digit:]]' " : " LEFT(tema.tema,1)=$letra ";

	$where="";

	if(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id])
	{
		//Control de estados
		$where=" and tema.estado_id='13' ";

		//hide hidden equivalent terms
		if(count($CFG["HIDDEN_EQ"])>0)
		{
			$hidden_labels=implode("','", $CFG["HIDDEN_EQ"]);
			$hidden_labels='\''.$hidden_labels.'\'';
			$leftJoin="left join $DBCFG[DBprefix]values trr on trr.value_id=relaciones.rel_rel_id and trr.value_code in ($hidden_labels) ";
			$where.=" and trr.value_id is null ";
		}
	}

	$sql=SQL("select","if(relaciones.id is not null,relaciones.id_menor,tema.tema_id) id_definitivo,
	tema.tema_id,
	tema.tema,
	tema.estado_id,
	tema.isMetaTerm,
	relaciones.t_relacion,
	temasPreferidos.tema as termino_preferido
	from $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id and relaciones.t_relacion in (4,5,6,7,8)
	left join $DBCFG[DBprefix]tema as temasPreferidos on temasPreferidos.tema_id=relaciones.id_menor
	and tema.tema_id=relaciones.id_mayor
	$leftJoin
	where
	$where_letter
	$where
	group by tema.tema_id
	order by lower(tema.tema)
	limit $min,$limit");

	return $sql;
};


#
# cantidad de términos de una letra
#
function numTerms2Letter($letra){

	GLOBAL $DBCFG;

	$letra_sanitizada=secure_data($letra,"ADOsql");

	$where_letter=(!ctype_digit($letra)) ? " LEFT(tema.tema,1)=$letra_sanitizada " : " LEFT(tema.tema,1) REGEXP '[[:digit:]]' ";

	//Control de estados
	(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and tema.estado_id='13' " : $where="";

	$sql=SQL("select","count(*) as cant
	from $DBCFG[DBprefix]tema as tema
	where
	$where_letter
	$where");

	if(is_object($sql))
	{
		$array=$sql->FetchRow();
		return $array["cant"];
	}
	else
	{
		return 0;
	}
};

#
# Lista de términos de una secuencia de letras sin importar relaciones
#
function SQLbuscaTerminosSimple($string,$limit="20"){
	GLOBAL $DBCFG;

	$limit=(is_int($limit)) ? $limit : "20";

	//Control de estados
	$where=(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? " and t.estado_id='13' " : "";

	//Check is include or not meta terms
	$where.=(CFG_SEARCH_METATERM==0) ? " and t.isMetaTerm=0 " : "";

	$string=secure_data("$string%","ADOsql");

	return SQL("select","t.tema_id,
	t.tema,
	r.t_relacion
	from $DBCFG[DBprefix]tema as t
	left join $DBCFG[DBprefix]tabla_rel as r on t.tema_id=r.id_mayor
	and r.t_relacion='4'
	where
	t.tema like $string
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

	$thes_id=secure_data($_SESSION[id_tesa],"int");

	$sql=SQL("select","tema.tema_id as id,tema.cuando,tema.uid,tema.cuando_final,tema.isMetaTerm
	from $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on tema.tema_id =relaciones.id_mayor
	and relaciones.t_relacion='4'
	where
	relaciones.id is null
	and tema.tesauro_id='$thes_id'
	and tema.estado_id='13'
	group by tema.tema_id
	order by lower(tema.tema)");

	return $sql;
};


#
# Lista de términos válidos (sin UF ni términos libres)
#
function SQLTerminosValidos($tema_id=""){
	GLOBAL $DBCFG;

	$tema_id=secure_data($tema_id,"int");

	(@$tema_id) ? $where=" and tema.tema_id='$tema_id' " : $where="";

	//Control de estados
	(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where.=" and tema.estado_id='13' " : $where=$where;

	$sql=SQL("SELECT","tema.tema_id as id,tema.tema,tema.cuando,tema.uid,tema.cuando_final,tema.isMetaTerm
	from $DBCFG[DBprefix]tema as tema,$DBCFG[DBprefix]tabla_rel as relaciones
	where
	tema.tema_id in (relaciones.id_menor,relaciones.id_mayor)
	and relaciones.t_relacion!='4'
	$where
	group by tema.tema_id
	order by tema.code,lower(tema.tema)");
	return $sql;
};



#
# Lista de Ids de términos válidos y aceptados (sin UF ni términos libres) y con TE
#
function SQLIdTerminosIndice(){
	GLOBAL $DBCFG;

	//Solo término aceptados
	$where=" and t.estado_id='13' ";

	$sql=SQL("SELECT","t.tema_id as id,t.tema_id as tema_id,t.cuando,t.uid,t.cuando_final,t.isMetaTerm,i.indice
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

	$tema_id=secure_data($tema_id,"int");

	(@$tema_id) ? $where=" and tema.tema_id='$tema_id' " : $where="";

	$tesauro_id= $_SESSION["id_tesa"];

	//Control de estados
	(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where.=" and tema.estado_id='13' " : $where=$where;

	$sql=SQL("select","tema.tema_id as id,tema.tema,tema.cuando,tema.uid,tema.cuando_final,tema.isMetaTerm
	from $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on tema.tema_id = relaciones.id_mayor
	and relaciones.t_relacion='4'
	where
	relaciones.id is null
	and tema.tesauro_id='$tesauro_id'
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

	$sql=SQLo("select","if(relaciones.t_relacion=4,relaciones.id_menor,tema.tema_id) as id_tema,tema.isMetaTerm,
	if(relaciones.t_relacion=4,concat(tema.tema,' ($codUP)'),tema.tema) as tema,
	tema.cuando,
	usuario.id as id_usuario,usuario.apellido,usuario.nombres,usuario.orga
	from $DBCFG[DBprefix]usuario as usuario,$DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id
	where
	tema.uid=usuario.id
	and month(tema.cuando) =?
	and year(tema.cuando) =?
	group by tema.tema_id
	$orderBy",array($month,$year));

	return $sql;
};


#
# lista de términos recientes
#
function SQLlastTerms($limit="50"){

	GLOBAL $DBCFG;
	GLOBAL $CFG;
	$codUP=UP_acronimo;

	#exclude hidden labels
	$hidden_labels=implode("','", $CFG["HIDDEN_EQ"]);
	$hidden_labels='\''.$hidden_labels.'\'';


	$limit=(secure_data($limit,"int")) ? $limit : "50";

	$sql=SQL("select","c.idioma,if(relaciones.t_relacion=4,relaciones.id_menor,tema.tema_id) as tema_id,tema.code,
	if(relaciones.t_relacion=4,concat(tema.tema,' ($codUP)'),tema.tema) as tema,
	tema.cuando,tema.cuando_final,tema.isMetaTerm
	from $DBCFG[DBprefix]config c, $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id
	left join $DBCFG[DBprefix]values vrr on relaciones.rel_rel_id = vrr.value_id and vrr.value_code in ($hidden_labels)
	where c.id=tema.tesauro_id
	and tema.estado_id='13'
	and vrr.value_id is null
	group by tema.tema_id
	order by tema.cuando_final desc,tema.cuando desc
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
		$limite=(secure_data($limite,"int")) ? $limite : "300";
	}

	$estado_id=secure_data($estado_id,"int");


	return SQL("select","if(relaciones.t_relacion=4,relaciones.id_menor,tema.tema_id) as tema_id,
	if(relaciones.t_relacion=4,concat(tema.tema,' ($codUP)'),tema.tema) as tema,tema.estado_id,
	tema.cuando,tema.cuando_final,tema.isMetaTerm
	from $DBCFG[DBprefix]tema as tema
	left join $DBCFG[DBprefix]tabla_rel as relaciones on relaciones.id_mayor=tema.tema_id
	where tema.estado_id=$estado_id
	group by tema.tema_id
	order by tema.cuando_final,tema.cuando desc
	limit 0,$limite");
};


#
# Lista de términos según meses y aÃ±os
#
function SQLtermsByDate(){

	GLOBAL $DBCFG;

	$sql=SQL("select","year(tema.cuando) as years,month(tema.cuando) as months,tema.cuando,count(*) as cant
	from $DBCFG[DBprefix]tema as tema
	group by year(tema.cuando),month(tema.cuando)
	order by tema.cuando desc");
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

	$id_user=secure_data($id_user,"int");

	$sql=SQL("select","if(relaciones.t_relacion=4,relaciones.id_menor,tema.tema_id) as id_tema,
	if(relaciones.t_relacion=4,concat(tema.tema,' ($codUP)'),tema.tema) as tema,
	tema.cuando,tema.isMetaTerm,
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

	while($cant_rel=$sql_cant_rel->FetchRow()){
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
	$cant_term=$sql_cant_term->FetchRow();


	$sqlCantNotas=SQLcantNotas();
	while ($arrayCantNotas=$sqlCantNotas->FetchRow())
	{
		$cant_notas[$arrayCantNotas[tipo_nota]] = $arrayCantNotas[cant];
	}


	$ARRAYcant_term2tterm=ARRAYcant_term2tterm();

	$resumen=array("cant_rel"=>$cant_terminos_relacionados,
	"cant_up"=>$cant_terminos_up,
	"cant_total"=>$cant_term["cant"],
	"cant_candidato"=>$cant_term["cant_candidato"],
	"cant_rechazado"=>$cant_term["cant_rechazado"],
	"cant_notas"=>$cant_notas,
	"cant_term2tterm"=>$ARRAYcant_term2tterm["cant"]
);
return $resumen;
};


#
# Sql que arma arbol de temas
#
function SQLarbolTema($tema_id){
	GLOBAL $DBCFG;

	$tema_id=secure_data($tema_id,"int");

	$ARRAYtema_indice=ARRAYIndexTema($tema_id);
	if($ARRAYtema_indice){
		$temas_ids=str_replace('|', ',',$ARRAYtema_indice[indice]);
		$temas_ids=substr($temas_ids,1);

		$sql=SQL("select","t.tema_id as tema_id,t.tema,t.isMetaTerm
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

	$tema_id=secure_data($tema_id,"int");

	$sql=SQL("select","i.tema_id,i.indice from $DBCFG[DBprefix]indice i where i.indice like '%|$tema_id|%'");

	return $sql;
};



#
# array de tema y el indice de su arbol
#
function ARRAYIndexTema($tema_id){

	GLOBAL $DBCFG;

	$tema_id=secure_data($tema_id,"int");

	$sql=SQL("select","i.tema_id,i.indice from $DBCFG[DBprefix]indice i where i.tema_id='$tema_id'");
	return $sql->FetchRow();
};


#
# sql de expansiÃ³n sobre un tema (expansiÃ³n hacia arriba expansio to TG)
#
function SQLexpansionTema($tema_id){
	GLOBAL $DBCFG;

	$tema_id=secure_data($tema_id,"int");

	//Control de estados
	(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and t.estado_id='13' " : $where="";

	return SQL("select","t.tema_id as tema_id,t.tema,t.isMetaTerm, i.indice,
	LENGTH(i.indice) - LENGTH(REPLACE(i.indice, '|', '')) AS tdeep
	from $DBCFG[DBprefix]indice i,$DBCFG[DBprefix]tema t
	where i.indice like '%|$tema_id%'
	and i.tema_id=t.tema_id
	$where
	order by tdeep");
};


#
# sql de expansiÃ³n sobre una lista de ids hacia temas relacionados (expansion to TR)
#
function SQLexpansionTR($lista_temas_id){
	GLOBAL $DBCFG;

	$id_TR=id_TR;

	$csv_temas_id=string2array4ID($lista_temas_id);

	//Control de estados
	(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and t.estado_id='13' " : $where="";

	return SQL("select","t.tema_id as tema_id,t.tema, t.isMetaTerm,count(t.tema_id) as cant_rel
	from $DBCFG[DBprefix]tema t, $DBCFG[DBprefix]tabla_rel tr
	where
	tr.id_menor in ($csv_temas_id)
	and tr.id_mayor=t.tema_id
	and t.tema_id not in ($csv_temas_id)
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

	$csv_temas_id=string2array4ID($lista_temas_id);

	return SQL("select","t.tema_id as tema_id,t.tema,t.isMetaTerm from $DBCFG[DBprefix]tema t where t.tema_id in ($csv_temas_id) $where order by t.tema");
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

	$tema_id=secure_data($tema_id,"int");

	$where=($tema_id!=="0") ? " and relaciones.id_mayor='$tema_id' " : " ";

	return SQL("select","relaciones.t_relacion,
	t1.tema_id as tema_pref_id,
	t1.tema as tema_pref,
	t2.tema_id as tema_id,
	t2.tema,
	vrr.value_code as rr_code,
	vrr.value as rr_value,
	relaciones.rel_rel_id,
	c.id as vocabulario_id,
	c.titulo,c.autor,c.idioma
	from $DBCFG[DBprefix]config c,
	$DBCFG[DBprefix]tema as t1,
	$DBCFG[DBprefix]tema as t2,
	$DBCFG[DBprefix]tabla_rel as relaciones
	left join $DBCFG[DBprefix]values vrr on relaciones.rel_rel_id = vrr.value_id

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
	return $sql->FetchRow();
};


function ARRAYdatosUserXmail($user_login){

	GLOBAL $DBCFG;

	$sql=SQLo("select","u.id,u.id as user_id,u.apellido,u.nombres,u.orga,u.mail,u.cuando,u.hasta,u.estado,u.pass, if(u.estado=1,'caducar','habilitar') as enlace,u.nivel,user_activation_key
	from $DBCFG[DBprefix]usuario u where u.mail= ?",array($user_login));

	return $sql->FetchRow();

	return (is_object) ? $sql->FetchRow() : array();
};


function ARRAYdatosUserXkey($user_login,$key){

	GLOBAL $DBCFG;

	$sql=SQLo("select","u.id,u.id as user_id,u.apellido,u.nombres,u.orga,u.mail,u.cuando,u.hasta,u.estado,u.pass, if(u.estado=1,'caducar','habilitar') as enlace,u.nivel,user_activation_key
	from $DBCFG[DBprefix]usuario u where u.mail= ? and user_activation_key= ?",array($user_login,$key));
	return (is_object) ? $sql->FetchRow() : false;
};



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

	//Check is include or not meta terms
	$where.=(CFG_SEARCH_METATERM==0) ? " and t.isMetaTerm=0 " : "";

	$sql=SQL("select","t.tema,length(t.tema) as largo
	from $DBCFG[DBprefix]tema as t
	where
	length(t.tema) between $minstrlen and $maxstrlen
	and t.estado_id ='13'
	$where
	order by tema,largo","1");
	return $sql;
};



#
# Busca lista de términos para evaluar similitud de una expresiona de búsqueda
#
function SQLsimiliarSound($texto,$lista_temas_id="0"){
	GLOBAL $DBCFG;
	/*
	El termino a evaluar debe sonar igual
	El termino a evaluar no debe estar en la lista de resultados
	13 = estado aceptado
	*/
	$texto=trim($texto);

	//Hubo resultados de búsqueda
	if(count(explode("|",$lista_temas_id))>1){

		$lista_temas_id=str_replace("|",",",$lista_temas_id);
		$lista_temas_id=substr($lista_temas_id,0,-1);
		$where = " 	and t.tema_id not in ($lista_temas_id) ";
	} else {
		$where = "";
	}

	//Check is include or not meta terms
	$where.=(CFG_SEARCH_METATERM==0) ? " and t.isMetaTerm=0 " : "";

	$sql=SQL("select","lower(t.tema),length(t.tema) as largo
	from $DBCFG[DBprefix]tema as t
	where
	SOUNDEX(t.tema) = SOUNDEX('$texto')
	and t.estado_id ='13'
	$where
	order by tema,largo");
	return $sql;
};


/*
* Verificar que no sea un no-termino o un término de otro vocabularios. Check if isnt no-term
* Verficar que sea un término válido para relaciones y notas > no (UF,EQ,EQP,NEQ)
*/
function SQLcheckIsValidTerm($tema_id)
{
	GLOBAL $DBCFG;

	$tema_id=secure_data($tema_id,"int");

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
function SQLsearchFreeTerms($search_term,$tema_id=""){

	GLOBAL $DBCFG;

	$tema_id=secure_data($tema_id,"int");

	$_SESSION[id_tesa]=secure_data($_SESSION[id_tesa],"int");

	$search_term=secure_data("%$search_term%","ADOsql");

	$where = ($tema_id) ? " and TT.tema_id!='$tema_id' " : "";

	return SQL("select","TT.tema_id as id,TT.tema,TT.isMetaTerm,TT.cuando,TT.tema_id as tema_id
	from $DBCFG[DBprefix]tema as TT
	left join $DBCFG[DBprefix]tabla_rel as no_menor on no_menor.id_menor=TT.tema_id
	left join $DBCFG[DBprefix]tabla_rel as no_mayor on no_mayor.id_mayor=TT.tema_id
	where
	no_menor.id is null
	and no_mayor.id is null
	and TT.estado_id='13'
	and TT.tesauro_id='$_SESSION[id_tesa]'
	and TT.tema like $search_term
	$where
	order by TT.tema");
};


/*
Retrieve one Free term
*/
function ARRAYsearchFreeTerm($string,$tema_id){

	$sql=SQLsearchFreeTermsExact($string,$tema_id);

	return $sql->FetchRow();
}


/*
* Search exact free terms for associate as UF. Created by SafetyLit and Monarch Media
*
*/
function fetchSearchExactFreeTerms($string,$tema_id){

	GLOBAL $DBCFG;


	$tema_id=secure_data($tema_id,"int");
	$thes_id=secure_data($_SESSION[id_tesa],"int");
	$string=secure_data($string,"ADOsql");

	$sql=SQL("select","t.tema_id as tema_id,t.tema,t.isMetaTerm
	from $DBCFG[DBprefix]tema as t
	left join $DBCFG[DBprefix]tabla_rel r on t.tema_id in (r.id_mayor,r.id_menor)
	where
	r.id is null
	and t.estado_id='13'
	and t.tesauro_id='$thes_id'
	and t.tema=$string
	and t.tema_id!='$tema_id'");

	return $sql->FetchRow();
};



//Retrive simple term data for code
function ARRAYCode($code)
{
	GLOBAL $DBCFG;

	$code=secure_data($code,"ADOsql");

	$sql=SQL("select","t.tema_id,t.tema,t.code
	from $DBCFG[DBprefix]tema t where t.code=$code");

	return $sql->FetchRow();
}


//Retrive simple term data for code
function ARRAYCodeDetailed($code)
{
	GLOBAL $DBCFG;

	$code=secure_data($code,"ADOsql");

	//Control de estados
	(!$_SESSION[$_SESSION["CFGURL"]][ssuser_id]) ? $where=" and tema.estado_id='13' " : $where="";

	$sql=SQL("select","tema.tema_id, tema.tema_id as idTema,
	tema.code,
	tema.tema titTema,
	tema.tema,
	tema.estado_id,
	tema.cuando_estado,
	tema.cuando,
	tema.cuando_final,
	tema.isMetaTerm,
	c.idioma,
	c.titulo
	from $DBCFG[DBprefix]tema as tema,
	$DBCFG[DBprefix]config as c
	where
	tema.code=$code
	and c.id=tema.tesauro_id
	$where");

	return $sql->FetchRow();
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
	GLOBAL $DB;

	//sanitice string
	$array[xstring]=($array[isExactMatch]=='1') ? $DB->qstr(trim($array[xstring]),get_magic_quotes_gpc()) : $DB->qstr(trim("%$array[xstring]%"),get_magic_quotes_gpc());


	#has top term X
	$array[hasTopTerm]=secure_data($array[hasTopTerm],"int");

	if($array[hasTopTerm]>0)
	{
		$size_i=strlen($array[hasTopTerm])+2;
		$from=",$DBCFG[DBprefix]indice tti";
		$where="	and t.tema_id=tti.tema_id";
		$where.="	and left(tti.indice,$size_i)='|$array[hasTopTerm]|'";
	}

	$array[hasNote]=$DB->qstr(trim($array[hasNote]),get_magic_quotes_gpc());
	if(strlen($array[hasNote])>2)
	{
		$from.=",$DBCFG[DBprefix]notas n";
		$where.="		and n.id_tema=t.tema_id";
		$where.="		and n.tipo_nota=$array[hasNote]";
	}

	#time filter
	$array[fromDate]=secure_data($array[fromDate],"int");
	if($array[fromDate])
	{

		$array[fromDate]=date_format(date_create($array[fromDate].'01'),'Y-m-d');
		$where.="		and (t.cuando between '$array[fromDate]' and now())";
	}


	#deep level
	$array[termDeep]=secure_data($array[termDeep],"int");
	if($array[termDeep]>0)
	{
		$select=",LENGTH(i.indice) - LENGTH(REPLACE(i.indice, '|', '')) AS tdeep";
		$from.=	"	,$DBCFG[DBprefix]indice i";
		$where.="	and t.tema_id=i.tema_id";
		$having.="	having tdeep='$array[termDeep]'";
	}


	#time update filter
	#and (cuando_final between '2010-05-19' and now())


	switch ($array[ws]) {
		case 't'://term
		$initial_where=($array[isExactMatch]=='1') ? " binary t.tema=$array[xstring] " : " t.tema like $array[xstring] ";
		break;

		case 'mt'://meta term
		$initial_where=($array[isExactMatch]=='1') ? " binary t.tema=$array[xstring] and t.isMetaTerm=1 " : " t.tema like $array[xstring] and t.isMetaTerm=1 ";

		break;

		case 'uf':// no term
		$initial_where=($array[isExactMatch]=='1') ? " binary UFt.tema= $array[xstring] " : " UFt.tema like $array[xstring] ";

		$select.=",UFt.tema_id as uf_tema_id,UFt.tema as uf_tema,r.t_relacion";
		$from.=	"	,$DBCFG[DBprefix]tabla_rel r";
		$from.=	"	,$DBCFG[DBprefix]tema UFt";
		$where.="	and r.id_menor=t.tema_id";
		$where.="	and r.id_mayor=UFt.tema_id";
		$where.="	and r.t_relacion='4'";
		break;

		case 'c':// code
		$initial_where=($array[isExactMatch]=='1') ? " t.code= $array[xstring] " : " t.code like $array[xstring] ";
		break;

		case 'n':// note

		$array[xstring4html]='<p>'.str_replace("'", "", $array[xstring]).'</p>';

		$from.=	"	,$DBCFG[DBprefix]notas ns";
		$where.="	and t.tema_id=ns.id_tema";

		$initial_where.=($array[isExactMatch]=='1') ? " (ns.nota=$array[xstring] or ns.nota='$array[xstring4html]')  " : " ns.nota like $array[xstring] ";
		break;

		case 'tgt':// target term from target vocabulary (foreign term)
		$initial_where=($array[isExactMatch]=='1') ? " tt.tterm_string= $array[xstring] " : " tt.tterm_string like $array[xstring] ";
		$from.=	"	,$DBCFG[DBprefix]term2tterm tt";
		$where.="	and t.tema_id=tt.tema_id";
		break;

		default ://term
		$initial_where=($array[isExactMatch]=='1') ? " binary t.tema=$array[xstring] " : " t.tema like $array[xstring] ";

		break;
	}

	return SQL("select","t.tema_id,t.tema,t.cuando,t.cuando_final,t.estado_id,t.isMetaTerm $select
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
	GLOBAL $DB;

	#has top term X
	$array[hasTopTerm]=secure_data($array[hasTopTerm],"int");
	if($array[hasTopTerm]>0)
	{
		$size_i=strlen($array[hasTopTerm])+2;
		$from="$DBCFG[DBprefix]indice tti,";
		$where="	and t.tema_id=tti.tema_id";
		$where.="	and left(tti.indice,$size_i)='|$array[hasTopTerm]|'";
	}

	#has note type X
	$array[hasNote]=$DB->qstr(trim($array[hasNote]),get_magic_quotes_gpc());

	if(strlen($array[hasNote])>2)
	{
		$from.="$DBCFG[DBprefix]notas n,";
		$where.="		and n.id_tema=t.tema_id";
		$where.="		and n.tipo_nota=$array[hasNote]";
	}

	#time filter
	#sanitice
	$arrayDates=explode("-",$array["fromDate"]);
	$yearDate=secure_data($arrayDates[0],"int");
	$monthDate=secure_data($arrayDates[1],"int");

	if(($yearDate>0) && ($monthDate>0))
	{
		$fromDate=$yearDate.'-'.$monthDate.'-01';
		$where.="		and (t.cuando between '$fromDate' and now())";
	}
	#time update filter
	#and (cuando_final between '2010-05-19' and now())

	#user filter
	$array[byuser_id]=secure_data($array[byuser_id],"int");

	if(($array[byuser_id]) && ($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]=='1'))
	{
		$where.="		and '$array[byuser_id]' in (t.uid,t.uid_final)";
	}

	#string filter
	//$array[csvstring]=secure_data(trim($array[csvstring]),"sql");

	if((strlen($array[csvstring])>0) && (in_array($array[w_string],array('x','s','e'))))
	{
		switch($array[w_string])
		{

			case 's'://start term
			/*
			* like way query

			$where.="		and (t.tema like '% $array[csvstring]%' or t.tema like '$array[csvstring]%')";
			*/
			/*
			* rlike way query
			*/
			$where.="		and t.tema rlike ? ";
			$array_where.="[[:<:]]$array[csvstring]";
			break;

			case 'e'://end term
			/*
			* like way query
			$where.="		and (t.tema like '%$array[csvstring] %' or t.tema like '%$array[csvstring]')";
			*/

			/*
			* rlike way query
			*/
			$where.="		and t.tema rlike ?";
			$array_where.="$array[csvstring][[:>:]]";
			break;

			case 'x'://exact term
			/*
			* like way query
			$where.="		and (t.tema like '% $array[csvstring]%') or (t.tema like '%$array[csvstring] %') or (t.tema ='$array[csvstring]')";
			$array[csvstring]=utf8(prepare2sqlregexp($array[csvstring]));
			*/
			$where.="		and t.tema rlike ?";
			$array_where.="[[:<:]]$array[csvstring][[:>:]]";
			break;

			default:
			$where.="		and t.tema rlike ?";
			$array_where.="[[:<:]]$array[csvstring][[:>:]]";
			break;
		}

	}


	#mapped terms
	$array[csv_tvocab_id]=secure_data($array[csv_tvocab_id],"int");
	if($array[csv_tvocab_id])
	{
		if ($array[mapped]=='n')
		{
			$leftJoin=" left join $DBCFG[DBprefix]term2tterm tt on tt.tema_id=t.tema_id and tt.tvocab_id='$array[csv_tvocab_id]'";
			$leftJoin.=" left join $DBCFG[DBprefix]tabla_rel as r on t.tema_id in (r.id_menor,r.id_mayor) ";
			$leftJoin.=" and r.t_relacion in (4,5,6,7)";
			$where.=" and r.id is null";
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

	#internal mapped terms
	$array[csv_itvocab_id]=secure_data($array[csv_itvocab_id],"int");
	if($array[csv_itvocab_id])
	{
		if ($array[int_mapped]=='n')
		{
			$leftJoin=" left join $DBCFG[DBprefix]tabla_rel ir on t.tema_id=ir.id_menor ";
			$leftJoin.=" left join $DBCFG[DBprefix]tema itt on itt.tema_id=ir.id_mayor and itt.tesauro_id='$array[csv_itvocab_id]'";
			$where.=" and ir.id is null";
			$where.=" and itt.tema_id is null";
			$where.=" and t.tesauro_id='1'";
		}
		else
		{
			//~ $select=" ,itt.tvocab_title as target_vocabulary_title,tt.tterm_string as target_vocabulary_term,tt.cuando as date_mapped";
			$select=" ,itt.tema as target_vocabulary_term";
			$from.=" $DBCFG[DBprefix]tema itt,$DBCFG[DBprefix]tabla_rel ir,";
			$where.=" and itt.tema_id=ir.id_mayor and itt.tesauro_id='$array[csv_itvocab_id]'";
			$where.=" and t.tema_id=ir.id_menor";
		}
	}

	$LABEL_Candidato=LABEL_Candidato;
	$LABEL_Aceptado=LABEL_Aceptado;
	$LABEL_Rechazado=LABEL_Rechazado;

	$show_code=($CFG["_USE_CODE"]=='1') ? 't.code,' : '';

	if(!strpos($where,'?'))
	{
		$where.=" and 1= ?";
		$array_where="1";
	}

	return SQLo("select","t.tema_id, $show_code t.tema,t.cuando as created_date,if(t.cuando_final is null,t.cuando,t.cuando_final) last_change,
	elt(field(t.estado_id,'12','13','14'),'$LABEL_Candidato','$LABEL_Aceptado','$LABEL_Rechazado') as status,t.isMetaTerm,concat(u.APELLIDO,', ',u.NOMBRES) as user_data $select
	from $from $DBCFG[DBprefix]values v,$DBCFG[DBprefix]usuario u, $DBCFG[DBprefix]tema t
	$leftJoin
	where t.uid=u.id
	and t.estado_id=v.value_id
	and v.value_type='t_estado'
	$initial_where
	$where
	group by t.tema_id
	$having
	order by t.tema",array($array_where));

}


/*
Comparative reports about mapped terms
*/
function SQLreportTargetTerms($tvocab_ids=array())
{

	GLOBAL $DBCFG;
	$SQLtvocabs=SQLtargetVocabulary();

	while($ARRAYtvocabs=$SQLtvocabs->FetchRow()){

		if(in_array($ARRAYtvocabs["tvocab_id"],$tvocab_ids)){

			$tvocabs[$ARRAYtvocabs["tvocab_id"]]=array("tvocab_id"=>$ARRAYtvocabs["tvocab_id"],
			"tvocab_label"=>$ARRAYtvocabs["tvocab_label"],
			"tvocab_title"=>$ARRAYtvocabs["tvocab_title"]
		);
		$select.=',tv'.$ARRAYtvocabs["tvocab_id"].'.tterm_string as "'.$ARRAYtvocabs["tvocab_label"].'"';
		$leftjoin.=' left join '.$DBCFG[DBprefix].'term2tterm tv'.$ARRAYtvocabs["tvocab_id"].' on tv'.$ARRAYtvocabs["tvocab_id"].'.tema_id=t.tema_id';
		$leftjoin.=' and tv'.$ARRAYtvocabs["tvocab_id"].'.tvocab_id='.$ARRAYtvocabs["tvocab_id"];

	}

};

//check if there are tvocabs
if(count($tvocabs)>0){

	$svocab_title='"'.$_SESSION["CFGTitulo"].'"';

	$sql=SQL("select","t.tema_id as internal_term_id,t.tema as $svocab_title
	$select
	from $DBCFG[DBprefix]tema t
	$leftjoin
	left join $DBCFG[DBprefix]tabla_rel as r on t.tema_id =r.id_mayor
	and r.t_relacion='4'
	where
	t.tesauro_id=1
	and t.estado_id=13
	and r.id is null");

}
else{
	//empy set
	$sql=SQL("select","'no_data'");
};
return $sql;
}

/*
Terms withouts notes
*/
function SQLreportNullNotes($t_note)
{

	GLOBAL $DBCFG;

	if($t_note==0){
		$sql=SQL("select","t.tema_id, t.tema as term, t.cuando as date_created, t.cuando_final as date_modicated,t.isMetaTerm,
						e.value as status_term
						from $DBCFG[DBprefix]values e,$DBCFG[DBprefix]tema t
						left join $DBCFG[DBprefix]notas n on n.id_tema=t.tema_id
						where
						e.value_id=t.estado_id
						and n.id is null
						order by t.tema");

	}else {
		//check if is valid note type
		$sqlNoteType=SQLcantNotas();
		$arrayNoteType=array();

		while ($array=$sqlNoteType->FetchRow()){
			if($array[cant]>0)
			{
				array_push($arrayNoteType, $array["tipo_nota"]);
			}
		};

		if(in_array($t_note, $arrayNoteType)){
			$sql=SQL("select","t.tema_id, t.tema as term, t.cuando as date_created, t.cuando_final as date_modicated,t.isMetaTerm,
							e.value as status_term
							from $DBCFG[DBprefix]values e,$DBCFG[DBprefix]tema t
							left join $DBCFG[DBprefix]notas n on n.id_tema=t.tema_id
							and n.tipo_nota='$t_note'
							where
							e.value_id=t.estado_id
							and n.id is null
							order by t.tema");
		}else {
			//empy set
			$sql=SQL("select","'no_data'");
		}
	}

return $sql;
}
/*
regenerate indice table => only in case of corrupt database or import thesaurus vÃ­a dump
*/
function SQLreCreateTermIndex()
{

	GLOBAL $DBCFG;

	$sqlTerminosValidos=SQLIdTerminosValidos();

	$sqlTruncate=SQL("truncate","$DBCFG[DBprefix]indice");

	while($array=$sqlTerminosValidos->FetchRow()){
		$i=++$i;

		$este_tema_id=$array[0];

		$tema_ids_inverso=generaIndices($array[0]);

		$tema_ids_inverso=array_reverse(explode("|",$tema_ids_inverso));

		foreach($tema_ids_inverso as $tema_id){
			$indice[$este_tema_id].='|'.$tema_id;
		}

		if ($DBCFG["debugMode"] == "1") echo $indice[$este_tema_id].': '.$este_tema_id.'<br>';

		$esteindice=substr($indice[$este_tema_id],1);

		$sql=SQL("insert","into $DBCFG[DBprefix]indice values ('$array[0]','$esteindice')");
	};

	//Check some problems
	//1) code null
	$sql=SQL("update"," $DBCFG[DBprefix]tema set code=null where length(code)<1 ");
	//2) change date 0000
	$sql=SQL("update"," $DBCFG[DBprefix]tema set cuando_final=null where cuando_final='0000-00-00' ");
	$sql=SQL("update"," $DBCFG[DBprefix]tema set cuando=now() where cuando='0000-00-00' ");

	return array("cant_terms_index"=>$i);
}


#
# Optimiza tablas == $tablas
#
function SQLoptimizarTablas($tablas){

	GLOBAL $DBCFG;

	//SQL to set null all code empty
	$sqlNull=SQL("UPDATE","$DBCFG[DBprefix]tema SET code = NULL code is not null and length(code)=0");

	return SQL("OPTIMIZE","TABLE $tablas");

};



#
# actualiza version // update version
#
function SQLupdateTemaTresVersion($ver2ver){

	GLOBAL $DBCFG;


	$prefix=$DBCFG['DBprefix'] ;

	switch ($ver2ver) {

		case '1_6x1_7':
		$sql1_6x1_7=SQL("ALTER"," TABLE `".$prefix."tema` ADD `isMetaTerm` BOOLEAN NOT NULL DEFAULT FALSE,ADD INDEX ( `isMetaTerm` ) ");

		$ctrl=ARRAYfetchValueXValue('config','CFG_SEARCH_METATERM');
		if(!$ctrl[value_id])
		{
			$sql1_6x1_7a=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
			('config', 'CFG_SEARCH_METATERM', NULL, '0')");
		}
		$ctrl=ARRAYfetchValueXValue('config','CFG_ENABLE_SPARQL');
		if(!$ctrl[value_id])
		{
			$sql1_6x1_7b=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
			('config', 'CFG_ENABLE_SPARQL', NULL, '0')");
		}

		$ctrl=ARRAYfetchValueXValue('config','CFG_SUGGESTxWORD');
		if(!$ctrl[value_id])
		{
			$sql1_6x1_7c=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
			('config', 'CFG_SUGGESTxWORD', NULL, '1')");
		}


		$logTask["1_6x1_7"] = SQLcount($sql1_6x1_7a);
		break;

		case '1_5x1_6':
		$sql1_5x1_6=SQL("ALTER"," TABLE `".$prefix."term2tterm` ADD INDEX `target_terms` ( `tterm_string` ) ");
		$sql1_5x1_6a=SQL("ALTER"," TABLE `".$prefix."usuario` ADD `user_activation_key` VARCHAR( 60 ) NULL , ADD INDEX ( `user_activation_key` ) ");
		$sql1_5x1_6b=SQL("ALTER"," TABLE `".$prefix."usuario` CHANGE `pass` `pass` VARCHAR( 60$ver2ver ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''");

		$logTask["1_5x1_6"] = SQLcount($sql1_6x1_6);
		break;

		case '1_4x1_5':
		$sql1_4x1_5a=SQL("ALTER"," TABLE `".$prefix."tvocab` CHANGE `tvocab_tag` `tvocab_tag` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");

		$sql1_4x1_5b=SQL("ALTER"," TABLE `".$prefix."values` CHANGE `value_code` `value_code` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");

		$sql1_4x1_5b=SQL("ALTER"," TABLE `".$prefix."values` CHANGE `value` `value` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");

		$sql1_4x1_5b=SQL("ALTER"," TABLE `".$prefix."values` CHANGE `value_type` `value_type` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");

		$sql1_4x1_5c=SQL("ALTER","TABLE `".$prefix."tabla_rel` ADD `rel_rel_id` INT( 22 ) NULL AFTER `t_relacion` ,ADD INDEX ( `rel_rel_id` )");

		$sql1_4x1_5d=SQL("CREATE"," TABLE IF NOT EXISTS `".$prefix."uri` (
		`uri_id` int(22) NOT NULL AUTO_INCREMENT,
		`tema_id` int(22) NOT NULL,
		`uri_type_id` int(22) NOT NULL,
		`uri` tinytext NOT NULL,
		`uid` int(22) NOT NULL,
		`cuando` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`uri_id`),
		KEY `tema_id` (`tema_id`)
		) DEFAULT CHARSET=utf8 ENGINE=MyISAM  COMMENT='external URIs associated to terms';");

		if($sql1_4x1_5c)
		{

			$ctrl=ARRAYfetchValue('4','SP');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('4', 'Spelling variant', NULL, 'SP')");
			}

			$ctrl=ARRAYfetchValue('4','MS');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('4', 'MisSpelling', NULL, 'MS')");
			}

			$ctrl=ARRAYfetchValue('3','P');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('3', 'Partitive', NULL, 'P')");
			}

			$ctrl=ARRAYfetchValue('3','I');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('3', 'Instance', NULL, 'I')");
			}

			$ctrl=ARRAYfetchValue('4','H');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('4', 'Hidden label', NULL, 'H')");
			}

			$ctrl=ARRAYfetchValue('4','AB');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('4', 'Abbreviation', NULL, 'AB')");
			}

			$ctrl=ARRAYfetchValue('4','FT');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('4', 'Full form of the term', NULL, 'FT')");
			}

			$ctrl=ARRAYfetchValue('URI_TYPE','broadMatch');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('URI_TYPE', 'broadMatch', NULL, 'broadMatch')");
			}

			$ctrl=ARRAYfetchValue('URI_TYPE','closeMatch');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('URI_TYPE', 'closeMatch', NULL, 'closeMatch')");
			}

			$ctrl=ARRAYfetchValue('URI_TYPE','exactMatch');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('URI_TYPE', 'exactMatch', NULL, 'exactMatch')");
			}

			$ctrl=ARRAYfetchValue('URI_TYPE','relatedMatch');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('URI_TYPE', 'relatedMatch', NULL, 'relatedMatch')");
			}

			$ctrl=ARRAYfetchValue('URI_TYPE','narrowMatch');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('URI_TYPE', 'narrowMatch', NULL, 'narrowMatch')");
			}

			$ctrl=ARRAYfetchValue('DATESTAMP','NOTE_CHANGE');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('DATESTAMP', now(), NULL, 'NOTE_CHANGE')");
			}

			$ctrl=ARRAYfetchValue('DATESTAMP','TERM_CHANGE');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('DATESTAMP', now(), NULL, 'TERM_CHANGE')");
			}

			$ctrl=ARRAYfetchValue('DATESTAMP','TTERM_CHANGE');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('DATESTAMP', now(), NULL, 'TTERM_CHANGE')");
			}

			$ctrl=ARRAYfetchValue('DATESTAMP','THES_CHANGE');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('DATESTAMP', now(), NULL, 'THES_CHANGE')");
			}

			$ctrl=ARRAYfetchValue('METADATA','dc:contributor');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('METADATA', NULL, 2, 'dc:contributor')");
			}

			$ctrl=ARRAYfetchValue('METADATA','dc:publisher');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('METADATA', NULL, 5, 'dc:publisher')");
			}

			$ctrl=ARRAYfetchValue('METADATA','dc:rights');
			if(!$ctrl[value_id])
			{
				$sqlvalue=SQL("insert","into `".$prefix."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
				('METADATA', NULL, 9, 'dc:rights')");
			}

		};

		$result5 = SQL("insert","into `".$prefix."values` (`value_id`, `value_type`, `value`, `value_order`, `value_code`) VALUES
		(15, 't_nota', 'Nota catalográfica', 5, 'NC'),
		(16, 'config', '_USE_CODE', 1, '1'),
		(17, 'config', '_SHOW_CODE', 1, '1'),
		(18, 'config', 'CFG_MAX_TREE_DEEP', NULL, '3'),
		(19, 'config', 'CFG_VIEW_STATUS', NULL, '0'),
		(20, 'config', 'CFG_SIMPLE_WEB_SERVICE', NULL, '1'),
		(21, 'config', 'CFG_NUM_SHOW_TERMSxSTATUS', NULL, '200'),
		(22, 'config', 'CFG_MIN_SEARCH_SIZE', NULL, '2'),
		(23, 'config', '_SHOW_TREE', '1', '1'),
		(24, 'config', '_PUBLISH_SKOS', '1', '0')");

		$logTask["1_3x1_4"] = SQLcount($result5);
		break;

		case '1_1x1_2' :
		$result61 = SQL("CREATE"," TABLE IF NOT EXISTS `".$prefix."term2tterm` (
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
		) DEFAULT CHARSET=utf8 ENGINE=MyISAM") ;

		$result62 = SQL("CREATE"," TABLE IF NOT EXISTS `".$prefix."tvocab` (
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
		) DEFAULT CHARSET=utf8 ENGINE=MyISAM ;") ;

		$result622 = SQL("ALTER"," TABLE `".$prefix."notas` ADD FULLTEXT `notas` (`nota`);");

		$result5 = SQL("insert","into `".$prefix."values` (`value_id`, `value_type`, `value`, `value_order`, `value_code`) VALUES
		(15, 't_nota', 'Nota catalográfica', 5, 'NC'),
		(16, 'config', '_USE_CODE', 1, '1'),
		(17, 'config', '_SHOW_CODE', 1, '1'),
		(18, 'config', 'CFG_MAX_TREE_DEEP', NULL, '3'),
		(19, 'config', 'CFG_VIEW_STATUS', NULL, '0'),
		(20, 'config', 'CFG_SIMPLE_WEB_SERVICE', NULL, '1'),
		(21, 'config', 'CFG_NUM_SHOW_TERMSxSTATUS', NULL, '200'),
		(22, 'config', 'CFG_MIN_SEARCH_SIZE', NULL, '2'),
		(23, 'config', '_SHOW_TREE', '1', '1'),
		(24, 'config', '_PUBLISH_SKOS', '1', '0')");

		$logTask["1_1x1_2"] = $result61+$result62+$result622;
		break;


		case '1x1_2' :
		//update to 1.1
		$result60=SQL("ALTER"," TABLE `".$prefix."tema` ADD `code` VARCHAR( 30 ) NULL COMMENT 'code_term' AFTER `tema_id`") ;
		$result601=SQL("ALTER"," TABLE `".$prefix."tema` ADD INDEX ( `code` )") ;

		$result61 = SQL("CREATE"," TABLE IF NOT EXISTS `".$prefix."term2tterm` (
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
		) DEFAULT CHARSET=utf8 ENGINE=MyISAM") ;

		$result62 = SQL("CREATE"," TABLE IF NOT EXISTS `".$prefix."tvocab` (
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
		) DEFAULT CHARSET=utf8 ENGINE=MyISAM ;") ;

		$result622 = SQL("ALTER"," TABLE `".$prefix."notas` ADD FULLTEXT `notas` (`nota`);");

		$result5 = SQL("insert","into `".$prefix."values` (`value_id`, `value_type`, `value`, `value_order`, `value_code`) VALUES
		(15, 't_nota', 'Nota catalográfica', 5, 'NC'),
		(16, 'config', '_USE_CODE', 1, '1'),
		(17, 'config', '_SHOW_CODE', 1, '1'),
		(18, 'config', 'CFG_MAX_TREE_DEEP', NULL, '3'),
		(19, 'config', 'CFG_VIEW_STATUS', NULL, '0'),
		(20, 'config', 'CFG_SIMPLE_WEB_SERVICE', NULL, '1'),
		(21, 'config', 'CFG_NUM_SHOW_TERMSxSTATUS', NULL, '200'),
		(22, 'config', 'CFG_MIN_SEARCH_SIZE', NULL, '2'),
		(23, 'config', '_SHOW_TREE', '1', '1'),
		(24, 'config', '_PUBLISH_SKOS', '1', '0')");


		$logTask["1x1_2"] = SQLcount($result61)+SQLcount($result62)+SQLcount($result622)+SQLcount($result60)+SQLcount($result601);
		break;


		case '1x1_2' :
		//update to 1.1
		$result60 =SQL("ALTER"," TABLE `".$prefix."tema` ADD `code` VARCHAR( 20 ) NULL COMMENT 'code_term' AFTER `tema_id`") ;
		$result601 =SQL("ALTER"," TABLE `".$prefix."tema` ADD INDEX ( `code` )") ;



		$result61 = SQL("CREATE"," TABLE IF NOT EXISTS `".$prefix."term2tterm` (
		`tterm_id` int(22) NOT NULL AUTO_INCREMENT,
		`tvocab_id` int(22) NOT NULL,
		`tterm_url` varchar(200) NOT NULL,
		`tterm_uri` varchar(200) NOT NULL,
		`tterm_string` varchar(250) NOT NULL,
		`cuando` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		`cua
		` int(22) NOT NULL,
		`tema_id` int(22) NOT NULL,
		PRIMARY KEY (`tterm_id`),
		KEY `tvocab_id` (`tvocab_id`,`cuando`,`cuando_last`,`uid`),
		KEY `tema_id` (`tema_id`),
		KEY `tterm_string` (`tterm_string`)
		) DEFAULT CHARSET=utf8 ENGINE=MyISAM") ;

		$result62 = SQL("CREATE"," TABLE IF NOT EXISTS `".$prefix."tvocab` (
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
		) DEFAULT CHARSET=utf8 ENGINE=MyISAM ;") ;

		$result5 = SQL("insert","into `".$prefix."values` (`value_id`, `value_type`, `value`, `value_order`, `value_code`) VALUES
		(15, 't_nota', 'Nota catalográfica', 5, 'NC'),
		(16, 'config', '_USE_CODE', 1, '1'),
		(17, 'config', '_SHOW_CODE', 1, '1'),
		(18, 'config', 'CFG_MAX_TREE_DEEP', NULL, '3'),
		(19, 'config', 'CFG_VIEW_STATUS', NULL, '0'),
		(20, 'config', 'CFG_SIMPLE_WEB_SERVICE', NULL, '1'),
		(21, 'config', 'CFG_NUM_SHOW_TERMSxSTATUS', NULL, '200'),
		(22, 'config', 'CFG_MIN_SEARCH_SIZE', NULL, '2'),
		(23, 'config', '_SHOW_TREE', '1', '1'),
		(24, 'config', '_PUBLISH_SKOS', '1', '0')");


		$result622 = SQL("ALTER"," TABLE `".$prefix."notas` ADD FULLTEXT `notas` (`nota`);");

		$logTask["1x1_2"] = SQLcount($result61)+SQLcount($result62)+SQLcount($result622)+SQLcount($result60)+SQLcount($result601);
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
	return $sql->FetchRow();
}

/*
data about target vocabularies providers
*/
function SQLtargetVocabulary($tvocab_status="1",$tvocab_id="0")
{
	GLOBAL $DBCFG;

	$tvocab_id=secure_data($tvocab_id,"int");

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

	$tema_id=secure_data($tema_id,"int");
	$tterm_id=secure_data($tterm_id,"int");

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

	return $sql->FetchRow();
}

function SQLtargetTermsVocabulary($tvocab_id,$from="0",$limit="20")
{
	GLOBAL $DBCFG;

	$tvocab_id=secure_data($tvocab_id,"int");

	$from=(is_numeric($from)) ? $from : "0";

	$limit=(is_numeric($limit)) ? $limit : "20";

	$idUser=secure_data($idUser,"int");

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
	$tvocab_id=secure_data($tvocab_id,"int");

	//term no mapped and no UF or EQ
	return SQL("select","t.tema_id,t.tema,t.cuando,t.cuando_final,t.isMetaTerm
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
* Search terms for specific foreign URI provided by target vocabulary
*
*/
function SQLsourceTermsByURI($URI_term)
{
	GLOBAL $DBCFG;

	$URI_term=secure_data($URI_term,"ADOsql");

	return SQL("select","t.tema_id,t.tema,t.code,c.idioma,t.cuando,t.cuando_final,t.isMetaTerm
	from $DBCFG[DBprefix]tvocab tv,$DBCFG[DBprefix]term2tterm t2tt,$DBCFG[DBprefix]tema t,$DBCFG[DBprefix]config c
	where tv.tvocab_id=t2tt.tvocab_id
	and t.tema_id=t2tt.tema_id
	and c.id=t.tesauro_id
	and t2tt.tterm_uri =$URI_term
	order by t.tema");
}

/*
* Search terms for specific foreign term provided by ANY target vocabulary
*
*/
function SQLsourceTermsByTerm($term)
{
	GLOBAL $DBCFG;

	$term=secure_data($term,"ADOsql");

	return SQL("select","t.tema_id,t.tema,t.code,c.idioma,t.cuando,t.cuando_final,t.isMetaTerm
	from $DBCFG[DBprefix]tvocab tv,$DBCFG[DBprefix]term2tterm t2tt,$DBCFG[DBprefix]tema t,$DBCFG[DBprefix]config c
	where tv.tvocab_id=t2tt.tvocab_id
	and t.tema_id=t2tt.tema_id
	and c.id=t.tesauro_id
	and t2tt.tterm_string =$term
	order by t.tema");
}


/*
terms by status (only candidate or reject)
*/
function SQLtermsXstatus($tesauro_id,$status_id)
{
	GLOBAL $DBCFG;
	GLOBAL $CFG;

	$tesauro_id=secure_data($tesauro_id,"int");

	$status_id=($status_id=='12') ? '12' : '14';


	$show_code=($CFG["_USE_CODE"]=='1') ? 't.code,' : '';



	//term no mapped and no UF or EQ
	return SQL("select","t.tema_id, $show_code t.tema,t.cuando,t.isMetaTerm, concat(u.APELLIDO,', ',u.NOMBRES) as user_data,v.value as status,t.cuando_estado
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

	return SQL("select","t.tema_id,t.tema,t.cuando,t.isMetaTerm, count(t.tema_id) as cantBT
	from $DBCFG[DBprefix]tema t,$DBCFG[DBprefix]usuario u, $DBCFG[DBprefix]tabla_rel r
	where t.uid=u.id
	and t.tema_id=r.id_menor
	and t_relacion='3'
	group by t.tema_id
	having cantBT>1
	order by t.tema");
}


/*
preferred and accepted terms with the number of narrower terms
*/
function SQLtermsXcantNT()
{
	GLOBAL $DBCFG;

	$LABELdeepTerm=string2url(LABEL_ProfundidadTermino);

	return SQL("select","t.tema_id,t.tema,t.isMetaTerm, LENGTH(i.indice) - LENGTH(REPLACE(i.indice, '|', '')) as deepLevel,count(r.id_menor) as cant,
	t.cuando,concat(u.APELLIDO,', ',u.NOMBRES) as user_data
	FROM $DBCFG[DBprefix]tema t, $DBCFG[DBprefix]usuario u,$DBCFG[DBprefix]tabla_rel r,$DBCFG[DBprefix]indice i
	where
	t.tema_id=r.id_mayor
	and r.t_relacion='3'
	and i.tema_id=t.tema_id
	and u.id=t.uid
	group by t.tema_id
	order by cant desc,t.tema");
}

/*
preferred and accepted terms without hierarchical relationships
*/
function SQLtermsNoBT($tesauro_id)
{
	GLOBAL $DBCFG;

	$tesauro_id=secure_data($tesauro_id,"int");

	return SQL("select","t.tema_id,t.tema,t.cuando,t.isMetaTerm,count(rt.id) cant_RT,count(uf.id) cant_UF
	from
	$DBCFG[DBprefix]tema t
	left join $DBCFG[DBprefix]tabla_rel rt on t.tema_id=rt.id_mayor and rt.t_relacion='2'
	left join $DBCFG[DBprefix]tabla_rel uf on t.tema_id=uf.id_menor and uf.t_relacion='4'
	left join $DBCFG[DBprefix]tabla_rel uf1 on t.tema_id=uf1.id_mayor and uf1.t_relacion='4'
	left join $DBCFG[DBprefix]tabla_rel bt on t.tema_id =bt.id_menor and bt.t_relacion='3'
	left join $DBCFG[DBprefix]tabla_rel nt on t.tema_id =nt.id_mayor and nt.t_relacion='3'
	where
	bt.id is null
	and nt.id is null
	and uf1.id is null
	and t.estado_id='13'
	and t.tesauro_id='$tesauro_id'
	group by t.tema_id
	order by t.tema");
}

/*
preferred and accepted terms with words count
*/
function SQLtermsXcantWords($tesauro_id)
{
	GLOBAL $DBCFG;

	$tesauro_id=secure_data($tesauro_id,"int");

	return SQL("select","t.tema_id,t.tema,t.isMetaTerm, SUM( LENGTH(t.tema) - LENGTH(REPLACE(t.tema, ' ', ''))+1) as cant,
	t.cuando,concat(u.APELLIDO,', ',u.NOMBRES) as user_data,t.cuando_estado
	FROM $DBCFG[DBprefix]usuario u,$DBCFG[DBprefix]tema t
	left join $DBCFG[DBprefix]tabla_rel uf on t.tema_id=uf.id_mayor and uf.t_relacion='4'
	where t.tesauro_id='$tesauro_id'
	and uf.id is null
	and u.id=t.uid
	group by tema_id
	order by cant desc");
}



//get term_id from string in notes
function fetchTermIdxNote($string)
{
	GLOBAL $DBCFG;

	$string=secure_data($string,"ADOsql");

	$sql=SQL("select","t.tema_id
	from $DBCFG[DBprefix]notas n,$DBCFG[DBprefix]tema t
	where n.nota=$string
	and t.tema_id=n.id_tema");

	$array=$sql->FetchRow();

	return $array[tema_id];
}



//get term_id from string
function fetchTermId($string,$tesauro_id="1")
{
	GLOBAL $DBCFG;
	GLOBAL $DB;

	$string=$DB->qstr($string,get_magic_quotes_gpc());

	$sql=SQL("select","tema_id
	from $DBCFG[DBprefix]tema t
	where t.estado_id ='13'
	and t.tesauro_id='$tesauro_id'
	and t.tema=$string");

	$array=$sql->FetchRow();

	return $array[tema_id];
}


//get vocabulary config values
function SQLconfigValues()
{
	GLOBAL $DBCFG;
	return SQL("select","v.value_id,v.value_type,v.value,v.value_code,v.value_order
	from $DBCFG[DBprefix]values v
	where v.value_type='config'");
}


//get array data about one terminological relation
function ARRAYdataRelation($rel_id)
{
	GLOBAL $DBCFG;

	$sql=SQL("select","r.id as rel_id,
	r.id_mayor,
	r.id_menor,
	r.t_relacion,
	r.t_relacion as t_relation,
	vr.value_code as r_code,
	vr.value as r_value,
	r.rel_rel_id,
	vrr.value_code as rr_code,
	vrr.value as rr_value
	from $DBCFG[DBprefix]values vr ,$DBCFG[DBprefix]tabla_rel r
	left join $DBCFG[DBprefix]values vrr on r.rel_rel_id = vrr.value_id
	where
	r.t_relacion=vr.value_id
	and vr.value_type='t_relacion'
	and r.id='$rel_id'
	group by r.id");
	return $sql->FetchRow();

}


//data about extended type relations
function SQLtypeRelations($t_relation=0,$rrel_type_id=0,$cant=false)
{
	GLOBAL $DBCFG;

	$t_relation=secure_data($t_relation,"int");
	$rrel_type_id=secure_data($rrel_type_id,"int");

	$where=($t_relation>0) ? " and trr.value_type='$t_relation' " : "";
	$where.=($rrel_type_id>0) ? " and trr.value_id='$rrel_type_id' " : "";

	if($cant==true)
	{
		$select=",count(r.rel_rel_id) as cant ";
		$from=" left join $DBCFG[DBprefix]tabla_rel r on r.rel_rel_id=trr.value_id ";
	}



	return SQL("select","tr.value_id as t_relation,
	tr.value_code as r_code,
	tr.value as r_value,
	trr.value_id as rel_rel_id,
	trr.value_code as rr_code,
	trr.value_order as rr_ord,
	trr.value as rr_value
	$select
	from $DBCFG[DBprefix]values tr, $DBCFG[DBprefix]values trr
	$from
	where tr.value_id=trr.value_type
	and tr.value_type='t_relacion'
	$where
	group by trr.value_id
	order by tr.value_order,tr.value_id, trr.value_order,trr.value_id");
}


//data about extended type relations
function ARRAYtypeRelations($t_relation=0,$rrel_type_id=0)
{
	$sql=SQLtypeRelations($t_relation,$rrel_type_id);

	if($sql)
	{

		while($array=$sql->FetchRow()){
			$i=++$i;
			$arrayRelations["$array[t_relation]"]["$array[rr_id]"]["t_relation"].=$array[t_relation];
			$arrayRelations["$array[t_relation]"]["$array[rr_id]"]["r_code"].=$array[r_code];
			$arrayRelations["$array[t_relation]"]["$array[rr_id]"]["rr_id"].=$array[rel_rel_id];
			$arrayRelations["$array[t_relation]"]["$array[rr_id]"]["rr_value"].=$array[rr_value];
			$arrayRelations["$array[t_relation]"]["$array[rr_id]"]["rr_code"].=$array[rr_code];
			$arrayRelations["$array[t_relation]"]["$array[rr_id]"]["rr_cant_rel"].=$array[rr_cant_rel];
		}
	}
	else
	{
		$arrayRelations=array();
	}
	return $arrayRelations;
}



//list of URI definitions
function SQLURIdefinition($uri_type_id=0)
{
	GLOBAL $DBCFG;

	$where =($uri_type_id>0) ? " and v.value_id='$uri_type_id' " : "";

	return SQL("select","v.value_id as uri_type_id,
	v.value as uri_value,
	v.value_code as uri_code,
	v.value_order,
	count(u.uri_id) as uri_cant
	from $DBCFG[DBprefix]values v
	left join $DBCFG[DBprefix]uri u on v.value_id=u.uri_type_id
	where v.value_type='URI_TYPE'
	$where
	group by v.value_id
	order by v.value_order,v.value_code");
}



//list of URIs associated to one term
function SQLURIxterm($tema_id)
{
	GLOBAL $DBCFG;

	$tema_id=secure_data($tema_id,"int");

	return SQL("select","t.tema_id,t.tema,t.code,v.value_id as uri_type_id,
	v.value as uri_value,
	v.value_code as uri_code,
	v.value_order,
	u.uri_id,
	u.uri
	from $DBCFG[DBprefix]values v,
	$DBCFG[DBprefix]uri u,
	$DBCFG[DBprefix]tema t
	where v.value_type='URI_TYPE'
	and v.value_id=u.uri_type_id
	and u.tema_id=t.tema_id
	and u.tema_id='$tema_id'
	order by v.value_order,v.value_code");
}

//list of URIs associated to one term
function ARRAY_URI($uri_id)
{
	GLOBAL $DBCFG;

	$uri_id=secure_data($uri_id,"int");

	$sql=SQL("select","t.tema_id,t.tema,t.code,v.value_id as uri_type_id,
	v.value as uri_value,
	v.value_code as uri_code,
	v.value_order
	from $DBCFG[DBprefix]values v,
	$DBCFG[DBprefix]uri u,
	$DBCFG[DBprefix]tema t
	where v.value_type='URI_TYPE'
	and v.value_id=u.uri_type_id
	and u.tema_id=t.tema_id
	and u.uri_id='$uri_id'
	order by v.value_order,v.value_code");

	if($sql) return $sql->FetchRow();
}


//SQL fetch value
function SQLfetchValue($value_type,$value_code="")
{
	GLOBAL $CFG;
	GLOBAL $DB;
	GLOBAL $DBCFG;


	if(in_array($value_type,$CFG["CONFIG_VAR"]))
	{
		if($value_code)
		{
			$value_code=$DB->qstr($value_code,get_magic_quotes_gpc());

			$where=($value_code) ? " and v.value_code=$value_code " : "";
		}

		return SQL("select","v.value_id,
		v.value_type,
		v.value,
		v.value_code,
		v.value_order
		from $DBCFG[DBprefix]values v
		where value_type='$value_type'
		$where
		order by value_order,value_code,value");


	};
}


//fetch specific value
function ARRAYfetchValueXValue($value_type,$value)
{
	GLOBAL $CFG;
	GLOBAL $DB;
	GLOBAL $DBCFG;


	$value=$DB->qstr($value,get_magic_quotes_gpc());
	$value_type=$DB->qstr($value_type,get_magic_quotes_gpc());

	$sql=SQL("select","v.value_id,
	v.value_type,
	v.value,
	v.value_code,
	v.value_order
	from $DBCFG[DBprefix]values v
	where value=$value
	and value_type=$value_type
	order by value_order,value_code,value");
	return $sql->FetchRow();

}


function ARRAYfetchValue($value_type,$value_code="")
{
	$sql=SQLfetchValue($value_type,$value_code);

	return $sql->FetchRow();
}


//array values for one value_type
function ARRAYfetchValues($value_type)
{
	$sql=SQLfetchValue($value_type);

	while($array=$sql->FetchRow()){
		$i=++$i;
		$ARRAYvalues["$array[value_code]"][value_id].=$array[value_id];
		$ARRAYvalues["$array[value_code]"][value_type].=$array[value_type];
		$ARRAYvalues["$array[value_code]"][value_code].=$array[value_code];
		$ARRAYvalues["$array[value_code]"][value].=$array[value];
	}
	return $ARRAYvalues;
}


function fetchlastMod($value_code="")
{
	GLOBAL $DBCFG;
	GLOBAL $CFG;

	$where=in_array($value_code,array('THES_CHANGE','TTERM_CHANGE','TERM_CHANGE','NOTE_CHANGE')) ? " and v.value_code='$value_code' " : "";

	$sql=SQL("select","max(v.value) last from $DBCFG[DBprefix]values v
	where v.value_type='DATESTAMP'
	$where");

	$array= $sql->FetchRow();

	return $array[last];
}

//Retrieve last update of SPARQL endpoint
function fetchlastUpdateEndpoint()
{
	return ARRAYfetchValue('DATESTAMP','ENDPOINT_CHANGE');
}


// retieve data about target vocabulary by URI
function ARRAYtargetVocabularyXuri($tvocab_uri)
{
	GLOBAL $DBCFG;

	$tvocab_uri=secure_data($tvocab_uri,"ADOsql");

	if(isset($tvocab_uri))
	{
		$sql=SQL("select","tv.tvocab_id,tv.tvocab_label,tv.tvocab_tag,tv.tvocab_lang,
		tv.tvocab_title,tv.tvocab_url,tv.tvocab_uri_service,tv.tvocab_status,tv.cuando,tv.uid,
		count(t2t.tterm_id) as cant
		from $DBCFG[DBprefix]tvocab tv
		left join $DBCFG[DBprefix]term2tterm t2t on tv.tvocab_id=t2t.tvocab_id
		where tv.tvocab_uri_service='$tvocab_uri'
		group by tv.tvocab_id
		order by tv.tvocab_tag,tv.tvocab_title");
		return $sql->FetchRow();

	}
	else
	{
		return array();
	}

}

//retrieve data about meta terms
function SQLtermsIsMetaTerms($tesauro_id)
{
	GLOBAL $DBCFG;
	GLOBAL $CFG;

	$tesauro_id=secure_data($tesauro_id,"int");

	$show_code=($CFG["_USE_CODE"]=='1') ? 't.code,' : '';

	return SQL("select","t.tema_id, $show_code t.tema,t.cuando,t.isMetaTerm, concat(u.APELLIDO,', ',u.NOMBRES) as user_data,v.value as status,t.cuando_estado
	from $DBCFG[DBprefix]usuario u,$DBCFG[DBprefix]values v,$DBCFG[DBprefix]tema as t
	where
	t.tesauro_id='$tesauro_id'
	and u.id=t.uid
	and v.value_id=t.estado_id
	and v.value_type='t_estado'
	and t.isMetaTerm=1
	order by lower(t.tema)");
}

//retieve terms with RT
function SQLtermsXrelatedTerms($tesauro_id,$tema_id=0)
{
	GLOBAL $DBCFG;

	$tesauro_id=secure_data($tesauro_id,"int");

	$r_label=TR_acronimo;

	$tema_id=secure_data($tema_id,"int");

	$where=($tema_id>0) ? " and t.tema_id='$tema_id'":"";

	return SQL("select","t.tema_id ,t.tema,t.cuando,t.isMetaTerm,
	'$r_label' as type, v.value as sub_type,
	t2.tema_id as rt_tema_id ,t2.tema as rt_tema,t2.cuando as rt_cuando,t2.isMetaTerm as rt_isMetaTerm
	from
	$DBCFG[DBprefix]tema as t,
	$DBCFG[DBprefix]tema as t2,
	$DBCFG[DBprefix]tabla_rel as r
	left join $DBCFG[DBprefix]values v on v.value_id=r.rel_rel_id and v.value_type=r.t_relacion
	where
	t.tesauro_id='$tesauro_id'
	$where
	and r.id_mayor=t.tema_id
	and r.id_menor=t2.tema_id
	and r.t_relacion=2
	order by lower(t.tema)");

}

//retieve terms with UF
function SQLtermsXNonPreferedTerms($tesauro_id,$tema_id=0)
{
	GLOBAL $DBCFG;

	$tesauro_id=secure_data($tesauro_id,"int");

	$r_label=UP_acronimo;

	$tema_id=secure_data($tema_id,"int");

	$where=($tema_id>0) ? " and t.tema_id='$tema_id'":"";

	return SQL("select","t.tema_id ,t.tema,t.cuando,t.isMetaTerm,
	'$r_label' as type, v.value as sub_type,
	t2.tema_id as uf_tema_id ,t2.tema as uf_tema,t2.cuando as uf_cuando
	from
	$DBCFG[DBprefix]tema as t,
	$DBCFG[DBprefix]tema as t2,
	$DBCFG[DBprefix]tabla_rel as r
	left join $DBCFG[DBprefix]values v on v.value_id=r.rel_rel_id and v.value_type=r.t_relacion
	where
	t.tesauro_id='$tesauro_id'
	$where
	and r.id_menor=t.tema_id
	and r.id_mayor=t2.tema_id
	and r.t_relacion=4
	order by lower(t.tema)");
}


#
# Retrieve top term for a given term_id. Can retrieve any term according to level expressed in index value
#
function ARRAYmyTopTerm($term_id,$index="1")
{

	$myIndex=ARRAYIndexTema($term_id);

	$arrayMyIndex=explode('|', $myIndex["indice"]);

	$arrayTerm=ARRAYverTerminoBasico($arrayMyIndex[$index]);

	return $arrayTerm;
}

#
# total number of descendant terms for given $tema_id
#
function cantChildTerms($tema_id)
{
	GLOBAL $DBCFG;
	$tema_id=secure_data($tema_id,"int");

	$like='"%|'.$tema_id.'|%"';

	$sql=SQL("select"," count(*) as cant from $DBCFG[DBprefix]indice where indice like $like");

	$array=(is_object($sql)) ? $sql->FetchRow() : array("cant"=>0);

	return $array["cant"];
}
?>
