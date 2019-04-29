SELECT
    m.UUID
FROM
    eol_prod.user_master m
	JOIN
        eol_prod.school_master sm on sm.school_id=m.school_id

    and m.role_id = 3 and m.active = 1 and sm.active=1 and m.school_id
	
	
	
	