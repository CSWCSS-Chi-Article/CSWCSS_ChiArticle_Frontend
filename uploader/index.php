<?php

clearstatcache();

$filename = "passage.csv";

$csvData = file_get_contents($filename);
$lines = explode(PHP_EOL, $csvData);
$array = array();
foreach ($lines as $line) {
    $array[] = str_getcsv($line);
}

array_shift($array);
$filesZip = array();

foreach ($array as $row) {

    $num_p = intVal($row[4]) + 4;
    $content = array();

    for ($i = 5; $i <= $num_p; $i++) {
        $content[] = strVal($row[$i]);
    };

    $text = '{
        "title": "' . $row[1] . '",
        "author": "' . $row[2] . '",
        "year": "' . $row[3] . '",
        "content": ' . json_encode($content) . '
    }';

    $filename = $row[0] . ".json";
    echo ("Done conversion on " . $filename . "<br>");

    $filepath = "./data/json/" . $filename;
    $filesZip[] = $filepath;

    $myfile = fopen($filepath, "w");
    fwrite($myfile, $text);
    fclose($myfile);
}

$files = $filesZip;
$zipname = './data/data.zip';
$zip = new ZipArchive;

$zip->open($zipname, ZipArchive::CREATE);
foreach ($files as $file) {
    $zip->addFile($file);
}
$zip->close();

echo ("ALL CONVERSIONS COMPLETED");

header('Content-Type: application/zip');
header("Content-Transfer-Encoding: Binary");
header('Content-disposition: attachment; filename=data.zip');

$handle = fopen($zipname, "rb");
fpassthru($handle);
fclose($handle);
ob_clean();
flush();
readfile($zipname);

unlink($zipname);
foreach($filesZip as $file){
    unlink($file);
}

exit("ALL DONE! (C) 2022 ricehung29");

# id,title,author,year,num of paragraphs,content(par 1),content(par 2)......

#CHI_ARTICLE UPLOADER v1.0
