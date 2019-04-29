SELECT DISTINCT
    m.UUID,m.login_id AS studentid,m.password AS studentpass,
    TRIM(CONCAT_WS(' ',
                m.first_name,
                m.middle_name,
                m.last_name)) AS stu_name,m.ums_id as newid,
    up.mobile_number AS stu_mobile,
    up.admission_number,
    up.roll_no,
    up.email_id AS stu_email,
    m.school_id,
    class_name,
    scs.section_name,
    sc.level_id,
    'student' AS student_role,
    um.UUID AS pid,um.login_id AS parentid,um.password AS parentpass,um.ums_id as new_id,
    TRIM(CONCAT_WS(' ',
                um.first_name,
                um.middle_name,
                um.last_name)) AS pname,
    'parent' AS parent_role,
    up_p.mobile_number,um.migration_login_id,um.migration_user_name,
    up_p.email_id
FROM
    eol_prod.user_master m
        JOIN
    eol_prod.user_profile up ON m.UUID = up.UUID AND m.role_id = 2 and m.active=1 and up.active=1
        JOIN
    eol_prod.user_group_details ugd ON m.UUID = ugd.UUID and ugd.AYID=4
        JOIN
    eol_prod.user_group_master ugm ON ugm.group_id = ugd.group_id
        JOIN
    eol_prod.school_class_section AS scs ON scs.group_id = ugd.group_id
        JOIN
    eol_prod.school_class sc ON sc.school_class_id = scs.class_id
        /*AND scs.AYID IN (4 SELECT 
            AYID
        FROM
            eol_prod.school_academic_session AS sas
        WHERE
            sas.school_id = sc.school_id and sas.active=1)*/
        JOIN
    eol_prod.user_contacts_map ucm ON m.UUID = ucm.UUID
        JOIN
    eol_prod.user_contacts uc ON ucm.contact_id = uc.contact_id
        JOIN
    eol_prod.user_master um ON uc.UUID = um.UUID AND um.role_id = 5 and um.active=1 
        JOIN
    eol_prod.user_profile up_p ON um.UUID = up_p.UUID and up_p.active=1
	
	
	
	
	
	
	