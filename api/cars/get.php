<?php

include_once("../config/config.php");
include_once("../BaseController.php");

class get_users_car extends BaseController
{
    public function run()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try { 
                if (isset($arrQueryStringParams['car_owner_id']) && $arrQueryStringParams['car_owner_id']	) {

                    $db = getDbInstance();
                    $db->where('car_owner_id', $arrQueryStringParams['car_owner_id']);

                    $rows = $db->get('cars');

                    $data = array();
                    if($rows)
                        $data['success'] = true;
                    else
                        $data['success'] = false;
                    $data['cars'] = $rows;
                    $responseData = json_encode($data, JSON_UNESCAPED_UNICODE);

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
            $this->sendOutput(json_encode(array('success' => false, 'error' => $strErrorDesc), JSON_UNESCAPED_UNICODE), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}

$get_users_car = new get_users_car();
$get_users_car->run();