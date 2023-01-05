<?php

include_once("../config/config.php");
include_once("../BaseController.php");

class edit_profile extends BaseController
{
    public function run()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try { 
                if (isset($arrQueryStringParams['user_id']) && $arrQueryStringParams['user_id']	) {

                    $data_to_update = array();
                    if (isset($arrQueryStringParams['user_name']) && $arrQueryStringParams['user_name'] )
                        $data_to_update['user_name'] = $arrQueryStringParams['user_name'];

                    if (isset($arrQueryStringParams['user_password']) && $arrQueryStringParams['user_password'] )
                        $data_to_update['user_password'] = $arrQueryStringParams['user_password'];

                    if (isset($arrQueryStringParams['user_mobile']) && $arrQueryStringParams['user_mobile'] )
                        $data_to_update['user_mobile'] = $arrQueryStringParams['user_mobile'];

                    if (isset($arrQueryStringParams['user_email']) && $arrQueryStringParams['user_email'] )
                        $data_to_update['user_email'] = $arrQueryStringParams['user_email'];

                    if (isset($arrQueryStringParams['user_tc']) && $arrQueryStringParams['user_tc'] )
                        $data_to_update['user_tc'] = $arrQueryStringParams['user_tc'];

                    
                    if (count($data_to_update) == 0) {
                        $stat = null;
                    } else {
                        $db = getDbInstance();
                        $db->where('user_id', $arrQueryStringParams['user_id']);
    
                        $stat = $db->update('users', $data_to_update);
                    }

					if ($stat) {
    	                $data = array();
		                $data['success'] = true;

                        $db = getDbInstance();
                        $db->where('user_id', $arrQueryStringParams['user_id']);
                        $row = $db->getOne('users');
                        unset($row['user_password']);
                        $data['user'] = $row;
		                
						$responseData = json_encode($data, JSON_UNESCAPED_UNICODE);

					} else {
                        $strErrorDesc = 'Hata alındı!';
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
            $this->sendOutput(json_encode(array('success' => false, 'error' => $strErrorDesc, 'user' => null), JSON_UNESCAPED_UNICODE), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}

$edit_profile = new edit_profile();
$edit_profile->run();