-- Subject Teachers
SELECT 
    m.UUID,
    TRIM(CONCAT_WS(' ',
                m.first_name,
                m.middle_name,
                m.last_name)) AS tea_name,
    m.UUID,
    up.mobile_number,
    up.email_id,
    m.school_id,
    class_name,
    scs.AYID,
    sc.level_id,
    scs.section_name,
	sm.subject_name
FROM
    eol_prod.user_master m
        JOIN
    eol_prod.user_profile up ON up.UUID = m.UUID
        JOIN
    eol_prod.user_group_details ugd ON ugd.UUID = m.UUID AND ugd.role_id = 10
        JOIN
    eol_prod.school_class_section AS scs ON scs.group_id = ugd.group_id
        JOIN
    eol_prod.school_class sc ON sc.school_class_id = scs.class_id
        JOIN
    eol_prod.user_group_master ugm ON ugm.group_id = scs.group_id
        JOIN
    eol_prod.user_group_subject ugs ON ugs.group_id = ugm.group_id
		JOIN 
	 eol_prod.subject_master sm ON sm.subject_id = ugs.subject_id
        AND sc.level_id = sc.level_id
WHERE
    m.school_id = 1270;
        
   select * from user_group_subject limit 1;     
   select * from subject_master limit 1;     