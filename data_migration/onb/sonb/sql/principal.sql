SELECT 
    distinct m.UUID,
                m.first_name,
                m.middle_name,
                m.last_name,
    up.mobile_number,up.email_id,
    up.email_id,m.login_id,
    m.school_id,sm.school_name,m.role_id, m.last_login,up.date_of_birth,case when up.gender='m' then 'male' else 'female' end as gender
FROM
    eol_prod.user_master m
        JOIN
    eol_prod.user_profile up ON up.UUID = m.UUID AND (m.role_id = 9 )
		JOIN
	eol_prod.school_master sm on sm.school_id=m.school_id
    
    and m.role_id = 3 and m.active = 1 and sm.active=1 and m.school_id NOT IN (1 , 2,
        12,
        39,
        44,
        51,
        59,
        60,
        61,
        66,
        70,
        71,
        171,
        268,
        287,
        754,
        1116,
        1269,
        1441)
    
      and up.mobile_number <> 0
	  
	  

	  