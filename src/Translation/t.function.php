<?php
function t($key, $lang = null)
{
    if (!$lang) {
        $lang = \Translation_Manager::getInstance()->getLocale();
    }
    
    if ($key instanceof \Berthe\Translation\Translation) {
        $translation = $key->format($lang);
    } else {
        $translation = \Translation_Manager::getInstance()->translate($key, $lang);
    }

    // If more than 2 args, we
    if (func_num_args() > 2) {
        $args = array_slice(func_get_args(), 2);
        array_unshift($args, $translation);
        return call_user_func_array('sprintf', $args);
    }

    return $translation;
}
