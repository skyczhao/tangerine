<?php
/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 5/12/16
 * Time: 1:27 AM
 */

namespace Tangerine\Parser;

use PhpOffice\PhpWord\IOFactory;

class WordParser
{
    public static function show() {
        echo "Hello World";
    }

    public static function readDocx($path) {
        $phpWord = IOFactory::load($path);
        return $phpWord;
    }
}