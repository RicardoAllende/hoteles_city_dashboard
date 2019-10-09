SELECT u.id, u.institution AS 'Propiedad', u.department AS 'Puesto', CONCAT(u.firstname , ' ' , u.lastname) AS 'Nombre Completo', 
c.fullname AS 'Curso', 
ROUND(gg.finalgrade,2) AS 'Puntaje',
FROM_UNIXTIME(gg.timecreated) AS 'Fecha inicio',
FROM_UNIXTIME(gg.timemodified) AS 'Fecha fin'
 
FROM prefix_grade_grades AS gg
JOIN prefix_user AS u ON gg.userid = u.id
JOIN prefix_grade_items AS gi ON gg.itemid = gi.id
JOIN prefix_course AS c ON gi.courseid = c.id

WHERE gi.itemtype = 'course' AND u.deleted =0

%%FILTER_USERS:u.institution%%
%%FILTER_USERS:u.department%%
%%FILTER_COURSES:c.id%%

ORDER BY institution

