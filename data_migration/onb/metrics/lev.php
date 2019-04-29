<?php



$a=str_replace(".","","D.C.Balakrishna");
$a=str_replace(" ","","D C Balakrishna");

	$input = 'D.C.Balakrishna';

		// array of words to check against
		$words  = 'D C Balakrishna';


similar_text($words, $input, $percent);

echo $percent;


exit;




// input misspelled word
		$input = 'D.C.Balakrishna';

		// array of words to check against
		$words  = array('apple','pineapple','banana','orange',
						'radish','carrot','D C Balakrishna','bean','potato');

		// no shortest distance found, yet
		$shortest = -1;

		// loop through words to find the closest
		foreach ($words as $word) {

			// calculate the distance between the input word,
			// and the current word
			$lev = levenshtein($input, $word);

			// check for an exact match
			if ($lev == 0) {

				// closest word is this one (exact match)
				$closest = $word;
				$shortest = 0;

				// break out of the loop; we've found an exact match
				break;
			}

			// if this distance is less than the next found shortest
			// distance, OR if a next shortest word has not yet been found
			if ($lev <= $shortest || $shortest < 0) {
				// set the closest match, and shortest distance
				$closest  = $word;
				$shortest = $lev;
			}
		}

		echo "Input word: $input\n";
		if ($shortest == 0) {
			echo "Exact match found: $closest\n";
		} else {
			echo "Did you mean: $closest?\n";
		}
	
	
	