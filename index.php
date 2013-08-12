<?php

/**
 *  Test Tasks for PHP Interviews that developers will enjoy solving.
 *  Task 1: Print an associative array as an ASCII table.
 *  Task url: http://phpixie.com/blog/test-tasks-for-php-interviews-that-developers-will-enjoy-solving/
 *
 *  Author: Vitaliy S. Orlov - mailto:orlov0562@gmail.com
 *  Date: 2013-08-12
 */

$data = array(
    array(
        'Name' => 'Trixie',
        'Color' => 'Green',
        'Element' => 'Earth',
        'Likes' => 'Flowers'
        ),
    array(
        'Name' => 'Tinkerbell',
        'Element' => 'Air',
        'Likes' => 'Singning',
        'Color' => 'Blue'
        ),
    array(
        'Element' => 'Water',
        'Likes' => 'Dancing',
        'Name' => 'Blum',
        'Color' => 'Pink'
        ),
);

// -----------------------------------------------------

function prepare_data(array $in_data)
{
    $flip_data = array();
    foreach ($in_data as $arr) foreach ($arr as $key=>$val) $flip_data[$key][] = $val;

    $ret = array();
    foreach ($flip_data as $key=>$arr)
    {
        $max_width = strlen($key);
        foreach ($arr as $val) $max_width = max(strlen($val), $max_width);

        array_walk($arr, function(&$val) use ($max_width) {
            $val = str_pad(' '.$val, $max_width + 2, ' ', STR_PAD_RIGHT);
        });

        $ret[str_pad($key, $max_width + 2, ' ', STR_PAD_BOTH)] = $arr;
    }
    return $ret;
}

function create_table(array $in_data)
{
    $line = '+'.preg_replace( '~[^+]~','-',implode('+', array_keys($in_data))).'+'.PHP_EOL;

    $ret = $line.'|'.implode('|', array_keys($in_data)).'|'.PHP_EOL.$line;

    $data_lines = count($in_data[key($in_data)]);
    for ($i=0; $i<$data_lines; $i++)
    {
        $ret .= '|';
        foreach ($in_data as $arr) $ret .= $arr[$i].'|';
        $ret .= PHP_EOL.$line;
    }

    return $ret;
}

function print_table($output) {
    echo (php_sapi_name()!='cli') ? '<pre>'.$output.'</pre>' : $output;
}

// -----------------------------------------------------

print_table(
    create_table(
        prepare_data($data)
    )
);


/* -----------------------------------------------------

    OUTPUT:

    +------------+-------+---------+----------+
    |    Name    | Color | Element |  Likes   |
    +------------+-------+---------+----------+
    | Trixie     | Green | Earth   | Flowers  |
    +------------+-------+---------+----------+
    | Tinkerbell | Blue  | Air     | Singning |
    +------------+-------+---------+----------+
    | Blum       | Pink  | Water   | Dancing  |
    +------------+-------+---------+----------+

*/