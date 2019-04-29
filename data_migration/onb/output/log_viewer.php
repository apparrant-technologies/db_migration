<?php

function follow($file)
{
    $size = 0;
    while (true) {
        clearstatcache();
        $currentSize = filesize($file);
        if ($size == $currentSize) {
            usleep(100);
            continue;
        }

        $fh = fopen($file, "r");
        fseek($fh, $size);

        while ($d = fgets($fh)) {
            echo $d;
        }

        fclose($fh);
        $size = $currentSize;
    }
}
//$file=__DIR__.'/tmp/masterlog-'.date('ymdH') .'.txt';
$file=__DIR__.'/tmp/masterlog-17012214.txt';
//echo $file;
follow($file);


?>