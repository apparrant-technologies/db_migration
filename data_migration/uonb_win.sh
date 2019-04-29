#/usr/bin/bash

echo "Please enter (Old Infra) School ID: "
read input_variable
php onb/uonb/user_structure.php db=migration school_id=$input_variable type=demo mongo=n debug=1 mail=sonia.gandhi@fliplearn.com