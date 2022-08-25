<?php
    if(isset($_POST['funcion']) && !empty($_POST['funcion'])) {
        $funcion = $_POST['funcion'];
        if($funcion=="enviar"){
            $claseAjax = new NewAjax();
            $response = $claseAjax->AjaxConfirmarNotiPOST();
            print_r($response);
        }else if($funcion=="n_push"){
            $claseAjax = new NewAjax();
            $response = $claseAjax->AjaxNotifiPushPOST();
            print_r($response);
        }
    }
    
//CAMBIAR ICONOOS POR LA LIBRERIA DE SEMANTIC
    class NewAjax{ 

        function Datos(){
            require_once("curl.php");
            if (!isset($_SESSION)) {
                session_start();
            }
    
            $header = array('Content-Type: application/x-www-form-urlencoded');
            $url = "https://api.aqupe.com/v1/admin/notificacionAfiliado/token";
            $curl = new newCurl();
            $solicitudes = $curl->curlGet($url,$header);
            $response = $solicitudes;
    
            $pendienteNotificacion = array();
    
            //var_dump($response);
            if(!$response["error"]){
                $pendienteNotificacion = $response["data"];
            }

            return $pendienteNotificacion;
        }

        function DatosRepartidor(){
            require_once("curl.php");
            if (!isset($_SESSION)) {
                session_start();
            }
    
            $header = array('Content-Type: application/x-www-form-urlencoded');
            $url = "https://api.aqupe.com/v1/repartidor/lista/token";
            $curl = new newCurl();
            $solicitudes = $curl->curlGet($url,$header);
            $response = $solicitudes;
    
            $pendienteNotificacion = array();
    
            if(!$response["error"]){
                $pendienteNotificacion = $response["data"];
            }

            return $pendienteNotificacion;
        }

        function AjaxConfirmarNotiPOST(){
            require_once("curl.php");
            if (!isset($_SESSION)) {
                session_start();
            }

            $ArrayCadena = array();
            $pedido = $_POST['text'];
            $idAfiliado = $_POST['text2'];

            $ArrayCadena["pedido"] = $pedido;
            $ArrayCadena["idAfiliado"] = $idAfiliado;

            $header = array('Content-Type: application/x-www-form-urlencoded');
            $url = "https://api.aqupe.com/v1/afiliado/procesar/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2NTkzMjI3NjAsImF1ZCI6IjM2NjgxNzM0YjE4ODAwZTQ0ZDkyNWJjNzY5MjczMDc2M2Y5MmE3MjYiLCJkYXRhIjp7ImlkIjoiODczOSIsImVtYWlsIjoibWFyQGdtYWlsLmNvbSJ9fQ.5rUdLtYgmee-L5lg_bSfRWRLyEl5t45TK42hi47HeXw";
            
            $curl = new newCurl();
            $solicitudes = $curl->curlPost($url,$header,$ArrayCadena);
            $response = $solicitudes;
            return $response;
        }

        function AjaxNotifiPushPOST(){

            require_once("curl.php");
            if (!isset($_SESSION)) {
                session_start();
            }

            $ArrayCadena = array();
            $pedido = $_POST['text'];
            $idAfiliado = $_POST['text2'];

            $ArrayCadena["pedido"] = $pedido;
            $ArrayCadena["idAfiliado"] = $idAfiliado;

            $header = array('Content-Type: application/x-www-form-urlencoded');
            $url = "http://api.aqupe.com/v1/afiliado/notificar/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2NjA3OTg5OTAsImF1ZCI6ImRlNDgxMGFlZjdlOTRkMTAwNDFhZWE3MDAyMDMwNzc2ZmM0NjBkNjMiLCJkYXRhIjp7ImlkIjoiMjAxNTYwIiwiZW1haWwiOiJtYXJAZ21haWwuY29tIn19.JZ-TAIea9A2UbAt_2p5JFCxJQ6U6ntqXmbK7LW25chs";
            
            $curl = new newCurl();
            //$solicitudes = $curl->curlPost($url,$header,$ArrayCadena);
            $solicitudes = $curl->curlGet($url,$header);
            $response = $solicitudes;
            return $response;
        }



        
    }

?>
    