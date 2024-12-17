<?php 
/**
 * @author Németh Rajmonnd Ádám, Szabó József Barnabás
 */
namespace App\Html;

class PageCities extends AbstractPage
{

    static function table(array $entities, array $counties,array $abc, int $id_county){
        echo '<h1>Városok</h1>';
        self::dropdown($counties);
        echo '<table id="cities-table">';
        self::tableHead();
        self::showAbcButtons($abc, $id_county);
        self::tableBody($entities);
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
    static function showAbcButtons(array $abc, int $id_county)
    {
        //var_dump($abc);
        //die;
        echo "<div style='display: flex'>";
        foreach ($abc as $ch) {
            echo '
            <form method="post" action="">
                <input type="hidden" name="ch-input" value='.$id_county.'>
                <button type="submit" name="ch-buttons" value='.$ch['abc'].'>'.$ch['abc'].'</button>&nbsp;
            </form>
            ';
        }
        echo "</div><br>";
    }

    static function tableBody(array $entities)
    {
        echo '<tbody>';
        $i = 0;
        foreach ($entities as $entity) {
            echo "
            <tr class='" . (++$i % 2 ? "odd" : "even") . "'>
                <td>{$entity['id']}</td>
                <td>{$entity['city']}</td>
                <td>{$entity['zip_code']}</td>
                <td>
                <div class='button-group'>
                <form method='post' action=''>
                    <input type='hidden' name='edit_city_id' value='{$entity['id']}'>
                    <input type='hidden' name='edit_city_name' value='{$entity['city']}'>
                    <input type='hidden' name='edit_city_county_id' value='{$entity['id_county']}'>
                    <input type='hidden' name='edit_city_zip_code' value='{$entity['zip_code']}'>
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

    static function dropdown($counties){
        echo '<th>&nbsp;</th>
        <th>
         <form method="post" action="">
             <select name="county_id" required>
                <option value="">Válasszon megyét</option>';
                foreach ($counties as $county) {
                    echo "<option value='{$county['id']}'>{$county['name']}</option>";
                }
        echo '   </select>
            <button type="submit" value="" id="btn-ok" name="btn-ok" title="Ok"><i class="fa-solid fa-check"></i></i></button>
            </form>
        <form method="post" action="">
             <button type="submit" name="btn-add"><i class="fa-solid fa-plus"></i></button>&nbsp;
        </form>
        </th>
        
        <th class="flex">
        &nbsp;
        </th>';
    }

    static function showModifyCities($id,$name,$zip,$idCounty,$counties)
    {
        echo '
        <form method="post" action="">
            <input type="hidden" name="modified_city_id" value="' . htmlspecialchars($id) . '">
            <label for="modified_city_name">Város neve:</label>
            <input type="text" name="modified_city_name" value="' . htmlspecialchars($name) . '">
            <label for="modified_city_zip">Irányítószám:</label>
            <input type="text" name="modified_city_zip" value="' . htmlspecialchars($zip) . '">
            <label for="modified_city_county_id">Megye:</label>
            <select name="modified_city_county_id" required>';
            $countyName = "";
            foreach ($counties as $county) {
                if ($county['id'] == $idCounty) {
                    $countyName = $county['name'];
                }
            }
                echo'<option value='. htmlspecialchars($idCounty) .' selected>'.$countyName.'</option>';
                foreach ($counties as $county) {
                    echo "<option value='{$county['id']}'>{$county['name']}</option>";
                }
        echo '   </select>
            <button class="gomb" type="submit" name="btn-save-modified-city"><i class="fa fa-save"></i></button>
        </form>';
    }
    static function showAddCities($counties)
    {
        echo '
        <form method="post" action="">
            <label for="new_city_name">Város neve:</label>
            <input type="text" name="new_city_name" value="">
            <label for="new_city_zip">Irányítószám:</label>
            <input type="text" name="new_city_zip" value="">
            <label for="new_city_county_id">Megye:</label>
            <select name="new_city_county_id" required>
                <option value="">Válasszon megyét</option>';
                foreach ($counties as $county) {
                    echo "<option value='{$county['id']}'>{$county['name']}</option>";
                }
        echo '   </select>
            <button class="gomb" type="submit" name="btn-add-city"><i class="fa fa-save"></i></button>
        </form>';
    }
}