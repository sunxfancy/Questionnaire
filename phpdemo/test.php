<?php

$string = 'Bierglas';
$name = 'Binding-Lager';
$str = 'Das ist mein $string, voll mit $name.';
echo $str . "\n";
eval ("\$str = \"$str\";");
echo $str . "\n";
