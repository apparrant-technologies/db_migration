SELECT 
    sc.level_id,sm.school_id,sc.class_name ,section_name,level_id
  
FROM
    eol_prod.school_class_section AS scs
        JOIN
    eol_prod.school_class sc ON sc.school_class_id = scs.class_id 
       JOIN
    eol_prod.school_master sm ON sm.school_id = scs.school_id
	
	
	
	
	
	