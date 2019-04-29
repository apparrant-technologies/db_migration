SELECT DISTINCT
    subject_name,
    ugm.school_id,
    class_name,
    scs.section_name,
    sc.level_id
FROM
    eol_prod.school_class_section AS scs
        LEFT JOIN
    eol_prod.school_class sc ON sc.school_class_id = scs.class_id
        LEFT JOIN
    eol_prod.user_group_master ugm ON ugm.group_id = scs.group_id
        LEFT JOIN
    eol_prod.user_group_subject ugs ON ugs.group_id = ugm.group_id
        LEFT JOIN
    eol_prod.subject_master subjm ON subjm.subject_id = ugs.subject_id
	
	
		
