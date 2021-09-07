<?php



function active_menu($link)
{
    if(preg_match('/' . $link . '/i', \Request::segment(2))) {
        return ['', 'true', 'show'];
    }else {
        return ['collapsed', 'false', ''];
    }
}