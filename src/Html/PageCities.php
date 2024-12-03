<?php 
namespace App\Html;

class PageCities extends AbstractPage
{

    static function table(array $entities, array $counties){
        echo '<h1>Városok</h1>';
        self::add($counties);
        echo '<table id="cities-table">';
        self::tableHead();
        self::tableBody($entities, $counties);
        echo '</table>';    
    }

    static function tableHead(){
        echo '
        <thead>
        <tr>
            <th class="id-col">#</th>
            <th>Város</th>
            <th>Irányítószám</th>
            <th>Művelet</th>
        </tr>
        <tr>
        
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
                <td>{$entity['zip_code']}</td>
                <td>
                <div class='button-group'>
                <form method='post' action=''>
                    <input type='hidden' name='edit_city_name' value='{$entity['name']}'>
                    <input type='hidden' name='edit_city_county_id' value='{$entity['id_county']}'>
                    <input type='hidden' name='edit_city_county_id' value='{$entity['zip_code']}'>
                    <button class='gomb' type='submit' name='btn-edit-city' title='Módosít'><i class='fa fa-edit'></i></button>
                </form>
                    <form method='post' action=''>
                        <button class='gomb' type='submit' 
                            id='btn-del-city-{$entity['id']}' 
                            name='btn-del-city' 
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

    static function add($counties){
        echo '<th>&nbsp;</th>
        <th>
         <form name="city-add" method="post" action="">
             <select name="county_id" required>
                <option value="">Válasszon megyét</option>';
                foreach ($counties as $county) {
                    echo "<option value='{$county['id']}'>{$county['name']}</option>";
                }
        echo '   </select>
             <button type="submit" value="" id="btn-ok" name="btn-ok" title="Ok">ok</i></button>
         </form>
        </th>
        
        <th class="flex">
        &nbsp;
        </th>';
    }

    static function showModifyCities($id = null, $name = '', $county_id = null, $counties = [])
    {
        echo '
        <form method="post" action="">
            <input type="hidden" name="modified_city_id" value="' . htmlspecialchars($id) . '">
            <label for="modified_city_name">Város neve:</label>
            <input type="text" name="modified_city_name" value="' . htmlspecialchars($name) . '">
            <label for="modified_city_county_id">Megye:</label>
            <select name="modified_city_county_id" required>';
                foreach ($counties as $county) {
                    $selected = ($county['id'] == $county_id) ? 'selected' : '';
                    echo "<option value='{$county['id']}' {$selected}>{$county['name']}</option>";
                }
        echo '   </select>
            <button class="gomb" type="submit" name="btn-save-modified-city"><i class="fa fa-save"></i></button>
        </form>';
    }
}