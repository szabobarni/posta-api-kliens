<?php

namespace App\Html;

use App\RestApiClient\Client;

class Request{
    static function handle()
    {
        switch ($_SERVER["REQUEST_METHOD"]){
            case "POST":                
                self::postRequest();
                break;
            default:
                self::getRequest();
                break;
        }
    }
    private static function getRequest()
    {
        $request = $_REQUEST;
        $abc = [];
        if (isset($request['page'])) {
            $page = $request['page'];
            switch ($page) {
                case 'counties':
                    $counties = [];
                    PageCounties::table(self::getCounties(),$counties,$abc);
                    break;
                case 'cities':
                      break;
            }
        }
//        header("Refresh:0");
    }
    private static function postRequest()
    {
        $abc = [];
        $request = $_REQUEST;
        $client = new Client();
        switch ($request) {
            case isset($request['btn-home']) :
                break;
            case isset($request['btn-counties']) :
                $counties = [];
                PageCounties::table(self::getCounties(),$counties,$abc);
                break;
            case isset($request['btn-cities']):
                PageCities::table(self::getCities(),self::getCounties(),$abc);
                break;
            case isset($request['btn-del-county']) :
                $requestData = $_POST["btn-del-county"];

                if (isset($requestData)) {           
                    $response = $client->delete("counties",$requestData);
                } 
                $counties = [];
                PageCounties::table(self::getCounties(),$counties,$abc);
                break; 
            
            case isset($request['btn-search']):
                $client = new Client();
                $response = $client->post('counties', ['needle' => $request['needle']]);
                $entities = [];
                $counties = [];
                if (isset($response['data'])) {
                    $entities = $response['data'];
                }
                PageCounties::table($entities,$counties,$abc);
                break;
            case isset($request['btn-save-county']):               
                $data['name'] = $request['name'];
                $client->post('counties', $data);
                $counties = [];
                PageCounties::table(self::getCounties(),$counties,$abc);
                break;
            case isset($request['btn-edit']):
                $id = $request['edit_county_id'];
                $name = $request['edit_county_name'];
                PageCounties::showModifyCounties($id,$name);
                break;
            case isset($request['btn-save-modified-county']):
                $client = new Client();
                $id = $request['modified_county_id'];
                $name = $request['modified_county_name'];
                if ($id && $name) {
                    $data = ['id' => $id, 'name' => $name];
                    $response = $client->put("counties/{$id}", $data);
                    echo 'A módosítás sikeres!';
                }
                break;
            

            case isset($request['btn-del-city']) :
                $requestData = $_POST["btn-del-city"];
                $id_county = $_POST['county_id'];
                
                if (isset($requestData)) {           
                    $response = $client->delete("cities",$requestData);
                } 
                PageCities::table(self::getCitiesByCounty($id_county),self::getCounties(),self::getCitiesABC($id_county));
                break; 
            case isset($request['btn-ok']):
                $id_county = $_POST['county_id'];
                PageCities::table(self::getCitiesByCounty($id_county),self::getCounties(),self::getCitiesABC($id_county));
                break; 
            case isset($request['btn-edit-city']):
                $id = $request['edit_city_id'];
                $name = $request['edit_city_name'];
                $idCounty = $request['edit_city_county_id'];
                $zip = $request['edit_city_zip_code'];
                PageCities::showModifyCities($id,$name,$zip,$idCounty);
                break;
            case isset($request['btn-save-modified-city']):
                $client = new Client();
                $id = $request['modified_city_id'];
                $name = $request['modified_city_name'];
                $zip = $request['modified_city_zip'];
                $county_id = $request['modified_city_county_id'];
                if ($id && $name && $zip && $county_id) {
                    $data = ['id' => $id, 'city' => $name,'zip_code' => $zip,'id_county' => $county_id];
                    //var_dump($data);
                    //die;
                    $response = $client->put("cities/{$id}", $data);
                    echo 'A módosítás sikeres!';
                }
                break;
        }
    }
    private static function getCounties() : array
    {
        $client = new Client();
        $response = $client->get('counties');

        return $response['data'];
    }
    private static function getCities() : array
    {
        $client = new Client();
        $response = $client->get('cities');
        //var_dump($response);
        //die;
        return $response['data'];
    }

    private static function getCitiesByCounty($county_id) :?array{
        $client = new Client();
        $response = $client->get("counties/{$county_id}/cities");
        //var_dump($response);
        //die;
        return $response['data'] ?? null;
    }

    private static function getCitiesABC($county_id) :?array{
        $client = new Client();
        $abc = [];
        $response = $client->get("counties/{$county_id}/cities");

        if (isset($response['data']) && is_array($response['data'])) {
            $abc = [];
            foreach ($response['data'] as $city) {
                if (isset($city['city']) && !empty($city['city'])) {
                    $firstLetter = strtoupper(substr($city['city'], 0, 1));
                    if (!in_array($firstLetter, $abc)) {
                        $abc[] = $firstLetter;
                    }
                }
            }

            return $abc; 
        }
        
        return null; 
    }
    
    private static function deleteCounty($id)
    {
        $requestData = $_POST["btn-del-county"];

        if (isset($requestData)) {           
            $client = new Client();
            $response = $client->delete("counties",$requestData);
        } 
    }
}
