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
                if (isset($arrQueryStringParams['mobile']) && $arrQueryStringParams['mobile'] &&
                    isset($arrQueryStringParams['email']) && $arrQueryStringParams['email']	&&
                    isset($arrQueryStringParams['password']) && $arrQueryStringParams['password'] ) {

                    $db = getDbInstance();
                    $db->where('user_email', $arrQueryStringParams['email']);
                    $db->where('user_mobile', $arrQueryStringParams['mobile']);
                    $row = $db->getOne('users');

                    if ($row) {
                        $data_to_update = array();
                        $data_to_update['user_password'] = $arrQueryStringParams['password'];
                        $db = getDbInstance();
                        $db->where('user_id', $row['user_id']);
                        $stat = $db->update('users', $data_to_update);

                        $data = array();
                        $data['success'] = true;
                    
                        $responseData = json_encode($data, JSON_UNESCAPED_UNICODE);

                    } else {
                        $strErrorDesc = 'Email girilen kullanıcı bulunamadı!';
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