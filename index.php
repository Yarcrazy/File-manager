<style>
    a {
        display: block;
    }
    a, div {
        margin: 5px 0;
    }
</style>
<?php

const DEFAULT_PATH = '.';

function makeUrl($prefix, $postfix) {
    return $prefix . '/' . $postfix;
}

function renderItem($item, $path, $oldPath = DEFAULT_PATH) {
    $result = '';
    if ($item === '.' && $path !== DEFAULT_PATH) {
        $result .= "<a href=/?path=$oldPath>back</a>";
    }
    if ($item === '..' && $path !== DEFAULT_PATH) {
        $result .= "<a href=/>home</a>";
    }
    if (is_dir(makeUrl($path, $item)) && $item !== '.' && $item !== '..') {
        $result .= "<a href=/?oldPath=$path&path=" . makeUrl($path, $item) . ">$item</a>";
    }
    if (preg_match('/\.(jpg|png)$/', $item)) {
        $result .= '<div>' . $item . '</div>';
    }
    return $result;
}

$path = $_GET['path'] ?? DEFAULT_PATH;
$path = preg_match('/^\.\/public_html/', $path) ? $path : DEFAULT_PATH;
$oldPath = $_GET['oldPath'] ?? DEFAULT_PATH;
$dir = scandir($path, SORT_REGULAR);
foreach ($dir as $item) {
    echo renderItem($item, $path, $oldPath);
}
