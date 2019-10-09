
SELECT u.firstname, u.lastname, u.username, u.email, u.institution

FROM prefix_user AS u

WHERE u.department='Gerente General' AND u.deleted = '0'

ORDER BY u.institution