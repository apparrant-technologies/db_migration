SELECT 
    distinct m.UUID,
    TRIM(CONCAT_WS(' ',
                m.first_name,
                m.middle_name,
                m.last_name)) AS tea_name,m.password,ums_id,
    up.mobile_number,
    up.email_id,m.login_id,m.migration_login_id,m.migration_user_name,
    school_id
FROM
    eol_prod.user_master m
        JOIN
    eol_prod.user_profile up ON up.UUID = m.UUID AND (m.role_id = 1 OR m.role_id=10) and m.active=1 and up.active=1
	
	
	
	

