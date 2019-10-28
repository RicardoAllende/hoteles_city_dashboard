SELECT u.institution AS 'Unidad operativa', u.department AS 'Puesto', mat.Usuario, a.Nombre, mat.Curso, a.Estatus

FROM (SELECT DISTINCT u.username AS Usuario, c.fullname AS Curso, c.id, c.visible AS Visible
FROM prefix_user u
JOIN prefix_user_enrolments AS ue ON ue.userid=u.id
JOIN prefix_enrol AS e ON e.id=ue.enrolid
JOIN prefix_role_assignments AS ra ON ra.userid=u.id
JOIN prefix_context AS ct ON ct.id=ra.contextid AND ct.contextlevel=50
JOIN prefix_course AS c ON c.id=ct.instanceid AND e.courseid=c.id 

WHERE e.status=0 AND u.suspended=0 AND u.deleted=0
  AND (ue.timeend=0 OR dateadd(ss,ue.timeend, '1970-01-01 00:00:00') > getdate()) AND ue.status=0) AS mat
JOIN prefix_user AS u ON u.username=mat.Usuario
JOIN (SELECT u.institution AS institution, u.department AS department, u.username AS usuario,
u.firstname + ' ' + u.lastname AS Nombre,
c.fullname AS Curso, 
CASE
 WHEN  dateadd(ss,cc.timecompleted, '1970-01-01 00:00:00')>0
  THEN 'Completado'
 ELSE 'No Completado'
END AS Estatus

FROM prefix_course_completions AS cc
JOIN prefix_course AS c ON c.id=cc.course
JOIN prefix_user AS u ON cc.userid=u.id


WHERE u.deleted=0 
AND
(
	(
	u.institution LIKE '__CENLD'  OR u.institution LIKE '___CECMA'  OR u.institution LIKE '___CJAGU' 
	OR u.institution LIKE '___CEALM' 	OR u.institution LIKE '___CJTCC' 	OR u.institution LIKE '___CSTIR'  OR u.institution LIKE '___CEZMM'  OR u.institution LIKE '___CECEG' 
	OR u.institution LIKE '___CJSLI'  OR u.institution LIKE '___CETPQ'  
	OR u.institution LIKE '__CETEP'   OR u.institution LIKE '__CSQRO'   OR u.institution LIKE '__CETGZ'   OR u.institution LIKE '__CECUU'   OR u.institution LIKE '__CEMZT'  
	OR u.institution LIKE '__CEMLM'   OR u.institution LIKE '__CETIR'   OR u.institution LIKE '__CJCUU'   OR u.institution LIKE '__CETUL'   OR u.institution LIKE '__CETRC'
	OR u.institution LIKE '__CEBNV'   OR u.institution LIKE '__CEZLO'   OR u.institution LIKE '__CSSLP'   OR u.institution LIKE '__CEJAL'
	OR u.institution LIKE '__CEOAX'   OR u.institution LIKE '__CESCX'   OR u.institution LIKE '__CJCMI'   OR u.institution LIKE '__CETCN'
	OR u.institution LIKE '__CEMTN'   OR u.institution LIKE '__CETXA'   OR u.institution LIKE '__CECVM'   OR u.institution LIKE '__CESTL'   OR u.institution LIKE '__CETXP'
  	OR u.institution LIKE '___CEMTL' OR u.institution LIKE '___CEGDA' OR u.institution LIKE '___CJSLP'  OR u.institution LIKE '___CEATX' 
	OR u.institution LIKE '___CJMID'  OR u.institution LIKE '___CEATX'  OR u.institution LIKE '___CPPVT' OR u.institution LIKE '___CECJT'
	OR u.institution LIKE '___CJSUL'  OR u.institution LIKE '___CEBAZ' OR u.institution LIKE '___CEDEL' OR u.institution LIKE '___CPMID'
	OR u.institution LIKE '__CECUL' OR u.institution LIKE '__CESAL' OR u.institution LIKE '__CECEN' OR u.institution LIKE '__CECJS' OR u.institution LIKE '__CEZCL'
	OR u.institution LIKE '___CPINT' OR u.institution LIKE '___CPTAM' OR u.institution LIKE '___CEESE' OR u.institution LIKE '___CPTIJ' 
	 
	OR u.institution LIKE '___CSCHC' OR u.institution LIKE '___CPCHC'
	OR u.institution LIKE '___CPESE' OR u.institution LIKE '___CEVIL'
	OR u.institution LIKE '___CPCUU'  OR u.institution LIKE '___CETLA' OR u.institution LIKE 'ucc'OR u.institution LIKE '___CETAP' 
	)
	
AND 
	(
		(
		cc.course=2 OR cc.course=3 
			OR cc.course=4 OR cc.course=5
			OR cc.course=6 OR cc.course=7 
			OR cc.course=8 OR cc.course=11 
			OR cc.course=38 OR cc.course=44
			OR cc.course=52 
			OR cc.course=55 OR cc.course=62 
			OR cc.course=65 OR cc.course=67 
			OR cc.course=71 OR cc.course=72
			OR cc.course=73 OR cc.course=75 
			OR cc.course=77 OR cc.course=93 
			OR cc.course=83 
			OR cc.course=92 OR cc.course=101 
			OR cc.course=114 OR cc.course=115 
			OR cc.course=116 OR cc.course=97 
			OR cc.course=74 OR cc.course=130
			OR cc.course=262 OR  cc.course=131
			OR cc.course=275
		) 
	)
)

OR 
(
	(
		(
		cc.course=2 OR cc.course=3 
			OR cc.course=4 OR cc.course=5
			OR cc.course=6 OR cc.course=7 
			OR cc.course=8 OR cc.course=11 
			OR cc.course=38 OR cc.course=44
			OR cc.course=52 
			OR cc.course=55 OR cc.course=62 
			OR cc.course=65 OR cc.course=67 
			OR cc.course=71 OR cc.course=72
			OR cc.course=73 OR cc.course=75 
			OR cc.course=77 OR cc.course=93 
			OR cc.course=83 OR cc.course=88 
			OR cc.course=92 OR cc.course=101 
			OR cc.course=114 OR cc.course=115 
			OR cc.course=116 OR cc.course=97 
			OR cc.course=74 OR cc.course=130
			OR cc.course=262 OR  cc.course=131
			OR cc.course=275
		)
	)  
	AND 
	(
		u.institution LIKE '___CCMEX' OR u.institution LIKE '___CCOAX' OR u.institution LIKE '__CEAGU' OR u.institution LIKE '___CEALT' OR u.institution LIKE '__CEANG' OR u.institution LIKE '__CECEA' 
		OR u.institution LIKE '__CECEL'  OR u.institution LIKE '__CECME' OR u.institution LIKE '__CECNA' OR u.institution LIKE '__CECOA' OR u.institution LIKE '__CECPE' OR u.institution LIKE '__CECSL' 
		OR u.institution LIKE '__CECTM' OR u.institution LIKE '__CECUN' OR u.institution LIKE '__CEDGO' OR u.institution LIKE '__CEEBC' OR u.institution LIKE '__CEEGD'  OR u.institution LIKE '__CEHMO' 					
		OR u.institution LIKE '__CEINS'  OR u.institution LIKE '__CEIRA' OR u.institution LIKE '__CEIRN' OR u.institution LIKE '__CELAP' OR u.institution LIKE '__CELEO' OR u.institution LIKE '___CELRZ' 
		OR u.institution LIKE '__CELZC' OR u.institution LIKE '__CENOG'	OR u.institution LIKE '__CEMAT' OR u.institution LIKE '__CEMTR' OR u.institution LIKE '__CEMTT' OR u.institution LIKE '__CEMTY' 					
		OR u.institution LIKE '__CEMXL'  OR u.institution LIKE '__CEPAN' OR u.institution LIKE '__CEPAT' OR u.institution LIKE '__CEPAU' OR u.institution LIKE '__CEPAZ' OR u.institution LIKE '__CEPDC' 
		OR u.institution LIKE '___CEPDS' OR u.institution LIKE '__CEPUE'  OR u.institution LIKE '__CEPUN' OR u.institution LIKE '__CEQRO' OR u.institution LIKE '___CEREA' OR u.institution LIKE '__CEREX' 					
		OR u.institution LIKE '___CEROS' OR u.institution LIKE '__CESIL'  OR u.institution LIKE '__CESLM' OR u.institution LIKE '__CESLP' OR u.institution LIKE '__CESLU' OR u.institution LIKE '__CESLW' 
		OR u.institution LIKE '__CETAM' OR u.institution LIKE '__CETII' OR u.institution LIKE '___CETIO' OR u.institution LIKE '__CETLC' OR u.institution LIKE '__CETPO' OR u.institution LIKE '__CEVER' 
		OR u.institution LIKE '__CEVSA'  OR u.institution LIKE '__CJCJS' OR u.institution LIKE '__CJCME' OR u.institution LIKE '__CJCUN' OR u.institution LIKE '__CJGPS' 
		OR u.institution LIKE '___CJLEO' OR u.institution LIKE '__CJMXL' OR u.institution LIKE '___CJPAN' OR u.institution LIKE '__CJPAU' OR u.institution LIKE '___CJSLP'
 		OR u.institution LIKE '__CJTGZ' OR u.institution LIKE '__CJTIO' 
		OR u.institution LIKE '__CJTLC' OR u.institution LIKE '___CJTUX' OR u.institution LIKE '__CJVER' OR u.institution LIKE '__CJVSA' OR u.institution LIKE '___CPLEO' OR u.institution LIKE '___CPMSJ' 
		OR u.institution LIKE '___CPPST' OR u.institution LIKE '___CPPVT' OR u.institution LIKE '___CPSTM' OR u.institution LIKE '__CSANZ' OR u.institution LIKE '__CSCSL' OR u.institution LIKE '___CSPDC' 
		OR u.institution LIKE '__CSSFE' OR u.institution LIKE '___CSSIL' OR u.institution LIKE '__CSTLC'  OR u.institution LIKE '__CEQRJ'  OR u.institution LIKE '__CEHMO' OR u.institution LIKE '__CEMTT' 
		OR u.institution LIKE '___CEGDP' OR u.institution LIKE '__CEGZLO'  OR u.institution LIKE '__CJCUN' OR u.institution LIKE '__CJTLC' OR u.institution LIKE '__CESLU'
		OR u.institution LIKE '__CEDGO'  OR u.institution LIKE '__CSQRO' OR u.institution LIKE '___CEALT'
		OR u.institution LIKE 'ucc' 
	)
)
OR 
(	(
		(
		   cc.course=2 OR cc.course=3  OR cc.course=4 
		   OR cc.course=5 OR cc.course=6 OR cc.course=7 
		   OR cc.course=8 OR cc.course=11 
		   OR cc.course=38 OR cc.course=44 OR cc.course=52 
		   OR cc.course=55 OR cc.course=62 OR cc.course=65 
		   OR cc.course=67 OR cc.course=71 OR cc.course=72 
		   OR cc.course=75 OR cc.course=73 OR cc.course=77 
		   OR cc.course=88 OR cc.course=89 OR cc.course=93 
		   OR cc.course=96 OR cc.course=95 OR cc.course=94 
		   OR cc.course=83 OR cc.course=92 OR cc.course=116 
		   OR cc.course=101 OR cc.course=114 OR cc.course=115
		   OR cc.course=97 OR cc.course=74 OR cc.course=130
		   OR cc.course=262 OR  cc.course=131 OR cc.course=275
		) 
	)  
	AND 
	(
		 u.institution LIKE '__CSPAU' OR  u.institution LIKE '__CESFE' 
		 OR u.institution LIKE '__CEMTA' OR u.institution LIKE '__CELMM'  
		 OR u.institution LIKE '__CEMID'  OR u.institution LIKE 'ucc'
	)
)
OR 
(	(
		(
		   cc.course=2 OR cc.course=3  OR cc.course=4 
		   OR cc.course=5 OR cc.course=6 OR cc.course=7 
		   OR cc.course=8 OR cc.course=11 OR cc.course=12 
		   OR cc.course=13 OR cc.course=18 OR cc.course=38 
		   OR cc.course=44 OR cc.course=50 OR cc.course=52 
		   OR cc.course=55 OR cc.course=57 OR cc.course=62 
		   OR cc.course=65 OR cc.course=67 OR cc.course=71 
		   OR cc.course=72 OR cc.course=75 OR cc.course=73 
		   OR cc.course=77 OR cc.course=89 OR cc.course=93
		   OR cc.course=83 OR cc.course=92 OR cc.course=113 
		   OR cc.course=116 OR cc.course=101 OR cc.course=114 
		   OR cc.course=115 OR cc.course=74 OR cc.course=130
		   OR cc.course=262 OR  cc.course=131 OR cc.course=275
		) 
		
	)  
	AND 
	(
		u.institution LIKE '___CPMED' OR  u.institution LIKE '___CJBOG' 
		OR u.institution LIKE '___CPBOG' OR u.institution LIKE '___CESCL'
		OR u.institution LIKE '__CESJO' OR u.institution LIKE '__CECLO'
		OR u.institution LIKE 'ucc'
	)
)

AND u.suspended=0) AS a ON a.usuario=mat.Usuario AND a.Curso=mat.Curso
WHERE u.institution=(SELECT m.institution FROM prefix_user m WHERE m.id=%%USERID%%) AND mat.Visible='1' AND u.deleted=0 


%%FILTER_COURSES:mat.id%%
%%FILTER_USERS:u.department%%