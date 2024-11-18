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
        if (isset($request['page'])) {
            $page = $request['page'];
            switch ($page) {
                case 'counties':
                    PageCounties::table(self::getCounties());
                    break;
                case 'cities':
                      break;
            }
        }
//        header("Refresh:0");
    }
    private static function postRequest()
    {
        $request = $_REQUEST;
        $client = new Client();
        switch ($request) {
            case isset($request['btn-home']) :
                break;
            case isset($request['btn-counties']) :
                PageCounties::table(self::getCounties());
                break;
            case isset($request['btn-del-county']) :
                self::deleteCounty($_POST['btn-del-county']);
                PageCounties::table(self::getCounties());
                break; 
            case isset($request['btn-search']):
                $client = new Client();
                $response = $client->post('counties', ['needle' => $request['needle']]);
                $entities = [];
                if (isset($response['data'])) {
                    $entities = $response['data'];
                }
                PageCounties::table($entities);
                break;
            case isset($request['btn-save-county']):               
                $data['name'] = $request['name'];
                $client->post('counties', $data);
                PageCounties::table(self::getCounties());
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
        }
    }
    private static function getCounties() : array
    {
        $client = new Client();
        $response = $client->get('counties');

        return $response['data'];
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
