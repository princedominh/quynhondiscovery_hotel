<?php


/**
 * Description of Common
 *
 * @author Do Minh Duc
 */
class Common {
    public function preName($data = array()) {
        $str = "";
        if(array_key_exists('level', $data)) {
            for($i=0; $i<$data['level']; $i++) {
                $str .= "--";
            }
        }
        return $str;
    }
}
