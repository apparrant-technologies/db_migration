SELECT DISTINCT scs.section_name,
    m.UUID,
    TRIM(CONCAT_WS(' ',
                m.first_name,
                m.middle_name,
                m.last_name)) AS tea_name,m.migration_login_id,m.migration_user_name,ums_id,
    m.UUID,m.login_id,
    up.mobile_number,
    up.email_id,
    m.school_id,
    class_name,
    scs.AYID,
    sc.level_id
FROM
    eol_prod.user_master m
        JOIN
    eol_prod.user_profile up ON up.UUID = m.UUID and m.active=1 and up.active=1
        JOIN
    eol_prod.user_group_details ugd ON ugd.UUID = m.UUID AND ugd.role_id = 1 and ugd.active=1
        JOIN
    eol_prod.school_class_section AS scs ON scs.group_id = ugd.group_id and ugd.AYID=4 and scs.active=1
        JOIN
    eol_prod.school_class sc ON sc.school_class_id = scs.class_id and sc.active=1

    AND sc.level_id = sc.level_id
	
	



