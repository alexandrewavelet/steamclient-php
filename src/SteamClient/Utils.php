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
    public static function recursiveDump(array $var, $depth = 0, $indentation = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
    {
        foreach ($var as $key => $value) {
            for($i = 0; $i < $depth; $i++) {
                echo $indentation;
            }
            echo '<strong>'.$key.'</strong>';
            if (is_array($value)) {
                echo '<br>';
                self::recursiveDump($value, $depth + 1);
            } else {
                echo ' : '.$value;
                echo '<br>';
            }
        }
    }

    /**
     * Dump a multi-level array with JS - Ugly (for now)
     * @param  array    $var            Array to dump
     * @param  integer  $depth          Depth of the current level
     * @param  string   $indentation    Indentation width
     */
    public static function recursiveDumpJS(array $var, $depth = 0, $indentation = '20')
    {
        if (is_array($var)) {
            foreach ($var as $key => $value) {
                echo '<div style="margin-left:'.$indentation * $depth.'px;">';
                if (is_array($value)) {
                    $random = rand();
                    echo '<div onclick="togglePane('.$random.')" style="height:30px;width:100%;background-color:#D2D2D2">';
                    echo '<strong>'.$key.'</strong>';
                    echo '</div>';
                    echo '<div id="'.$random.'" style="display:none">';
                    self::recursiveDumpJS($value, $depth + 1);
                    echo '</div>';
                } else {
                    echo '<div>';
                    echo '<strong>'.$key.'</strong> : '.$value;
                    echo '</div>';
                }
                echo '</div>';
            }
        } else {
            echo $var.'<br>';
        }

        $js = <<<HTML
<script>
function togglePane(id) {
    var element = document.getElementById(id);
    element.style.display = (element.style.display == "block") ? "none" : "block";
}
</script>
HTML;
        echo $js;
    }

}
