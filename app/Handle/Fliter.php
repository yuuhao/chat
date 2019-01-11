<?php
/**
 * Created by yuuhao bigyuhao@163.com.
 * User: yuhao
 * Date: 2018/12/25
 * Time: 9:26
 */

namespace App\Handle;


class Fliter
{

    public static function filterArray($array)
    {

        if (!is_array($array))
        {
            return false;
        }

        $clean = array();
        foreach ($array as $key => $string)
        {
            if (is_array($string))
            {
                self::filterArray($string);
            }
            else
            {
                $string = self::escape($string);
                $key = self::escape($key);
            }
            $clean[$key] = $string;
        }
        return $clean;
    }

    /**
     * 使输入的代码安全
     * @param $string
     * @return string
     */
    public static function escape($string)
    {
        if (is_numeric($string))
        {
            return $string;
        }
        //HTML转义
        $string = htmlspecialchars($string, ENT_QUOTES);
        //启用了magic_quotes
        if (!get_magic_quotes_gpc())
        {
            $string = addslashes($string);
        }
        return $string;
    }
}