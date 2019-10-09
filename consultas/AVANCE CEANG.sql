

SELECT u.institution AS 'Unidad operativa', u.department AS 'Puesto', mat.Usuario, a.Nombre, mat.Curso, a.Estatus

FROM (SELECT DISTINCT u.username AS Usuario, c.fullname AS Curso, c.id, c.visible AS Visible
FROM prefix_user u
JOIN prefix_user_enrolments AS ue ON ue.userid = u.id
JOIN prefix_enrol AS e ON e.id = ue.enrolid
JOIN prefix_role_assignments AS ra ON ra.userid = u.id
JOIN prefix_context AS ct ON ct.id = ra.contextid AND ct.contextlevel = 50
JOIN prefix_course AS c ON c.id = ct.instanceid AND e.courseid = c.id 

WHERE e.status = 0 AND u.suspended = 0 AND u.deleted = 0
  AND (ue.timeend = 0 OR dateadd(ss,ue.timeend, '1970-01-01 00:00:00') > getdate()) AND ue.status = 0) AS mat
JOIN prefix_user AS u ON u.username=mat.Usuario
JOIN (SELECT u.institution AS institution, u.department AS department, u.username AS usuario,
u.firstname + ' ' + u.lastname AS Nombre,
c.fullname AS Curso, 
CASE
 WHEN  dateadd(ss,cc.timecompleted, '1970-01-01 00:00:00')>0
  THEN 'Completado ' + CONVERT(VARCHAR, dateadd(ss, cc.timecompleted, '1970-01-01 00:00:00'), 120)
 ELSE 'No Completado'
END AS Estatus

FROM prefix_course_completions AS cc
JOIN prefix_course AS c ON c.id = cc.course
JOIN prefix_user AS u ON cc.userid = u.id


WHERE u.deleted=0 AND (( cc.course=5
			OR cc.course=6 OR cc.course=7 
			OR cc.course=11 
			OR cc.course = 38 OR cc.course = 44
			OR cc.course = 71 
			OR cc.course = 73 OR cc.course = 75 
			OR cc.course = 77 OR cc.course=93 
			OR cc.course=83 OR cc.course=88 
			OR cc.course=101 
			OR cc.course=114 OR cc.course=115 
			OR cc.course=116 OR cc.course=74
			OR cc.course=130 OR cc.course = 262 
			OR  cc.course=131 OR cc.course=275 
			OR cc.course=277
			
)) AND u.suspended = 0) AS a ON a.usuario=mat.Usuario AND a.Curso=mat.Curso

WHERE u.institution='29CEANG' AND mat.Visible='1' AND u.deleted=0 AND u.suspended=0

%%FILTER_COURSES:mat.id%%
%%FILTER_USERS:u.department%%


