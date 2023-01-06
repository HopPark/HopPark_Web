<?php

include_once("../config/config.php");
include_once("../BaseController.php");

class exit_car_log extends BaseController
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
                    isset($arrQueryStringParams['exit_date']) && $arrQueryStringParams['exit_date'] ) {

                    $data_to_update = array();
                    if (isset($arrQueryStringParams['exit_date']) && $arrQueryStringParams['exit_date'] )
                        $data_to_update['cpl_exit_date'] = $arrQueryStringParams['exit_date'];

                    
                    $db = getDbInstance();
                    $db->where('cpl_pl_id', $arrQueryStringParams['pl_id']);
                    $db->where('cpl_car_plate', $arrQueryStringParams['car_plate']);
                    $db->where('cpl_exit_date', NULL, 'IS');
                    $row = $db->getOne('car_parking_logs');

                    $db = getDbInstance();
                    $db->where('pl_id', $arrQueryStringParams['pl_id']);
                    $row2 = $db->getOne('parking_lot');

					if ($row != null && $row2 != null) {
                        $phpdate1 = strtotime( $row['cpl_enter_date'] );
                        $phpdate2 = strtotime( $data_to_update['cpl_exit_date'] );

                        $db = getDbInstance();
                        $db->startTransaction();
                        $db->where('cpl_id', $row['cpl_id']);

                        $data_to_update['cpl_total_payment'] = (($phpdate2-$phpdate1)/3600)*$row2['pl_hourly_rate'];
                        $row3 = $db->update('car_parking_logs', $data_to_update);

                        $db->where('pl_id', $arrQueryStringParams['pl_id']);
                        $row4 = $db->update('parking_lot', Array ('pl_size' => $db->inc(-1)));

                        if($row3 && $row4){
                            $db->commit();

                            $data = array();
                            $data['success'] = true;

                            $db = getDbInstance();
                            $db->where('cpl_id', $row['cpl_id']);
                            $row = $db->getOne('car_parking_logs');
                            $data['log'] = $row;
                            
                            $responseData = json_encode($data, JSON_UNESCAPED_UNICODE);
                        } else {
                            $db->rollback();
                            $strErrorDesc = 'Hata alındı! Çıkış tarihi hatalı';
                            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
                        }

					} else {
                        $strErrorDesc = 'Hata alındı! Kayıt bulunamadı';
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

$exit_car_log = new exit_car_log();
$exit_car_log->run();