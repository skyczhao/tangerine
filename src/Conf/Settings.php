<?php
/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 5/15/16
 * Time: 9:50 PM
 */

namespace Tangerine\Conf;

class Settings
{
    const TIMEZONE = "PRC";

    private static $pdfInfoCmd = null;

    /**
     * @return string
     */
    public static function getPdfInfoCmd()
    {
        return self::$pdfInfoCmd;
    }

    /**
     * @param string $pdfInfoCmd
     */
    public static function setPdfInfoCmd($pdfInfoCmd)
    {
        self::$pdfInfoCmd = $pdfInfoCmd;
    }

}