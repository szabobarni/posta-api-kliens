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
            case "PUT":
                self::putRequest();
                break;
            case "GET":
            case "DELETE":
                self::deleteRequest();
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
        switch ($request) {
            case isset($request['btn-home']) :
                break;
            case isset($request['btn-counties']) :
                PageCounties::table(self::getCounties());
                break;  
        }
    }
    private static function getCounties() : array
    {
        $client = new Client();
        $response = $client->get('counties');

        return $response['data'];
    }
    
    private static function putRequest()
    {
        parse_str(file_get_contents("php://input"), $requestData);

        if (isset($requestData['id']) && isset($requestData['name'])) {
            $id = $requestData['id'];
            $name = $requestData['name'];

            $client = new Client();
            $response = $client->put("counties/{$id}", ['name' => $name]);

            if ($response['success']) {
                echo json_encode(['message' => 'County updated successfully.']);
            } 
            else 
            {
                echo json_encode(['error' => 'Failed to update county.']);
            }
        } 
        else 
        {
            echo json_encode(['error' => 'Invalid input data.']);
        }
    }
    private static function deleteRequest()
    {
        parse_str(file_get_contents("php://input"), $requestData);

        if (isset($requestData['id'])) {
            $id = $requestData['id'];

            $client = new Client();
            $response = $client->delete("counties/{$id}");

            if ($response['success']) {
                echo json_encode(['message' => 'County deleted successfully.']);
            } 
            else 
            {
                echo json_encode(['error' => 'Failed to delete county.']);
            }
        } 
        else 
        {
            echo json_encode(['error' => 'Invalid input data.']);
        }
    }
}
