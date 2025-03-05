select pgaudit.follow('person');
/
SELECT 	*
FROM 	pgaudit.log
WHERE	table_name = 'public.person' 
AND 	new->>'website' = 'https://www.itbests.com';