<?php 
namespace App\Html;

class PageCounties extends AbstractPage
{

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
            <th>Művelet&nbsp;
                <button id="btn-add" title="Új">+</button>
            </th>
        </tr>
        <tr id="editor" class="hidden">
        '.self::editor().'
        </tr>
       </thead>';
    }
    static function tableBody(array $entities)
    {
        echo '<tbody>';
        $i = 0;
        foreach ($entities as $entity) {
            $onClick = sprintf(
                'btnEditCountyOnClick(%d, "%s")', 
                $entity['id'], 
                $entity['name']
            );
            echo "
            <tr class='" . (++$i % 2 ? "odd" : "even") . "'>
                <td>{$entity['id']}</td>
                <td>{$entity['name']}</td>
                <td>
                <div class='button-group'>
                    <button class='gomb' type='button' 
                        id='btn-edit-{$entity['id']}' 
                        onclick='$onClick' 
                        title='Módosít'>
                        <i class='fa fa-edit'></i>
                    </button>
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