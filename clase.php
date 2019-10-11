<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard</title>

  <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="css/jquery.loadingModal.css"> -->

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body style="background-color: #ecedf1;">

<p id="demo"></p>
<div id="card"></div>

    <script>
        class Persona {
            constructor(nombre, edad){
                this.nombre = nombre;
                this.edad = edad;
            }

            saludar(){
                console.log(`Hola mi nombre es ${this.nombre} y tengo ${this.edad}`)
            }
        }       

        let persona = new Persona('Isay',23);

        //persona.saludar();

        
    </script>
    
  <!-- <script>
        class Car {
          constructor(brand) {
            this.carname = brand;
          }
        }
        
        mycar = new Car("Ford");
        
        document.getElementById("demo").innerHTML = mycar.carname;
        document.getElementById("card").innerHTML = "<div class='col-sm-4'>"+
              "<div class='card shadow mb-4'>"+
                  
                  "<div class='card-header py-3 d-flex flex-row align-items-center justify-content-between'>"+
                      "<h6 class='m-0 font-weight-bold text-primary'><a href='seccion_regionales_iframe.php'>Reporte</a></h6>"+
                      "<div class='dropdown no-arrow'>"+
                          "<a class='dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                            "<i class='fas fa-ellipsis-v fa-sm fa-fw text-gray-400'></i>"+
                          "</a>"+
                          "<div class='dropdown-menu dropdown-menu-right shadow animated--fade-in' aria-labelledby='dropdownMenuLink'>"+
                              "<div class='dropdown-header'>Dropdown Header:</div>"+
                              "<a class='dropdown-item' href='#'>Action</a>"+
                              "<a class='dropdown-item' href='#'>Another action</a>"+
                              "<div class='dropdown-divider'></div>"+
                              "<a class='dropdown-item' href='#''>Something else here</a>"+
                          "</div>"+
                      "</div>"+
                  "</div>"+
                 
                  "<div class='card-body'>"+
                      "<div>"+                  
                          "<canvas id='myAreaChart1'></canvas>"+                  
                      "</div>"+
                  "</div>"+    
              "</div>"+
      "</div>";
    </script>  -->
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
  <script src="js/jquery.loadingModal.js"></script> -->
  


  
  <script>
        var muestraComparativas = false;
        var mostrarEnlaces = true;
        var isCourseLoading = false;
        var isFilterLoading = false;
        var trabajoPendiente = false;
        var currentTab = 1;
        var indicator;
        var item;
        var tituloPestana = "";
        var tabsCursos = [false, false, false];
        function cambiarpestana(id){
            if(id != currentTab){
                hidePage("ldm_tab_" + id);
                currentTab = id;
                tituloPestana = pestanas[id];
                setTimeout(function() {
                    obtenerInformacion();
                }, 500);
            }
        }
        pestanas = [
            '',
            'Programas de entrenamiento',
            'Lanzamientos y campañas',
            'Cruce de indicadores'
        ]
        document.addEventListener("DOMContentLoaded", function() {
                $('.course-selector').change(function(){obtenerInformacion()});
                tituloPestana = pestanas[1];
                // tituloPestana = $('#tab-selector').children('option:selected').html();
                // $('#tab-selector').change(function(){ tituloPestana = $(this).children('option:selected').html(); obtenerInformacion(); });
                obtenerInformacion();
                obtenerFiltros();
        });
        var dateBegining;
        var dateEnding;
        function quitarFiltros(){
            peticionFiltros({
                request_type: 'user_catalogues'
            });
            obtenerInformacion();
        }
        // function rehacerPeticion(){
        //     trabajoPendiente = true;
        //     setTimeout(function() {                
        //     }, 2000);
        // }
        // function reObtenerInformacion(){

        // }
        function obtenerInformacion(indicator){
            // if(isCourseLoading){
            //     console.log('Cargando contenido de cursos, no debe procesar más peticiones por el momento');
            //     return;
            // }
            // isCourseLoading = !isCourseLoading;
            // console.log("Obteniendo gráficas");
            informacion = $('#filter_form').serializeArray();
            informacion.push({name: 'request_type', value: 'course_list'});
            informacion.push({name: 'type', value: currentTab});
            dateBegining = Date.now();
            // $('#local_dominosdashboard_content').html('Cargando la información');
            $.ajax({
                type: "POST",
                url: "services.php",
                data: informacion,
                dataType: "json"
            })
            .done(function(data) {
                isCourseLoading = false;
                console.log('Data obtenida', data);
                respuesta = JSON.parse(JSON.stringify(data));
                respuesta = respuesta.data;
                console.log('Imprimiendo la respuesta', respuesta);
                dateEnding = Date.now();
                // $('#local_dominosdashboard_content').html('<pre>' + JSON.stringify(data, undefined, 2) + '</pre>');
                console.log(`Tiempo de respuesta de API al obtener json para listado de cursos ${dateEnding - dateBegining} ms`);
                render_div = "#ldm_tab_" + currentTab;
                var cosa = generarGraficasTodosLosCursos(render_div, respuesta, tituloPestana);
                setTimeout(function(){
                    if(cosa == true){
                        showPage("ldm_tab_" + currentTab);
                    }
                },1000)
                
                
            })
            .fail(function(error, error2) {
                isCourseLoading = false;
                console.log(error);
                console.log(error2);
            });
            if(indicator !== undefined){
                obtenerFiltros(indicator);
            }
        }

        
        
    </script>

</body>

</html>
