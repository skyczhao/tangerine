<?php
/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 5/15/16
 * Time: 9:59 PM
 */

namespace Tangerine\Parser;

use Analog\Analog;
use Tangerine\Conf\Settings;
use Tangerine\Exception\Exception;

class PdfParser
{
    public static function getInfo($path) {
        // 使用XPDF读取信息
        $pdfInfoCmd = Settings::getPdfInfoCmd();
        if (is_null($pdfInfoCmd)) {
            throw new Exception("pdfinfo not found");
        }

        // build command
        $cmd = "{$pdfInfoCmd} '{$path}' | grep -aE 'Pages|Encrypted'";
        // execute the command
        exec($cmd, $result, $status);

        // handle the result
        if ($status == 0) {
            // information array
            $pages_array     = preg_split('/\s+/', $result[0]);
            $encrypted_array = preg_split('/\s+/', $result[1]);

            // get pages message
            $pages = (int) $pages_array[1];
            $print = true;
            // check encryption
            if ($encrypted_array[1] == "yes") {
                // check print available
                $print_array = explode(":", $encrypted_array[2]);
                if ($print_array[1] == "no") {
                    $print = false;
                }
            }

            // return result
            return array($pages, $print);
        } else {
            Analog::error("`{$cmd}` run error");
            // return default failure result
            return 1;
        }
    }
}