<?php





require_once dirname(__FILE__) . '/../Classes/assets/asset.php';
require_once dirname(__FILE__) . '/../Classes/onbMetrics.php';
require_once dirname(__FILE__) . '/../Classes/toUTF.php';
//require_once dirname(__FILE__) . '/../Classes/PerformanceMetrics.php';
require_once dirname(__FILE__) . '/../Classes/assets/createUser.php';
require_once dirname(__FILE__) . '/../mail/mail.php';

require_once dirname(__FILE__) .'/../encryption/auth.php';

require_once dirname(__FILE__) . '/../Classes/SONBMongoConnectionClass.php';
require_once dirname(__FILE__) . '/../Classes/DataMigrationMongoConnectionClass.php';


require_once dirname(__FILE__) . '/../encryption/DecryptionClass.php';


require_once dirname(__FILE__) . '/../Classes/migrationRules.php';


/** Include PHPExcel */
require_once dirname(__FILE__) . '/lib.php';
require_once dirname(__FILE__) . '/graphics.php';
/** include DB Master <-> Slave */
require_once dirname(__FILE__) . '/../conf/db_conf.php';

require_once dirname(__FILE__) . '/../conf/dbmongo.php';
/* Include Log File **/
require_once dirname(__FILE__) . '/../Classes/log/Logging.php';
// Sheet 1 Called
require_once dirname(__FILE__) . '/sonb/school_details.php';
// Sheet 2 Called
require_once dirname(__FILE__) . '/sonb/class_section_details.php';
// Sheet 3 Called
require_once dirname(__FILE__) . '/sonb/class_subjects_details.php';




// Sheet 1 Called
require_once dirname(__FILE__) . '/uonb/user_details.php';
// Sheet 2 Called
require_once dirname(__FILE__) . '/uonb/teacher_details.php';
// Sheet 3 Called
require_once dirname(__FILE__) . '/uonb/class_teachers.php';
// Sheet 4 Called
require_once dirname(__FILE__) . '/uonb/subject_teachers.php';
// Sheet 5 Called
require_once dirname(__FILE__) . '/uonb/section_details.php';
require_once dirname(__FILE__) . '/uonb/subject_details.php';

require_once dirname(__FILE__) . '/uonb/getCodes.php';








?>