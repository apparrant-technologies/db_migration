

#/usr/bin/bash

echo "Please enter (Old Infra) School ID: "
read input_variable
php onb/sonb/school_structure.php db=migration school_id=$input_variable type=demo mongo=y debug=1 mail=saurabh.chhabra@fliplearn.com




