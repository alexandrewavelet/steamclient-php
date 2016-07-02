<?php

namespace SteamClient;

final class Utils
{
    /**
     * Dump a multi-level array
     * @param  array    $var            Array to dump
     * @param  integer  $depth          Depth of the current level
     * @param  string   $indentation    Indentation character(s)
     */
    public static function recursiveDump($var, $depth = 0, $indentation = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
    {
        if (is_array($var)) {
            foreach ($var as $key => $value) {
                for($i = 0; $i < $depth; $i++) {
                    echo $indentation;
                }
                echo '<strong>'.$key.'</strong><br>';
                self::recursiveDump($value, $depth + 1);
            }
        } else {
            for($i = 0; $i < $depth; $i++) {
                echo $indentation;
            }
            echo ' '.$var.'<br>';
        }
    }
}
