<?php

include_once("../config/config.php");
include_once("../BaseController.php");

class edit_car extends BaseController
{
    public function run()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try { 
                if (isset($arrQueryStringParams['car_owner_id']) && $arrQueryStringParams['car_owner_id'] &&
                    isset($arrQueryStringParams['car_id']) && $arrQueryStringParams['car_id']	) {

                    $data_to_update = array();
                    if (isset($arrQueryStringParams['brand']) && $arrQueryStringParams['brand'] )
                        $data_to_update['car_brand'] = $arrQueryStringParams['brand'];

                    if (isset($arrQueryStringParams['model']) && $arrQueryStringParams['model'] )
                        $data_to_update['car_model'] = $arrQueryStringParams['model'];

                    if (isset($arrQueryStringParams['plate']) && $arrQueryStringParams['plate'] )
                        $data_to_update['car_plate'] = $arrQueryStringParams['plate'];

                    
                    if (count($data_to_update) == 0) {
                        $stat = null;
                    } else {
                        $db = getDbInstance();
                        $db->where('car_id', $arrQueryStringParams['car_id']);
                        $db->where('car_owner_id', $arrQueryStringParams['car_owner_id']);
                        $stat = $db->getOne('cars');
                    }

					if ($stat != null) {
                        $db = getDbInstance();
                        $db->where('car_id', $arrQueryStringParams['car_id']);
                        $db->where('car_owner_id', $arrQueryStringParams['car_owner_id']);
    
                        $stat = $db->update('cars', $data_to_update);

    	                $data = array();
		                $data['success'] = true;

                        $db = getDbInstance();
                        $db->where('car_id', $arrQueryStringParams['car_id']);
                        $row = $db->getOne('cars');
                        $data['car'] = $row;
		                
						$responseData = json_encode($data, JSON_UNESCAPED_UNICODE);

					} else {
                        $strErrorDesc = 'Hata alındı! Araç bulunamadı';
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

$edit_car = new edit_car();
$edit_car->run();