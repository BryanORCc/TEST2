<?php
    require("ajax.php");

    if (!isset($_SESSION)) {
        session_start();
    }

    $ajax = new NewAjax();
    $response = $ajax->Datos();
    $responseRepartidor = $ajax->DatosRepartidor();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="semantic/dist/semantic.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
    <link rel="stylesheet" href="est_adm_asignar_repartidor.css">
    <title>Document</title>
</head>
<body style='background-color: #cccccc; '>
    <div class="container" style="padding: 25px 80px 25px 80px; ">
        <h2 class="ui block header h2Titulo">Pedidos por confirmar</h2>
        
        <table id="" class="ui red compact celled selectable structured table" style="text-align:center; background-color: white; color: black; opacity: 0.7;">
            <thead >
                <tr >
                    <th rowspan="2" Style="width: 5%;"># Pedido</th>
                    <th rowspan="2" Style="width: 10%;">Fecha Conf.</th>
                    <th rowspan="2" Style="width: 8%;">Tiempo</th>
                    <th rowspan="2" Style="width: 8%; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">Afiliados</th>
                    <th rowspan="2" Style="width: 8%; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">Contacto</th>
                    <th colspan="3">Acciones</th>
                </tr>

                <tr>
                    <th Style="width: auto;">Detalle</th>
                    <th Style="width: 10%;">Asignar repartidor</th>
                </tr>
            </thead>

             
            <tbody>
                <?php
                    foreach ($response as $key => $val) {

                        $detalle = "";
                        if (count($val["detalle"])>0) {
                            $detalle = '<table class="ui inverted teal compact celled selectable collapsing structured table" style="margin: 5px 5px 5px 5px; text-align:center;">';
                            for ($i=0; $i < count($val["detalle"]) ; $i++) { 

                                $detalle.= '<thead><tr>'.
                                                '<th rowspan="2">Cant</th>'.
                                                '<th rowspan="2" Style="width: 100%; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">Producto</th>'.
                                                '<th rowspan="2">Precio</th>'.
                                                '<th rowspan="2">Sub Total</th>'.
                                            '</tr></thead>'.
                                
                                            "<tr>".
                                                "<td>".$val["detalle"][$i]['cantidad']."</td>".
                                                "<td>".ucfirst(strtolower($val["detalle"][$i]['producto']))."</td>".
                                                "<td>".$val["detalle"][$i]['precioUnitario']."</td>".
                                                "<td>".$val["detalle"][$i]['subtotal']."</td>".
                                            "</tr>";
                            }
                            $detalle .= "</table>";
                        }

                        echo 
                            '<tr id="TR'.$val["pedido"]."-".$val["idAfiliado"].'">'.
                                '<td>'.$val["pedido"].'</td>'.
                                '<td>'.$val["fechaPedido"].'</td>'.
                                '<td>'.$val["hora"].'</td>'.
                                '<td>'.$val["razonSocial"].'</td>'.
                                '<td>'.$val["telefono"].' / '.$val["telefono2"].'</td>'.
                                '<td>'.($detalle).'</td>'.
                                '<td> <i'.' id="'.$val["pedido"]."-".$val["idAfiliado"].'" class="iu big motorcycle icon button btnAsignarRepartidor" style="cursor: pointer;">'.'</i></td>'
 
                            .'</tr>';

                    }
                ?>
            </tbody>

        </table>
        

        <div id="modalImage" class="ui tiny modal imgLiquidFill">
        </div>
    </div>              
    

    <!--MODAL-1--------------------------- -->
    <div class="ui modal Ventana1" style="padding: 10px 10px 10px 10px;">
        <h1 class="header modalTitulo">Seleccionar repartidor</h1>

        <table id="" class="ui red compact celled selectable structured table" style="text-align:center;" method="post"  size=10>
            <thead >
                <tr>
                    <th rowspan="2" Style="width: 5%;">ID</th>
                    <th rowspan="2" Style="width: 10%;">Nombres</th>
                    <th rowspan="2" Style="width: 8%;">Numero documento</th>
                    <th rowspan="2" Style="width: 5%;">Contacto</th>
                    <th rowspan="3" Style="width: auto;">Estado</th>
                </tr>
               
            </thead>

            <tbody>

                <?php
                    foreach ($responseRepartidor as $key => $val) {
                        
                        echo  
                            '<tr>'.
                                '<td>'.$val["id"].'</td>'.
                                '<td>'.$val["nombres"].'</td>'.
                                '<td>'.$val["numeroDoc"].'</td>'.
                                '<td>'.$val["telefono"].' / '.$val["telefono2"].'</td>'.

                                '<td>'. 
                                    '<label class="ui green tag label" style="margin-right: 3%;"> <input class="inpOpcion btnActivo" type="checkbox" id="A'.$val["id"].'" name="estados" value="Activo"> Activo</label>'.
                                    '<label class="ui orange tag label" style="margin-right: 3%;"> <input class="inpOpcion btnPendiente" type="checkbox" id="P'.$val["id"].'" name="estados" value="Pendiente"> Pendiente</label>'.
                                    '<label class="ui red tag label"> <input class="inpOpcion btnNoActivo" checked type="checkbox" id="N'.$val["id"].'" name="estados" value="NoActivo"> No Activo</label>'.
                                '</td>'
                            .'</tr>';
                    }
                ?>
            </tbody>
        </table>

        <div class="actions">
            <div class="ui buttons">
                <button class="ui negative button" >Cancelar</button>
                <div class="or"></div>
                <button class="ui positive button AccionAsignar">Asignar</button>
            </div>
        </div>

    </div>
    <!--___________________________________________-->  
 

    <script>
        var datoI = "";
        //var datoINPUT = "";
        //var IDNoActivo = "";
        $(document).ready(function(){
            //BOTON 1 --------------------------------------------------------------------------
            $(".btnAsignarRepartidor").click(function() {
                datoI = $(this).closest('i').attr('id');
                console.log(datoI);
                $('.modal.Ventana1').modal('setting', 'closable', false).modal('show');
            });

            $('.btnActivo').click(function(){

                /*var dd1 = document.getElementsByClassName("btnActivo")[0].id;
                var dd2 = document.getElementsByClassName("btnPendiente")[0].id;
                var dd3 = $('.btnActivo').closest('.btnNoActivo').attr('id')*/

                console.log(dd3);
                $(dd3).attr('checked', true);

                //Obtener ID del checkbox "No Activo"
                /*var dd = document.getElementsByClassName("btnNoActivo")[0].id;
                //var datoINPUT = $(this).closest('.btnActivo').attr('id');*/
                
                if ($(this).prop('checked')) {
                    //dd.checked = 0;
                    $('.btnNoActivo').prop('checked', false);
                    //console.log(dd.checked);
                }
                //console.log(dd);

            });

        })

        /*
            $('.AccionConfirmar').click(function(){
                var Pedido = "";
                var IdAfiliado = "";
                let Caracter = "";

                //console.log(datoTR);

                for (let i = 0; i < datoTR.length; i++) {
                    Caracter = datoTR.substr(i,1);

                    if(Caracter!="-"){
                        Pedido = Pedido + Caracter;
                    }else{
                        datoTR = datoTR.substr((i+1),datoTR.length);
                        IdAfiliado = datoTR;
                    }
                }

                $.ajax({
                    method: "POST",
                    url: "ajax.php",
                    data: {funcion: "enviar", text: Pedido, text2: IdAfiliado},
                    success: function(response) {
                        if (response.error === true) {
                            alert(response.message);
                        }else{
                            document.getElementById("TR"+Pedido+"-"+IdAfiliado).remove();
                        }
                    }
                });

                console.log("Pedido:"+Pedido);
                console.log("Afiliado: "+IdAfiliado);

            });
        })*/

    </script>

   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.js"></script>
    
</body>
</html>