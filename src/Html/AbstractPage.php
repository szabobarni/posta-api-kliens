<?php

namespace App\Html;

use App\Interfaces\PageInterface;

abstract class AbstractPage implements PageInterface{
    static function head(){
        echo'
        <!doctype html>
        <html land="hu-hu">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1>
            <title>Posta</title>
        </head>';   
    }
    static function nav(){
        echo' 
        <nav>
            <form name="nav" method="post" action="index.php">
                <button type="submit" name="btn-home">Kezdőlap</button>
                <button type="submit" name="btn-counties">Megyék</button>
                <button type="submit" name="btn-cities">Városok</button>
            </form>
        </nav>';
    }
    static function footer(){
        echo '
        <footer>
            Copyrigth nev
        </footer>
        </html>';
    }
    static function searchBar(){
        echo'<form method="post" action="">
            <input type="search" name="needle" placeholder="Keres">
                <button type="submit" id="btn-search" name="btn-search" title="Keres">
                    <i class="fa fa-search"></i>
                </button>
        </form>
        <br>';
    }
}