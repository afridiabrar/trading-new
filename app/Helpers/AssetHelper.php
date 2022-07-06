<?php
/**
 * AssetHelper
 *
 * @author Muhammad Shahab <shahab@inoviotech.com>
 * @date   09/06/21
 */

/**
 * Used to generate URL of the CSS file for front end
 */
function frontCss($file = '')
{
    return asset('assets/front/css/' . $file);
}

function frontFiles($file = '')
{
    return asset('assets/front/' . $file);
}

/**
 * Used to generate URL of the fonts file for front end
 */
function frontFont($file = '')
{
    return asset('assets/front/fonts/' . $file);
}

/**
 * Used to generate URL of the image file for front end
 */
function frontImage($file = '')
{
    return asset('assets/front/img/' . $file);
}

/**
 * Used to generate URL of the JavaScript file for front end
 */
function frontJs($file = '')
{
    return asset('assets/front/js/' . $file);
}

function StorageImage($path){
    return asset('storage/app/'.$path);
}

function productImage($folderName='',$file = ''){
    return asset('storage/app/product'.$folderName.'/'.$file);
}

function truncateString($str, $chars, $to_space, $replacement="...") {
    if($chars > strlen($str)) return $str;

    $str = substr($str, 0, $chars);
    $space_pos = strrpos($str, " ");
    if($to_space && $space_pos >= 0)
        $str = substr($str, 0, strrpos($str, " "));

    return($str . $replacement);
}
