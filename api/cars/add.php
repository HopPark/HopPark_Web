<?php

include_once("../config/config.php");
include_once("../BaseController.php");

class add_car extends BaseController
{
    public function run()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try { 
                if (isset($arrQueryStringParams['car_owner_id']) && $arrQueryStringParams['car_owner_id'] &&
                    isset($arrQueryStringParams['brand']) && $arrQueryStringParams['brand'] &&
                    isset($arrQueryStringParams['model']) && $arrQueryStringParams['model'] &&
                    isset($arrQueryStringParams['plate']) && $arrQueryStringParams['plate'] ) {

                    $data_to_update = array();
                    $data_to_update['car_owner_id'] = $arrQueryStringParams['car_owner_id'];
                    $data_to_update['car_brand'] = $arrQueryStringParams['brand'];
                    $data_to_update['car_model'] = $arrQueryStringParams['model'];
                    $data_to_update['car_plate'] = $arrQueryStringParams['plate'];

                    $db = getDbInstance();
                    $id = $db->insert('cars', $data_to_update);

					if ($id) {
    	                $data = array();
		                $data['success'] = true;

                        $db = getDbInstance();
                        $db->where('car_id', $id);
                        $row = $db->getOne('cars');
                        $data['car'] = $row;
		                
						$responseData = json_encode($data, JSON_UNESCAPED_UNICODE);

					} else {
                        $strErrorDesc = 'Hata alındı: '. $db->getLastError();
	            		$strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
					}
                } else {
					$strErrorDesc = 'Girilen parametreler eksik veya hatalı!';
            		$strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
				}

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
            $this->sendOutput(json_encode(array('success' => false, 'error' => $strErrorDesc, 'car' => null), JSON_UNESCAPED_UNICODE), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}

$add_car = new add_car();
$add_car->run();