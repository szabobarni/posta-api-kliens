<?php

namespace App\Interfaces;

interface PageInterface{

    static function head();
    
    static function nav();

    static function footer();

    static function tableHead();

    static function tableBody();

    static function table();

    static function searchBar();
}
?>