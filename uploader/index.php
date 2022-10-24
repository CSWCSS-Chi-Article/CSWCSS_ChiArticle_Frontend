<?php


$filename = "passage.csv";

$csvData = file_get_contents($filename);
$lines = explode(PHP_EOL, $csvData);
$array = array();
foreach ($lines as $line) {
    $array[] = str_getcsv($line);
}

foreach ($array as $row) {

    $num_p = intVal($row[4])+4;
    $content = array();

    for($i = 5; $i <= $num_p; $i++){
        $content[] = strVal($row[$i]);
    };

    $text = '{
        "title": "'.$row[1].'",
        "author": "'.$row[2].'",
        "year": "'.$row[3].'",
        "content": '.json_encode($content).'
    }';

    $filename = "./data/".$row[0].".json";
    echo ("Done conversion on ".$filename."<br>") ;

    $myfile = fopen($filename, "w");
    fwrite($myfile, $text);
    fclose($myfile);

}

exit("ALL DONE! (C) 2022 ricehung29");

# id,title,author,year,num of paragraphs,content(par 1),content(par 2)......