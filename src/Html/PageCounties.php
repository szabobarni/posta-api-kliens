<?php 
namespace App\Html;

class PageCounties extends AbstractPage{

    static function table(array $entites){
        echo '<h1>Megyék</h1>';
        self::searchBar();
        echo '<table id="counties-table">';
        self::tableHead();
        self::tableBody($entites);
        echo '</table>';    
    }
    static function tableHead(){
        echo'<thead>
        <tr>
            <th class="id"-col>#</th>
            <th>Megnevezés</th>
            <th style="float: right; display: felx">Művelet&nbsp;
                <button id="brn-add" title="Új">+</button>
            </th>
        </tr>
        <tr id="editor" class="hidden">
        </tr>
       </thead>';
    }
    static function editor(){
        echo'<th>&nbsp;</th>
        <th>
         <form name="county-editor" method="post" action="">
             <input type="hidden" name="id" id="id">
             <input type="search" id="name" name="name" placeholder="Megye" required>
             <button type="submit" id="btn-save-county" name="btn-save-county" title="Ment"><i class="fa fa-save"></i></button>
             <button type="button" id="btn-cancel-county" name="btn-cancel-county" title="Megse"><i class="fa fa-cancel"></i></button>
         </form>
        </th>
        
        <th class="flex">
        &nbsp;
        </th>';
    }
    
    
}