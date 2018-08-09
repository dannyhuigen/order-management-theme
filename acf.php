<?php


foreach( glob(dirname(__FILE__) . '/acf/*.php') as $class_path )
    require_once( $class_path );

?>