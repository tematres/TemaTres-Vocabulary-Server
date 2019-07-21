select TT.tema,TT.tema_id,TT.isMetaTerm
,count(DISTINCT i.tema_id )
		from acm2012__tabla_rel as relaciones,
		acm2012__indice i,
		acm2012__tema as TT
		left join acm2012__tabla_rel as no_menor on no_menor.id_menor=TT.tema_id
		and no_menor.t_relacion='3'
		where
		TT.tema_id=relaciones.id_mayor
		and relaciones.t_relacion='3'
		and no_menor.id is null
        and i.indice like "|72|%"
		group by TT.tema_id


		- notas normalizadas
		- stem
		- acutalizar librerias
		alineación glosado


		http://vocabularios.educacion.gov.ar/admin/tesauro/sobre