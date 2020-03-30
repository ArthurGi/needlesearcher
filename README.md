# needlesearcher
needlesearcher

INSTALLATION
------------

### Install via Composer
~~~
composer require arturg/needlefinder
~~~

USAGE
------------
~~~
use src\NeedleFinder;

$filepath   = "https://raw.githubusercontent.com/ArthurGi/hooli/master/files/news.txt";
//третьим параметров в NeedleFinder можно прокинуть сво класс поиска,
//главное чтобы он имплементил SearchInterface
$ns = new NeedleFinder($filepath, true);
$str = 'on';
$text_coords = $ns->search($str);

echo "строка <b>$str</b> найдена в: <br>";
foreach ($text_coords as $key => $line) {
    foreach ($line as $coords) {
        echo "строка $key: с {$coords['start']} по {$coords['end']} символ <br>";
    }
}
~~~
