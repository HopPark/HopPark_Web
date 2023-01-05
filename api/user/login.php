<?php

include_once("../config/config.php");
include_once("../BaseController.php");

class login extends BaseController
{
    public function run()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try { 
                if (isset($arrQueryStringParams['user_mobile']) && $arrQueryStringParams['user_mobile'] &&
            			isset($arrQueryStringParams['password']) && $arrQueryStringParams['password']	) {
                    
					$db = getDbInstance();
	            	$db->where("user_mobile", $arrQueryStringParams['user_mobile']);
				    $db->where('user_password', $arrQueryStringParams['password']);

					$row = $db->getOne('users');

					if ($row != null) {
    	                $data = array();
		                $data['success'] = true;
                        unset($row['user_password']);
		                $data['user'] = $row;
		                
						$responseData = json_encode($data, JSON_UNESCAPED_UNICODE);

					} else {
						$strErrorDesc = 'Telefon numarası ya da şifre hatalı!';
	            		$strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
					}
                } else {
					$strErrorDesc = 'Telefon numarası ya da şifre hatalı!';
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

$login = new login();
$login->run();