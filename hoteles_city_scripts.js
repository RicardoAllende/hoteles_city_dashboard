
//Funcion para imprimir graficas en reportes
// function imprimir_graficas_reportes(div){
//     //div_selector = '#grafica_reportes';
//     $(div).append(`
//     <div class='card bg-gray border-0 m-2'>
//                 <div class='align-items-end'>
//                     <div class='fincard titulo_grafica'>
//                         <a class="color_titulo_grafica" href='#' id=''>Reporte</a>
//                     </div>
//                 </div>                    
//                 <div class='m-2' id='chart2'>
//                     <canvas id="myChart"></canvas>
//                 </div>                                     
//     </div> 
//     `);
//     var ctx = document.getElementById('myChart');
//     var chart = new Chart(ctx, {
//     // The type of chart we want to create
//     type: 'line',

//     // The data for our dataset
//     data: {
//         labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
//         datasets: [{
//             label: 'Curso',           
//             backgroundColor: 'transparent',
//             borderColor: 'rgb(255, 99, 132)',
//             data: [0, 10, 5, 2, 20, 30, 45],
//         },{
//             label: 'Line Dataset',
//             data: [5, 25, 15, 50],
//             backgroundColor: 'transparent',
//         }
//         ]
//     },

//     // Configuration options go here
//     options: {
//         title: {
//             display: true,
//             text: 'Custom Chart Title'
//         }
//     }
//     });
// }

