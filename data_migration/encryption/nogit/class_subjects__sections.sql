-- Class Subjects
SELECT DISTINCT
    subject_name,
    ugm.school_id,
    class_name,
    scs.section_name,
    sc.level_id
FROM
    eol_prod.school_class_section AS scs
        JOIN
    eol_prod.school_class sc ON sc.school_class_id = scs.class_id
        JOIN
    eol_prod.user_group_master ugm ON ugm.group_id = scs.group_id
        JOIN
    eol_prod.user_group_subject ugs ON ugs.group_id = ugm.group_id
        JOIN
    eol_prod.subject_master subjm ON subjm.subject_id = ugs.subject_id
WHERE
    ugm.school_id = 14;
 
-- Class Sections
SELECT 
    sm.school_id, class_name, scs.section_name, sc.level_id
FROM
    eol_prod.school_class_section AS scs
        JOIN
    eol_prod.school_class sc ON sc.school_class_id = scs.class_id
        JOIN
    eol_prod.school_master sm ON sm.school_id = scs.school_id
WHERE
    sm.school_id = 14;

SELECT 
    AYID
FROM
    eol_prod.school_academic_session AS sas
WHERE
    sas.school_id = 9
ORDER BY 1 DESC;