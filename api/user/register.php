<?php

include_once("../config/config.php");
include_once("../BaseController.php");

class register extends BaseController
{
    public function run()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try { 
                if (isset($arrQueryStringParams['name']) && $arrQueryStringParams['name'] &&
                    isset($arrQueryStringParams['password']) && $arrQueryStringParams['password'] &&
                    isset($arrQueryStringParams['mobile']) && $arrQueryStringParams['mobile'] &&
                    isset($arrQueryStringParams['email']) && $arrQueryStringParams['email'] &&
                    isset($arrQueryStringParams['tc']) && $arrQueryStringParams['tc']	) {

                    $data_to_update = array();
                    $data_to_update['user_name'] = $arrQueryStringParams['name'];
                    $data_to_update['user_password'] = $arrQueryStringParams['password'];
                    $data_to_update['user_mobile'] = $arrQueryStringParams['mobile'];
                    $data_to_update['user_email'] = $arrQueryStringParams['email'];
                    $data_to_update['user_tc'] = $arrQueryStringParams['tc'];

                    $db = getDbInstance();
                    $id = $db->insert('users', $data_to_update);

					if ($id) {
    	                $data = array();
		                $data['success'] = true;

                        $db = getDbInstance();
                        $db->where('user_id', $id);
                        $row = $db->getOne('users');
                        unset($row['user_password']);
                        $data['user'] = $row;
		                
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
            $this->sendOutput(json_encode(array('success' => false, 'error' => $strErrorDesc, 'user' => null), JSON_UNESCAPED_UNICODE), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}

$register = new register();
$register->run();