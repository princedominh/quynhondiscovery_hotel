<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * This function is used to print the prefix of destination
 */
function preName($destination)
{
    $str = "";
    for($i=0; $i<$destination->level; $i++) {
        $str .= "--";
    }
    echo $str;
}

/**
 * This function is used to ...
 */
if ( ! function_exists('showfield')) {
    function showfield($object, $key, $config)
    {
        if(array_key_exists('type', $config)){
            switch ($config['type']) {
                case 'preName':
                    echo preName($object);
                    echo $object->{$key};
                    break;
                case 'qnd_type_list':
                    
                    break;
                case 'qnd_type_model':
                    $CI = get_instance();
                    $CI->load->model($config['modelname']);
                    $model = $CI->{$config['modelname']}->getById($object->{$key});
                    echo ($model)? $model->{$config['toString']} : '';
                    break;
                
                default:
                    echo $object->{$key};
                    break;
            }
        } else {
            echo $object->{$key};
        }
    }    
}

/**
 * This function is used to ...
 */
if ( ! function_exists('createfield')) {
    function createfield($config)
    {
        $CI = &get_instance();
        switch ($config['type']) {
            case 'qnd_type_model':
                $CI->load->model($config['data']['modelname']);
                $config['data']['list'] = $CI->{$config['data']['modelname']}->getAll($config['data']['sql_option']);
                $CI->load->view('CRUD/qnd_type_model',$config['data']);
                break;
            case 'select':
                $CI->load->view('CRUD/select',$config['data']);
                break;
            case 'textarea':
                $CI->load->view('CRUD/textarea',$config['data']);
                break;
            default:
                $CI->load->view('CRUD/textbox',$config['data']);
                break;
        }
    }    
}



?>