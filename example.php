<?php
/**
 *    $convertedText = mb_convert_encoding($text, 'utf-8', mb_detect_encoding($text));
 *
 *    выкидывть экзпшны ??
 *    прокинуть кодировку после определения ??
 *    учесть случаи с регистром и без ??
 */
require_once("src/ns_load.php");
use src\NeedleFinder;

$filepath   = "https://raw.githubusercontent.com/ArthurGi/hooli/master/files/news.txt";
$ns = new NeedleFinder($filepath, true);
$str = 'on';
$text_coords = $ns->search($str);

echo "строка <b>$str</b> найдена в: <br>";
foreach ($text_coords as $key => $line) {
    foreach ($line as $coords) {
        echo "строка $key: с {$coords['start']} по {$coords['end']} символ <br>";
    }
}
