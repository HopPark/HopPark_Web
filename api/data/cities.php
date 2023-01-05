<?php

include_once("../config/config.php");
include_once("../BaseController.php");

class cities extends BaseController
{
    public function run()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try { 
                $db = getDbInstance();

                $page = 1;
                if (isset($arrQueryStringParams['page']) && $arrQueryStringParams['page']) {
                    $page = $arrQueryStringParams['page'];
                }

                $pagelimit = 1000;
                $db->pageLimit = $pagelimit;

                $rows = $db->arraybuilder()->paginate('cities', $page);
                $total_pages = $db->totalPages;

                $data = array();
                if($rows)
                    $data['success'] = true;
                else
                    $data['success'] = false;
                $data['cities'] = $rows;
                $data['total_pages'] = $total_pages;

				$responseData = json_encode($data, JSON_UNESCAPED_UNICODE);

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

$cities = new cities();
$cities->run();