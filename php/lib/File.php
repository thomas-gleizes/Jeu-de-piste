<?php
/**
 * Created by IntelliJ IDEA.
 * User: james
 * Date: 12/11/2019
 * Time: 14:39
 */

class File{
    public static function build_path($path_array){
        $DS = DIRECTORY_SEPARATOR;
        $ROOT_FOLDER = __DIR__.$DS.'..';
        $r = implode("/",$path_array);
        return $ROOT_FOLDER . "/" .$r."";
    }
}

