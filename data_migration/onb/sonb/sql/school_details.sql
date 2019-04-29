SELECT 
    sm.school_id,
    sm.school_name,
    sm.short_name,
    sm.email,
    sm.phone_number,
    sm.web_url,
	TRIM(CONCAT_WS(' ',
                am.address_line_1,
                am.address_line_2)) AS address_line,
    stm.state_name,
    cm.city_name,am.city_id,am.state_id,
    bm.display_name
FROM
    eol_prod.school_master AS sm
        JOIN
    eol_prod.address_master AS am ON am.address_id = sm.address_id
        AND sm.active = 1
        LEFT JOIN
    eol_prod.city_master AS cm ON cm.city_id = am.city_id
        LEFT JOIN
    eol_prod.state_master AS stm ON stm.state_id = am.state_id
        LEFT JOIN
    eol_prod.school_boards sb ON sm.school_id = sb.school_id
        LEFT JOIN
    eol_prod.board_master bm ON sb.board_id = bm.board_id

