# Dashboard administrativo Hoteles City #

TODO Describe the plugin shortly here.

TODO Provide more detailed description here.

## License ##

2019 Subitus <contacto@subitus.com>

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <http://www.gnu.org/licenses/>.

-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*dashboard.php*
- El div (col-sm-12) para las 4 cards informativas tiene un id="cards informativas", la información de cada card es la siguiente: 
    + No. de hoteles: id="card_numero_hoteles" (col-sm-3)
    + Cantidad de usuarios: id="card_cantidad_usarios" (col-sm-3)
    + Aprobados: id="card_aprobados" (col-sm-3)
    + No aprobados: id="card_no_aprobados" (col-sm-3)

- El div para que se pinten las cards con gráfica tiene un id="contenedor_graficas" (col-sm-12).

*reporte_tabla*
- El div (col-sm-12) para que imprima la gráfica tiene un id="graph_data_table".

- El div (col-sm-12) para imprimir la tabla tiene un id id="table_informacion".

*Otra información*
- Clasificación de gráficas:
    - Comparativa: bar-agrupadas, line, horizontalBar, burbuja
    - Individual: pie, bar

- Tipo de gráfica (clave chart):
    - bar-agrupadas
    - horizontalBar
    - pie
    - line
    - bar
    - burbuja






