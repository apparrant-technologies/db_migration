-- Student Details

SELECT 
	distinct m.UUID,    
    TRIM(CONCAT_WS(' ',
                m.first_name,
                m.middle_name,
                m.last_name)) AS stu_name,
	up.mobile_number as stu_mobile,
	up.admission_number,
	up.roll_no,
    up.email_id as stu_email,
    m.school_id,
    class_name,
    scs.section_name,
    sc.level_id,
    'student' as student_role,
    um.UUID AS pid,
    TRIM(CONCAT_WS(' ',
                um.first_name,
                um.middle_name,
                um.last_name)) AS pname,
    'parent' AS parent_role,
    up_p.mobile_number,
    up_p.email_id
    
FROM
    eol_prod.user_master m
        JOIN
    eol_prod.user_profile up ON m.UUID = up.UUID and m.role_id=2
        JOIN
	eol_prod.user_group_details ugd On m.UUID=ugd.UUID
		JOIN
	eol_prod.user_group_master ugm ON ugm.group_id=ugd.group_id
		JOIN
    eol_prod.school_class_section AS scs on scs.group_id=ugd.group_id
        JOIN
    eol_prod.school_class sc ON sc.school_class_id = scs.class_id
        AND scs.AYID in (select AYID from eol_prod.school_academic_session as sas where sas.school_id=sc.school_id)
        JOIN 
    eol_prod.user_contacts_map ucm ON m.UUID = ucm.UUID
        JOIN
    eol_prod.user_contacts uc ON ucm.contact_id = uc.contact_id
        JOIN
    eol_prod.user_master um ON uc.UUID = um.UUID and um.role_id=5
        JOIN
    eol_prod.user_profile up_p ON um.UUID = up_p.UUID 
	
where m.school_id=1270;