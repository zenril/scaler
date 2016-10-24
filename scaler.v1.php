<?php
/*!
scaler.v1.php v^1.0  | MIT License | https://github.com/zenril/scaler

Copyright (c) Aaron Meredith
*/

    $scaledata = array(
        'prefix' => 'scale-',
        'queries' => array( 
            array(
                'min-width' => null,
                'prefix' => 'xs-',
                'increments' => 5,
                'min' => 5,
                'max' => 200
            ),
            array(
                'min-width' => 768,
                'prefix' => 'sm-',
                'increments' => 5,
                'min' => 5,
                'max' => 200
            ),
            array(
                'min-width' => 992,
                'prefix' => 'md-',
                'increments' => 5,
                'min' => 5,
                'max' => 200
            ),
            array(
                'min-width' => 1200,
                'prefix' => 'lg-',
                'increments' => 5,
                'min' => 5,
                'max' => 200
             )
        )
    );



    $newlines = true;
    
    $endOfLine = $newlines ? PHP_EOL : " "; 

    $innerDiv = "";
    $outerDiv = "";
    $output = "";
    $fallBack = "";
    $fallBackMap = array();
    
    
    foreach ($scaledata['queries'] as $key => $data) {
        
        if($data['min-width']){
            $output .= $endOfLine."@media (min-width: ".$data['min-width']."px) {".$endOfLine;
        }
        
        for ($i=$data['min']; $i <= $data['max']; $i = $i + $data['increments']) { 
            $class = "div.".$scaledata['prefix'].$data['prefix'].$i;
            $css = "{padding-bottom:".$i."%;}";

            if(!isset($fallBackMap[$i] )) $fallBackMap[$i] = array( "classes" => array(), "css" =>  $css);

            $fallBackMap[$i]["classes"][] = $class;

            $outerDiv .= $class.", ";
            $innerDiv .= $class." > div, ";
           // if($data['min-width']){
                $output .= $class . $css . $endOfLine;
            //}
        }

        if($data['min-width']){
            $output .= $endOfLine."}".$endOfLine;
        }

    }

    foreach ($fallBackMap as $key => $data) {
          $fallBack .= implode(",",$data['classes']).$data['css'].$endOfLine;
    }

$output = "
/*!
scaler.v1.css v^1.0 | MIT License | https://github.com/zenril/scaler

Copyright (c) Aaron Meredith
*/

$outerDiv div.scale{width: 100%;position: relative;}

$innerDiv  div.scale > div{ position: absolute; top: 0; bottom: 0; left: 0; right: 0; text-align: center;}"
.$endOfLine.$fallBack.$output;

file_put_contents('scaler.v1.css', $output);