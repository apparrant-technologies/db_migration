CREATE VIEW  migration_duplicate_mobile_vw AS

SELECT 
    sm.school_name,m.UUID,rm.role_name,
    TRIM(CONCAT_WS(' ',
                m.first_name,
                m.middle_name,
                m.last_name)) AS tea_name,
    m.role_id,
    up.mobile_number,
    up.email_id,
    m.login_id
FROM
    eol_prod.user_master m
        LEFT JOIN
    eol_prod.user_profile up ON up.UUID = m.UUID and m.active=1
        AND m.role_id <> 2
        JOIN
    eol_prod.role_master rm ON rm.role_id = m.role_id
        JOIN
    eol_prod.school_master sm ON sm.school_id = m.school_id and sm.active=1
WHERE
    m.school_id NOT IN (1 , 2,
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
        AND (up.mobile_number != ''
        AND up.mobile_number REGEXP '^(9|8|7)'
        AND up.mobile_number REGEXP '[0-9]{10}'
        AND up.mobile_number != '9999999999'
        AND up.mobile_number != '8888888888'
        AND up.mobile_number != '7777777777')
GROUP BY up.mobile_number
HAVING COUNT(up.mobile_number) > 1;
            
            