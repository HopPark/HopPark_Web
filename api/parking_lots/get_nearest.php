<?php

include_once("../config/config.php");
include_once("../BaseController.php");

class nearestListPL extends BaseController
{
    public function run()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try { 
                $db = getDbInstance();

                $nearest_size = 10;
                $lat = 41.9;
                $lng = 29.0;
                if (isset($arrQueryStringParams['lat']) && $arrQueryStringParams['lat']) {
                    $lat = $arrQueryStringParams['lat'];
                }
                if (isset($arrQueryStringParams['lng']) && $arrQueryStringParams['lng']) {
                    $lng = $arrQueryStringParams['lng'];
                }

                $rows = $db->get('pl_view_mobile');

                $distances = array();
                foreach ($rows as $key => $row) {
                    $geojson = json_decode($row["pl_geojson"], true);

                    $a = $lat - $geojson["geometry"]["coordinates"]["1"];
                    $b = $lng - $geojson["geometry"]["coordinates"]["0"];
                    $distance = sqrt(($a**2) + ($b**2));
                    $distances[$key] = $distance;

                    $rows[$key]["lat"] = $geojson["geometry"]["coordinates"]["1"];
                    $rows[$key]["lng"] = $geojson["geometry"]["coordinates"]["0"];
                    unset($rows[$key]["pl_geojson"]);
                }
                asort($distances);

                $data = array();
                if($rows)
                    $data['success'] = true;
                else
                    $data['success'] = false;

                $keys = array_keys($distances);
                for ($i=0; $i < $nearest_size && $i < count($distances); $i++) { 
                    $data['parking_lots'][$i] = $rows[$keys[$i]];
                }

				$responseData = json_encode($data, JSON_UNESCAPED_UNICODE);

            } catch (Exception $e) {
                $strErrorDesc = $e->getMessage().'Bilinmeyen hata oluştu! Destek kısmından iletişime geçin.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method geçersiz';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
 
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('success' => false, 'error' => $strErrorDesc), JSON_UNESCAPED_UNICODE), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}

$nearestListPL = new nearestListPL();
$nearestListPL->run();