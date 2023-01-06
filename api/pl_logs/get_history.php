<?php

include_once("../config/config.php");
include_once("../BaseController.php");

class PL_history extends BaseController
{
    public function run()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try { 
                if (isset($arrQueryStringParams['user_id']) && $arrQueryStringParams['user_id'] ) {
                    $db = getDbInstance();

                    $page = 1;
                    if (isset($arrQueryStringParams['page']) && $arrQueryStringParams['page']) {
                        $page = $arrQueryStringParams['page'];
                    }

                    $pagelimit = 1000;
                    $db->pageLimit = $pagelimit;
                    $db->where('user_id', $arrQueryStringParams['user_id']);

                    $rows = $db->arraybuilder()->paginate('pl_log_mobile', $page);
                    $total_pages = $db->totalPages;

                    $data = array();
                    if($rows)
                        $data['success'] = true;
                    else
                        $data['success'] = false;
                    $data['history'] = $rows;
                    $data['total_pages'] = $total_pages;

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

$PL_history = new PL_history();
$PL_history->run();