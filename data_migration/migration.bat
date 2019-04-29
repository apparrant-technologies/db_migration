@echo off
  
set /p db="Enter DB Connection Name :"

set /p school_id="Enter School Old ID :"


set /p type="Enter Data Type :" 

 
set /p mongo="Enter Mongo Insertion Y/N :"

echo %db% %school_id% %type% %mongo%


php onb\sonb\school_structure.php db=%db% school_id=%school_id% type=%type% mongo=%mongo%


php onb\uonb\user_structure.php db=%db% school_id=%school_id% type=%type% mongo=%mongo%


pause

goto :break



@echo off
:break