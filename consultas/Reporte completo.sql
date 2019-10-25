SELECT u.institution AS 'Unidad operativa', u.department AS 'Puesto', mat.Usuario, a.Nombre, mat.Curso, a.Estatus, a.tiempo

FROM (SELECT DISTINCT u.username AS Usuario, c.fullname AS Curso, c.id AS ID
FROM prefix_user u
JOIN prefix_user_enrolments ue ON ue.userid = u.id
JOIN prefix_enrol e ON e.id = ue.enrolid
JOIN prefix_role_assignments ra ON ra.userid = u.id
JOIN prefix_context ct ON ct.id = ra.contextid AND ct.contextlevel = 50
JOIN prefix_course c ON c.id = ct.instanceid AND e.courseid = c.id

WHERE e.status = 0 AND u.suspended = 0 AND u.deleted = 0
  AND (ue.timeend = 0 OR dateadd(ss,ue.timeend, '1970-01-01 00:00:00') > getdate()) AND ue.status = 0) AS mat
JOIN prefix_user AS u ON u.username=mat.Usuario
JOIN (SELECT u.institution AS institution, u.department AS department, u.username AS usuario,
u.firstname + ' ' + u.lastname AS Nombre,
c.fullname AS Curso, 
CASE
 WHEN  dateadd(ss, cc.timecompleted, '1970-01-01 00:00:00')>0
  THEN 'Completado'
  ELSE 'No Completado'
END AS Estatus, cc.timeenrolled AS TIME, cc.timecompleted AS tiempo, cc.timestarted AS start

FROM prefix_course_completions AS cc
JOIN prefix_course AS c ON c.id = cc.course
JOIN prefix_user AS u ON cc.userid = u.id


WHERE (u.institution LIKE '__CE%' OR u.institution LIKE '__CS%' OR u.institution LIKE '__CJ%' OR u.institution LIKE '___CE%' OR u.institution LIKE '___CJ%' OR u.institution LIKE '___CS%') ) AS a ON a.usuario=mat.Usuario AND a.Curso=mat.Curso

WHERE a.TIME <=a.tiempo

%%FILTER_STARTTIME:a.tiempo:>%% %%FILTER_ENDTIME:a.tiempo:<%%



ORDER BY u.institution ASC