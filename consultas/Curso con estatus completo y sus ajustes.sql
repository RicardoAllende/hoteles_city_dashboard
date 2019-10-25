SELECT c.shortname AS Course, 
CASE
WHEN (SELECT a.method FROM prefix_course_completion_aggr_methd AS a  WHERE (a.course = t.course AND a.criteriatype IS NULL)) = 2 THEN "All"
ELSE "Any"
END AS Course_Aggregation,
CASE
WHEN t.criteriatype = 1 THEN "Self completion"
WHEN t.criteriatype = 2 THEN "Date done by" 
WHEN t.criteriatype = 3 THEN "Unenrolement" 
WHEN t.criteriatype = 4 THEN "Activity completion"   
WHEN t.criteriatype = 5 THEN "Duration in days" 
WHEN t.criteriatype = 6 THEN "Final grade"     
WHEN t.criteriatype = 7 THEN "Approve by role" 
WHEN t.criteriatype = 8 THEN "Previous course"
END AS Criteria_type,
CASE
WHEN t.criteriatype = 1 THEN "On"
WHEN t.criteriatype = 2 THEN DATE_FORMAT(FROM_UNIXTIME(t.timeend),'%Y-%m-%d')
WHEN t.criteriatype = 3 THEN "On"
WHEN t.criteriatype = 4 THEN
CONCAT('<a target="_new" href="%%WWWROOT%%/mod/',t.module,'/view.php?id=',t.moduleinstance,'">',t.module,'</a>')
WHEN t.criteriatype = 5 THEN ROUND(t.enrolperiod/86400)
WHEN t.criteriatype = 6 THEN ROUND(t.gradepass,2)
WHEN t.criteriatype = 7 THEN (SELECT r.shortname FROM prefix_role AS r WHERE r.id = t.ROLE)
WHEN t.criteriatype = 8 THEN (SELECT pc.shortname FROM prefix_course AS pc WHERE pc.id = t.courseinstance)
END AS Criteria_detail
FROM prefix_course_completion_criteria AS t
JOIN prefix_course AS c ON t.course = c.id
WHERE c.enablecompletion = 1
ORDER BY course