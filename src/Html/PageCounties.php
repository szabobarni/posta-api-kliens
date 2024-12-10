<?php 
namespace App\Html;

class PageCounties extends AbstractPage
{

    static function table(array $entites, array $counties,array $abc){
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
            <th>Művelet&nbsp;
            </th>
        </tr>
        <tr>
        '.self::add().'
        </tr>
       </thead>';
    }
    static function tableBody(array $entities)
    {
        echo '<tbody>';
        $i = 0;
        foreach ($entities as $entity) {
            echo "
            <tr class='" . (++$i % 2 ? "odd" : "even") . "'>
                <td>{$entity['id']}</td>
                <td>{$entity['name']}</td>
                <td>
                <div class='button-group'>
                <form method='post' action=''>
                    <input type='hidden' name='edit_county_id' value='{$entity['id']}'>
                    <input type='hidden' name='edit_county_name' value='{$entity['name']}'>
                    <button class='gomb' type='submit' name='btn-edit' title='Módosít'><i class='fa fa-edit'></i></button>
                </form>
                    <form method='post' action=''>
                        <button class='gomb' type='submit' 
                            id='btn-del-county-{$entity['id']}' 
                            name='btn-del-county' 
                            value='{$entity['id']}' 
                            title='Töröl'>
                            <i class='fa fa-trash'></i>
                        </button>
                    </form>
                </div>
                </td>
            </tr>";
        }
        echo '</tbody>';
    }
    static function add(){
        echo'<th>&nbsp;</th>
        <th>
         <form name="county-add" method="post" action="">
             <input type="hidden" name="id" id="id_county">
             <input type="search" id="county_name" name="name" value="" placeholder="Megye" required>
             <button type="submit" id="btn-save-county" name="btn-save-county" title="Ment"><i class="fa fa-save"></i></button>
             <button type="button" id="btn-cancel-county" name="btn-cancel-county" title="Megse"><i class="fa fa-cancel"></i></button>
         </form>
        </th>
        
        <th class="flex">
        &nbsp;
        </th>';
    }
    static function showModifyCounties($id = null, $name = '')
    {
    echo '
        <form method="post" action="">
            <input type="hidden" name="modified_county_id" value="' . htmlspecialchars($id) . '">
            <label for="modified_county_name">Megye neve:</label>
            <input type="text" name="modified_county_name" value="' . htmlspecialchars($name) . '">
            <button class="gomb" type="submit" name="btn-save-modified-county"><i class="fa fa-save"></button>
        </form>';
    }
}