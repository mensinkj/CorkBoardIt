<?php

/**
* Loads request params
* @param string $name This is the GET variable you want to load
* @param string $default The get variabe is not set, so load this instead
* @return string
*/
function loadVariable($name, $default=false)
{
    if (isset($_REQUEST[$name])) {
        return $_REQUEST[$name];
    } else {
        return $default; 
    } 
}
/**
 * Loads the message banner to be displayed
 * @param string $s1 String to prepend to message
 * @param string $s2 String to append to message
 * @return boolean
 */
function showMessage($s1 = "", $e1 = "")
{
    if ($_SESSION[SUCCESS_MSG]) {
            $s = "<div class='alert alert-success' id='Banner' style='margin-bottom:-50px' role='alert'>";
            $e = "</div><script>setTimeout(function(){ $('#Banner').remove() }, 2000);</script>";
            if ($s1 != "" & $e1 != "") {
                $s = $s1;
                $e = $e1;
            }
            echo $s . $_SESSION[SUCCESS_MSG] . $e;
            unset($_SESSION[SUCCESS_MSG]);
    }
    if ($_SESSION[ERROR_MSG]) {
            $s = "<div class='alert alert-danger' id='Banner' style='margin-bottom:-50px' role='alert'>";
            $e = "</div><script>setTimeout(function(){ $('#Banner').remove() }, 2000);</script>";
            if ($s1 != "" & $e1 != "") {
                $s = $s1;
                $e = $e1;
            }
            echo $s . $_SESSION[ERROR_MSG] . $e;
            unset($_SESSION[ERROR_MSG]);
    }
    return true;
}

?>