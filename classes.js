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

class PintarCard{
    constructor(card, titulo, tipo_grafica, data, col){
        this.card = card, // Div padre
        this.titulo = titulo, //Título de la gráfica        
        this.div_graf = card + Date.now(); //Div donde se imprime la card con la gráfica
        this.tipo_grafica = tipo_grafica, // Tipo de gráfica
        this.data = data, //Datos de la gráfica
        this.col = col //Tamaño de la col donde se imprime la card
    }    
    
    imprimirDiv(){
        document.write(`<div class="col-sm-12" id="${this.card}"></div>`);
       
    }

    imprimirCard(){        
        
        $(this.card).append(`
                <div class="col-sm-${this.col}">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><a href="seccion_regionales_iframe.php">${this.titulo}</a></h6>
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
                            <canvas id="${this.div_graf}"></canvas>                  
                        </div>
                    </div>    
                </div>
        </div>        
        `);        
        
    }    

    infoGrafica(){
        switch (this.tipo_grafica) {
            case 'bar-agrupadas':
                    var ctx = document.getElementById(this.div_graf);
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
                    var ctx = document.getElementById(this.div_graf);
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
                    var ctx = document.getElementById(this.div_graf);
                    var chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ["Variable 1", "Variable 2", "Variable 3"],
                        datasets: [{
                            label: "Population (millions)",
                            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                            data: [2478,5267,734]
                          }]
                        },
                        options: {      
                        }
                        });                                      
                    
                break;
                
            case 'line': //Tendencia
                    var ctx = document.getElementById(this.div_graf);
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
                    var ctx = document.getElementById(this.div_graf);
                    var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'bar',
                    data: {
                    labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
                    datasets: [{
                        backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                        data: [2478,5267,734,784,433]
                    }]
                    },
                    options: {
                        legend: { display: false }                   
                    }
                    });                                     
                    
                break;
                
            case 'burbuja': 
                    var ctx = document.getElementById(this.div_graf);
                    var chart = new Chart(ctx, {
                        type: 'bubble',
                        data: {
                        labels: "Africa",
                        datasets: [
                            {
                            label: ["China"],
                            backgroundColor: "rgba(255,221,50,0.2)",
                            borderColor: "rgba(255,221,50,1)",
                            data: [{
                                x: 21269017,
                                y: 5.245,
                                r: 15
                            }]
                            }, {
                            label: ["Denmark"],
                            backgroundColor: "rgba(60,186,159,0.2)",
                            borderColor: "rgba(60,186,159,1)",
                            data: [{
                                x: 258702,
                                y: 7.526,
                                r: 10
                            }]
                            }, {
                            label: ["Germany"],
                            backgroundColor: "rgba(0,0,0,0.2)",
                            borderColor: "#000",
                            data: [{
                                x: 3979083,
                                y: 6.994,
                                r: 15
                            }]
                            }, {
                            label: ["Japan"],
                            backgroundColor: "rgba(193,46,12,0.2)",
                            borderColor: "rgba(193,46,12,1)",
                            data: [{
                                x: 4931877,
                                y: 5.921,
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

var hotel = new PintarCard('#bloque_cards','Avance global de capacitación','burbuja', '', 5);
hotel.imprimirDiv();
hotel.imprimirCard();
hotel.infoGrafica();

 


//document.getElementById("card").innerHTML = hotel.txtdiv();
//document.getElementById("card").innerHTML = hotel.imprimirCard();







