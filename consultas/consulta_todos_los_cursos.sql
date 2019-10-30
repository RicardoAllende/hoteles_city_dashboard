SELECT u.institution AS 'Unidad operativa', u.department  AS 'Puesto', mat.usuario   AS 'usuario', 
       a.nombre AS 'nombre', mat.curso AS 'curso', a.estatus AS 'estatus' 
FROM   (SELECT DISTINCT u.username AS Usuario, 
                        c.fullname AS Curso, 
                        c.id, 
                        c.visible  AS Visible 
        FROM   mdl_user u 
               JOIN mdl_user_enrolments ue 
                 ON ue.userid = u.id 
               JOIN mdl_enrol e 
                 ON e.id = ue.enrolid 
               JOIN mdl_role_assignments ra 
                 ON ra.userid = u.id 
               JOIN mdl_context ct 
                 ON ct.id = ra.contextid 
                    AND ct.contextlevel = 50 
               JOIN mdl_course c 
                 ON c.id = ct.instanceid 
                    AND e.courseid = c.id 
        WHERE  e.status = 0 
                AND c.id = 
               AND u.suspended = 0 
               AND u.deleted = 0 
               AND ( ue.timeend = 0 
                      OR Dateadd(ss, ue.timeend, '1970-01-01 00:00:00') > 
                         Getdate() ) 
               AND ue.status = 0) AS mat 
       JOIN mdl_user AS u 
         ON u.username = mat.usuario 
       JOIN (SELECT u.institution                  AS institution, 
                    u.department                   AS department, 
                    u.username                     AS usuario, 
                    u.firstname + ' ' + u.lastname AS Nombre, 
                    c.fullname                     AS Curso, 
                    CASE 
                      WHEN cc.timecompleted IS NULL THEN 'No completado'
                      WHEN cc.timecompleted = 0 THEN 'No Completado'
                      ELSE 'Completado' 
                    END                            AS Estatus 
             FROM   mdl_course_completions AS cc 
                    JOIN mdl_course AS c 
                      ON c.id = cc.course 
                    JOIN mdl_user AS u 
                      ON cc.userid = u.id 
             WHERE  u.deleted = 0 
                    AND u.suspended = 0) AS a 
         ON a.usuario = mat.usuario 
            AND a.curso = mat.curso 
ORDER BY u.institution 