// class Usuario{
//     constructor(nombre, edad, correo){
//         this.nombre = nombre,
//         this.edad = edad,
//         this.correo = correo       
//     }

//     mostrarSaludo(mensaje){
//         return mensaje;
//     }

//     mostrarInfo(){
//         return `
//             <b>Nombre:</b> ${this.nombre} <br />
//             <b>Edad:</b> ${this.edad} <br />
//             <b>Correo:</b> ${this.correo} <br />
//             <hr />
//         `;
//     }
// }

// const isay = new Usuario('Isay', 23, 'correo@correo.com');
// document.getElementById("demo").innerHTML = isay.mostrarInfo();

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function regresaInfo(){
    //showModal();
    //informacion = $('#filter_form').serializeArray();
    informacion = [];
            informacion.push({name: 'request_type', value: 'course_list'});
            //informacion.push({name: 'type', value: currentTab});
            //dateBegining = Date.now();
            // $('#local_dominosdashboard_content').html('Cargando la información');
            $.ajax({
                type: "POST",
                url: "services.php",
                data: informacion,
                dataType: "json"
            })
            .done(function(data) {
                console.log('Aqui entra done');
                isCourseLoading = false;
                //console.log('Data obtenida ' + data);
                respuesta = JSON.parse(JSON.stringify(data));
                respuesta = respuesta.data;
                console.log('Imprimiendo la respuesta', respuesta);
                
                // var arr_data = Array();
                // var labels_graph = Array();
                // var info_graph = Array();                
                for (var i = 0; i < respuesta.result.length; i++) {
                    resp = respuesta.result[i];
                    // info_graph.push(resp.approved_users);
                    // info_graph.push(resp.not_approved_users);
                    // labels_graph.push("Aprobados");
                    // labels_graph.push("No aprobados");
                    // arr_data.push(info_graph);
                    // arr_data.push(labels_graph);
                    var curso = new GraphicsDashboard('contenedor',resp.title, 'pie',resp,5);                    
                    curso.printCard();
                    curso.infoGraph();
                }
                
                
                // var hotel = new GraphicsDashboard('contenedor', resp.title,'bar', '', 5);
                // hotel.printCard();
                // hotel.infoGraph();
                
                // dateEnding = Date.now();
                // // $('#local_dominosdashboard_content').html('<pre>' + JSON.stringify(data, undefined, 2) + '</pre>');
                // console.log(`Tiempo de respuesta de API al obtener json para listado de cursos ${dateEnding - dateBegining} ms`);
                // render_div = "#ldm_tab_" + currentTab;
                // var cosa = generarGraficasTodosLosCursos(render_div, respuesta, tituloPestana);
                // setTimeout(function(){
                //     if(cosa == true){
                //         showPage("ldm_tab_" + currentTab);
                //     }
                // },1000)
                //var card= new PintarCard();
                //showPage("graficas");             
               
                
                
            })
            .fail(function(error, error2) {
                isCourseLoading = false;
                console.log('Entra a fail');
                console.log(error);
                console.log(error2);
            });
            // if(indicator !== undefined){
            //     obtenerFiltros(indicator);
            // }
}

// Modal


// function showModal() {   
//     $('#modal_loader').modal('show');
// }

// function showPage(id_div) {
//   document.getElementById("modal").style.display = "none";
//   //document.getElementById(id_div).style.display = "block";
// }


class GraphicsDashboard{
    constructor(div_print_card, title, type_graph, data_graph, col_size_graph){
        this.div_print_card = div_print_card, // Div padre
        this.title = title, //Título de la gráfica        
        this.div_graph = div_print_card + Date.now(); //Div donde se imprime la card con la gráfica
        this.type_graph = type_graph, // Tipo de gráfica
        this.data_graph = data_graph, //Datos de la gráfica
        this.col_size_graph = col_size_graph //Tamaño de la col donde se imprime la card
    }    
    
    

    printCard(){  
        
        if(this.data_graph.enrolled_users >0){
        
        $("#"+this.div_print_card).append(`
                <div class="col-sm-${this.col_size_graph}">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><a href="seccion_regionales_iframe.php">${this.title}</a></h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="">                  
                            <canvas id="${this.div_graph}"></canvas>                  
                        </div>
                    </div>    
                </div>
        </div>        
        `);
        }
        else{
            $("#"+this.div_print_card).append(`
            <div class="col-sm-${this.col_size_graph}">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><a href="seccion_regionales_iframe.php">${this.title}</a></h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="">                  
                        <h3 id="${this.div_graph}"></h3>                  
                    </div>
                </div>    
            </div>
    </div>        
    `);  
        }   
        console.log('PRINT CARD');    
        
    }    

    infoGraph(){
        console.log('INFO GRAPH') 
        switch (this.type_graph) {
            case 'bar-agrupadas':
                    var ctx = document.getElementById(this.div_graph);
                    var chart = new Chart(ctx, {
                        // The type of chart we want to create
                        type: 'bar',
                    
                        // The data for our dataset
                        data: {
                        labels: ['Centro', 'Suites', 'Plus', 'Express', 'Junior', 'OC'],
                        datasets: [{
                            label: 'Aprobados',
                            backgroundColor: '#1cc88a',       
                            data: [15, 40, 30, 26, 12, 34, 0],
                        },{
                            label: 'No Aprobados',
                            backgroundColor: '#e74a3b',       
                            data: [5, 45, 26, 31, 41, 10, 0],
                        }]
                        },
                    
                        // Configuration options go here
                        options: {
                        
                        }
                    });
                
                break;
                
            case 'horizontalBar':
                    var ctx = document.getElementById(this.div_graph);
                    var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'horizontalBar',
                
                    // The data for our dataset
                    data: {
                        labels: ['EVD', 'JVD', 'GV', 'ALL', 'CA', 'JM', 'CO', 'CXC'],
                        datasets: [{
                            label: 'A',            
                            //borderColor: 'rgb(255, 99, 132)',
                            data: [15, 40, 12, 30, 26, 50, 1, 9, 0],
                        }]
                    },
                
                    // Configuration options go here
                    options: {
                        legend: { display: false },
                    }
                    });                  
                    
                break;

            case 'pie':
                    var d_graph = Array();
                    d_graph.push(this.data_graph.approved_users);
                    d_graph.push(this.data_graph.not_approved_users); 
                    if(this.data_graph.enrolled_users >0){
                    var ctx = document.getElementById(this.div_graph);
                    var chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ["Aprobado", "No Aprobados"],
                        datasets: [{
                            label: "Population (millions)",
                            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                            data: d_graph
                          }]
                        },
                        options: {      
                        }
                        });
                    }
                    else{
                        var ctx = document.getElementById(this.div_graph)
                        ctx.innerHTML="No existen usuarios inscritos";
                    } 
                                                          
                    
                break;
                
            case 'line': //Tendencia
                    var ctx = document.getElementById(this.div_graph);
                    var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'line',
                
                    // The data for our dataset
                    data: {
                    labels: ['Variable 1', 'Variable 2', 'Variable 3', 'Variable 4', 'Variable 5', 'Variable 6'],
                    datasets: [{
                        label: 'A',
                        borderColor: "#3e95cd",
                        backgroundColor: 'transparent',       
                        data: [15, 40, 30, 26, 12, 34, 0],
                    },{
                        label: 'B',
                        borderColor: "#8e5ea2",
                        backgroundColor: 'transparent',       
                        data: [5, 45, 26, 31, 41, 10, 0],
                    }]
                    },
                
                    // Configuration options go here
                    options: {
                    
                    }
                    });                                     
                        
                break;

            case 'bar':
                    var d_graph = Array();
                    d_graph.push(this.data_graph.approved_users);
                    d_graph.push(this.data_graph.not_approved_users);
                    var ctx = document.getElementById(this.div_graph);
                    var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'bar',
                    data: {
                    labels: ["Aprobados","No aprobados"],
                    datasets: [{
                        backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                        data: d_graph
                    }]
                    },
                    options: {
                        legend: { display: false }                   
                    }
                    });                                     
                    
                break;
                
            case 'burbuja': 
            console.log('DIV GRAF');
            console.log(this.div_graph);
                    var ctx = document.getElementById(this.div_graph);
                    var chart = new Chart(ctx, {
                        type: 'bubble',
                        data: {
                        labels: "Africa",
                        datasets: [
                            {
                            label: ["Hotel 1"],
                            backgroundColor: "rgba(255,221,50,0.2)",
                            borderColor: "rgba(255,221,50,1)",
                            data: [{
                                x: 212,//inscritos
                                y: 207,//aprobados
                                r: 5//no aprobados
                            }]
                            }, {
                            label: ["Hotel 2"],
                            backgroundColor: "rgba(60,186,159,0.2)",
                            borderColor: "rgba(60,186,159,1)",
                            data: [{
                                x: 258702,
                                y: 7.526,
                                r: 10
                            }]
                            }, {
                            label: ["Hotel 3"],
                            backgroundColor: "rgba(0,0,0,0.2)",
                            borderColor: "#000",
                            data: [{
                                x: 3979083,
                                y: 6.994,
                                r: 15
                            }]
                            }
                        ]
                        },
                        options: {
                        title: {
                            display: true,
                            text: 'Predicted world population (millions) in 2050'
                        }, scales: {
                            yAxes: [{ 
                            scaleLabel: {
                                display: true,
                                labelString: "Happiness"
                            }
                            }],
                            xAxes: [{ 
                            scaleLabel: {
                                display: true,
                                labelString: "GDP (PPP)"
                            }
                            }]
                        }
                        }
                        });                                                  
                
                break;
                

                
                
        
            default:
                break;
        }
        
    }    
}




 



//document.getElementById("card").innerHTML = hotel.printCard();







