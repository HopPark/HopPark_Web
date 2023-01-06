<?php

include_once("../config/config.php");
include_once("../BaseController.php");

class enter_car_log extends BaseController
{
    public function run()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try { 
                if (isset($arrQueryStringParams['pl_id']) && $arrQueryStringParams['pl_id'] &&
                    isset($arrQueryStringParams['car_plate']) && $arrQueryStringParams['car_plate'] &&
                    isset($arrQueryStringParams['enter_date']) && $arrQueryStringParams['enter_date'] ) {

                    $data_to_update = array();
                    $data_to_update['cpl_pl_id'] = $arrQueryStringParams['pl_id'];
                    $data_to_update['cpl_car_plate'] = $arrQueryStringParams['car_plate'];
                    $data_to_update['cpl_enter_date'] = $arrQueryStringParams['enter_date'];

                    $db = getDbInstance();
                    $db->startTransaction();
                    $db->where('pl_id', $arrQueryStringParams['pl_id']);
                    $row3 = $db->update('parking_lot', Array ('pl_size' => $db->inc(1)));

                    $id = $db->insert('car_parking_logs', $data_to_update);

					if ($row3 && $id) {
                        $db->commit();
    	                $data = array();
		                $data['success'] = true;

                        $db = getDbInstance();
                        $db->where('cpl_id', $id);
                        $row = $db->getOne('car_parking_logs');
                        $data['log'] = $row;
		                
						$responseData = json_encode($data, JSON_UNESCAPED_UNICODE);

					} else {
                        $db->rollback();
                        $strErrorDesc = 'Otopark kapasitesi dolu. Hata alındı: '. $db->getLastError();
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
            $this->sendOutput(json_encode(array('success' => false, 'error' => $strErrorDesc, 'log' => null), JSON_UNESCAPED_UNICODE), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}

$enter_car_log = new enter_car_log();
$enter_car_log->run();