SELECT u.username AS 'User Name',
CONCAT(u.firstname , ' ' , u.lastname) AS 'Name',
c.shortname AS 'Course Name', 
DATE_FORMAT(FROM_UNIXTIME(p.timecompleted),'%W %e %M, %Y') AS 'Completed Date',
ROUND(c4.gradefinal,2) AS 'Score'
FROM prefix_course_completions AS p
JOIN prefix_course AS c ON p.course = c.id
JOIN prefix_user AS u ON p.userid = u.id
JOIN prefix_course_completion_crit_compl AS c4 ON u.id = c4.userid
WHERE c.enablecompletion = 1  AND (p.timecompleted IS NOT NULL OR p.timecompleted !='') 
AND (p.timecompleted>= :start_date AND p.timecompleted<=:end_date)
GROUP BY u.username
ORDER BY c.shortname