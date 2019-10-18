<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Plugin strings are defined here.
 *
 * @package     local_hoteles_city_dashboard
 * @category    dashboard
 * @copyright   2019 Subitus <contacto@subitus.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
$context_system = context_system::instance();
require_login();
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/custom_settings.php');
local_hoteles_city_dashboard_user_has_access();

global $DB;
$PAGE->set_url($CFG->wwwroot . "/local/hoteles_city_dashboard/administrar_regiones.php");
$settingsurl = $CFG->wwwroot . '/admin/settings.php?section=local_hoteles_city_dashboard';
$PAGE->set_context($context_system);
$PAGE->set_pagelayout('admin');
$pluginname = "local_hoteles_city_dashboard";
$PAGE->set_title(get_string('pluginname', $pluginname));
echo $OUTPUT->header();
// Institution -> hotel
// Department -> puesto
$catalogues = local_hoteles_city_dashboard_get_catalogues();
// _print('Catálogos devueltos', $catalogues);
// _log(compact('catalogues'));
$institutions = $catalogues['institution'];
$hasInstitutions = count($institutions) > 0;
// $regions = $catalogues['departments'];
$regions = local_hoteles_city_dashboard_get_regions();
$relationships = local_hoteles_city_dashboard_get_region_institution_relationships();
if (is_array($regions)) {
    $hasRegions = count($regions) > 0;
} else {
    $hasRegions = false;
}
$default_profile_fields = local_hoteles_city_dashboard_get_default_profile_fields(true);
$all_default_profile_fields = local_hoteles_city_dashboard_get_default_profile_fields();
$custom_fields = local_hoteles_city_dashboard_get_custom_profile_fields();
echo local_hoteles_city_dashboard_print_theme_variables();
$configs = get_config($pluginname);
$configs = (array) $configs;
$pluginname = "local_hoteles_city_dashboard";

$filter_settings = new filter_settings(null, compact('configs'), 'post', '', ' name="filter_settings" id="filter_settings" ');
$permission_settings = new permission_settings(null, compact('configs'), 'post', '', ' name="permission_settings" id="permission_settings" ');
$gerentes_generales = local_hoteles_city_dashboard_get_gerentes_generales(true);

?>
<link rel="stylesheet" href="estilos_city.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
<script src="bootstrap/bootstrap-multiselect.css"></script>
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link" id="regions-tab" data-toggle="tab" href="#regions-settings" role="tab" aria-controls="Regiones" aria-selected="true">Regiones</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="report-tab" data-toggle="tab" href="#permission_settings" role="tab" aria-controls="Reporte" aria-selected="false">Permisos del dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link show active" id="report-tab" data-toggle="tab" href="#filter-settings" role="tab" aria-controls="Reporte" aria-selected="true">Filtros</a>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link" id="theme-tab" data-toggle="tab" href="#theme-settings" role="tab" aria-controls="Tema" aria-selected="false">Colores del tema</a>
    </li> -->
</ul>
<div class="tab-content" id="settings_hoteles_city_dashboard">
    <div class="tab-pane fade" id="regions-settings" role="tabpanel" aria-labelledby="regions-tab">
        <div class="row" style="padding-bottom: 2%; padding-top: 2%;">
            <div class="col-sm-6" style="text-align: left;">
                <!-- <a class="btn Primary btn-lg" href="<?php echo $settingsurl; ?>">Configuraciones del plugin</a> -->
            </div>
            <div class="col-sm-6" style="text-align: right;">
                <button type="button" class="btn Primary btn-lg" data-toggle="modal" data-target="#addRegion">Agregar nueva región</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead>
                    <?php
                    if ($hasRegions) {
                        echo '<tr>';
                        echo '<td scope="col" class="text-center">Institución \ Región</th>';
                        foreach ($regions as $key => $region) {
                            $status = (!$region->active) ? "(Deshabilitada)" : "";
                            $class = (!$region->active) ? " gray-row " : "";
                            echo "<th scope=\"col\" class=\"text-center {$class}\"><button class='btn Info'
                            onclick='show_region({$region->id}, \"{$region->name}\", $region->active)'>
                            {$region->name} {$status}&nbsp;<i class='fas fa-edit'></i></button>
                            </th>";
                        }
                        echo "<th>Gerente</th>";
                        echo '</tr>';
                    }
                    ?>
                </thead>
                <tbody>
                    <?php
                    if ($hasInstitutions) {
                        foreach ($institutions as $institution) {
                            echo '<tr>';
                            echo "<td scope=\"col\" class=\"text-center\">{$institution}</td>";
                            $ins = local_hoteles_city_dashboard_slug($institution);
                            foreach ($regions as $region) {
                                $checked = "";
                                foreach ($relationships as $rel) {
                                    if (empty($checked)) {
                                        if ($rel->regionid == $region->id && $rel->institution == $institution) {
                                            $checked = "checked";
                                        }
                                    }
                                }
                                $class = (!$region->active) ? " gray-row " : "";
                                echo "<td class='{$class}'><input type='radio' {$checked} onclick='relateRegionInstitution(\"{$region->id}\", \"{$institution}\")' name='{$ins}'></td>";
                            }
                            // $select_inner = "";
                            $default = !empty($configs[$name]) ? $configs[$name] : "";
                            echo "<td><select class='form-control' id='manager_{$ins}' onchange=\"change_manager('manager_{$ins}')\">";
                            foreach($gerentes_generales as $id => $gg){
                                echo "<option value='{$id}'>{$gg}</option>";
                            }
                            echo "</select></td>";
                            // echo "<td class='manager_fillable' id='manager_fillable'></td>";
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane fade" id="permission_settings" role="tabpanel" aria-labelledby="permission_settings">
        <?php $permission_settings->display(); ?>
        <div class="row" style="text-align: right;">
            <div class="col-sm-9"><button onclick="saveAllChanges()" class="btn Primary">Guardar cambios</button></div>
        </div>
    </div>
    <div class="tab-pane fade" id="filter-settings" role="tabpanel" aria-labelledby="report-tab">
        <?php $filter_settings->display(); ?>
        <div class="row" style="text-align: right;">
            <div class="col-sm-9"><button onclick="saveAllChanges()" class="btn Primary">Guardar cambios</button></div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="sweetalert/sweetalert2.all.min.js"></script>
    <script src="bootstrap/bootstrap-multiselect.min.js"></script>
    <form id="hoteles_city_dashboard" name="hoteles_city_dashboard"></form>
    <div class="modal fade" id="addRegion" tabindex="-1" role="dialog" aria-labelledby="addRegionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRegionLabel">Agregar región</h5>
                </div>
                <div class="modal-body">
                    <!-- <form> -->
                    <div class="form-group">
                        <label for="region_name" class="col-form-label">Nombre de la región:</label>
                        <input type="text" class="form-control" id="region_name" name="region_name">
                    </div>
                    <!-- </form> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" onclick="createRegion()" class="btn Primary">Agregar región</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showRegion" tabindex="-1" role="dialog" aria-labelledby="showRegionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showRegionLabel"></h5>
                </div>
                <div class="modal-body">
                    <!-- <form> -->
                    <div class="form-group">
                        <label for="region_name_e" class="col-form-label">Actualizar nombre:</label>
                        <input type="text" class="form-control" id="region_name_e" name="region_name_e">
                        <br>
                        <p id="region-description"></p>
                    </div>
                    <!-- </form> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="delete_region()" data-dismiss="modal">Eliminar Región</button>
                    <button type="button" class="btn btn-secondary" onclick="disable_region()" id="change_region" data-dismiss="modal">Cancelar</button>
                    <button type="button" onclick="update_region()" class="btn Primary">Guardar los cambios</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var editing;
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        // $('#permission_settings').serializeArray();
        // $('#filter_settings').serializeArray();
        // $('#filter_settings, #permission_settings').serializeArray();
        document.addEventListener("DOMContentLoaded", function() {});
        $(document).ready(function() {
            setTimeout(function() {
                $('#regions-tab').click();
            }, 250);
            // $('.multiselect-setting').multiselect({
            //     templates: {
            //         li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
            //     }
            // });
            // $('.multiselect-setting').hide(); // Si no se oculta en bootstrap alpha 4
        });
        // document.addEventListener("DOMContentLoaded", function() {
        //     require(['jquery'], function ($) {
        function createRegion() {
            informacion = Array();
            name = $('#region_name').val();
            informacion.push({
                name: 'request_type',
                value: 'create_region'
            });
            informacion.push({
                name: 'name',
                value: name
            });
            $.ajax({
                    type: "POST",
                    url: "services.php",
                    data: informacion,
                    // dataType: "json"
                })
                .done(function(data) {
                    console.log('La información obtenida es: ', data);
                    // return;
                    if (data == 'ok') {
                        Swal.fire('Insertado con éxito');
                        // ocultarModal();
                    } else { // Se trata de un error
                        Swal.fire(data);
                    }
                    reloadPage();
                })
                .fail(function(error, error2) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Ocurrió un error al crear la región',
                        footer: 'Por favor, inténtelo de nuevo'
                    });
                    console.log(error, error2);
                });
        }

        function show_region(id, name, enabled) {
            editing = id;
            regionid = id;
            $('#showRegionLabel').html(name);
            if (enabled == 1) {
                $('#change_region').html('Deshabilitar región');
            } else {
                $('#change_region').html('Habilitar región');
            }
            $('#region_name_e').val(name);

            informacion = Array();
            informacion.push({
                name: 'request_type',
                value: 'get_region_institutions'
            });
            informacion.push({
                name: 'region',
                value: regionid
            });

            $.ajax({
                    type: "POST",
                    url: "services.php",
                    data: informacion,
                })
                .done(function(data) {
                    console.log('show_region La información obtenida es: ', data);
                    $('#region-description').html('Hoteles disponibles: ' + data);
                })
                .fail(function(error, error2) {
                    $('#region-description').html('Hoteles disponibles: ');
                    console.log('show_region Errores', error, error2);
                });

            $('#showRegion').modal();
        }

        function disable_region() {
            regionid = editing;
            name = $('#region_name_e').val();
            if (name == '') {
                Swal.fire('Por favor ingrese un nombre');
            }
            informacion = Array();
            informacion.push({
                name: 'request_type',
                value: 'update_region'
            });
            informacion.push({
                name: 'id',
                value: regionid
            });
            informacion.push({
                name: 'name',
                value: name
            });
            informacion.push({
                name: 'change_status',
                value: 1
            });

            $.ajax({
                    type: "POST",
                    url: "services.php",
                    data: informacion,
                    // dataType: "json"
                })
                .done(function(data) {
                    console.log('La información obtenida es: ', data);
                    // return;
                    if (data == 'ok') {
                        Swal.fire('Región deshabilitada correctamente');
                        // ocultarModal();
                    } else { // Se trata de un error
                        Swal.fire(data);
                    }
                    reloadPage();
                })
                .fail(function(error, error2) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Ocurrió un error al crear la región',
                        footer: 'Por favor, inténtelo de nuevo'
                    });
                    console.log(error, error2);
                });
        }

        function update_region() {
            regionid = editing;
            informacion = Array();
            name = $('#region_name_e').val();
            informacion.push({
                name: 'request_type',
                value: 'update_region'
            });
            informacion.push({
                name: 'id',
                value: regionid
            });
            informacion.push({
                name: 'name',
                value: name
            });

            $.ajax({
                    type: "POST",
                    url: "services.php",
                    data: informacion,
                    // dataType: "json"
                })
                .done(function(data) {
                    console.log('La información obtenida es: ', data);
                    // return;
                    if (data == 'ok') {
                        Swal.fire('Región editada correctamente');
                        // ocultarModal();
                    } else { // Se trata de un error
                        Swal.fire(data);
                    }
                    reloadPage();
                })
                .fail(function(error, error2) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Ocurrió un error al crear la región',
                        footer: 'Por favor, inténtelo de nuevo'
                    });
                    console.log(error, error2);
                    // alert(data, 'error');
                    // alert('Por favor, inténtelo de nuevo');
                    // ocultarModal();
                });
        }

        function delete_region() {
            regionid = editing;
            Swal.fire({
                title: '¿Está seguro de eliminar esta región?',
                text: "Después de eliminar esta región no se podrán recuperar los datos",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Lo entiendo, eliminar',
                cancelButtonText: 'Cancelar',
            }).then(function(result) {
                if (result.value) {
                    informacion = Array();
                    name = $('#region_name').val();
                    informacion.push({
                        name: 'request_type',
                        value: 'update_region'
                    });
                    informacion.push({
                        name: 'id',
                        value: regionid
                    });
                    informacion.push({
                        name: 'delete',
                        value: 1
                    });
                    $.ajax({
                            type: "POST",
                            url: "services.php",
                            data: informacion,
                            // dataType: "json"
                        })
                        .done(function(data) {
                            console.log('La información obtenida es: ', data);
                            // return;
                            if (data == 'ok') {
                                // Swal.fire('Guardado');
                                Swal.fire({
                                    position: 'bottom-end',
                                    type: 'success',
                                    title: 'Eliminado correctamente',
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                                // ocultarModal();
                            } else { // Se trata de un error
                                Swal.fire(data);
                            }
                            reloadPage();
                        })
                        .fail(function(error, error2) {
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Ocurrió un error al eliminar esta región',
                                footer: 'Por favor, inténtelo de nuevo'
                            });
                            console.log(error, error2);
                        });
                }
            });
        }

        function relateRegionInstitution(regionid, institution) {
            informacion = Array();
            informacion.push({
                name: 'request_type',
                value: 'relate_region_institution'
            });
            informacion.push({
                name: 'id',
                value: regionid
            });
            informacion.push({
                name: 'institution',
                value: institution
            });
            $.ajax({
                    type: "POST",
                    url: "services.php",
                    data: informacion,
                    // dataType: "json"
                })
                .done(function(data) {
                    console.log('La información obtenida es: ', data);
                    // return;
                    if (data == 'ok') {
                        // Swal.fire('Guardado');
                        Toast.fire({
                            type: 'success',
                            title: 'Guardado correctamente'
                        });
                        // Swal.fire({
                        //     position: 'bottom-end',
                        //     type: 'success',
                        //     title: 'Guardado correctamente',
                        //     showConfirmButton: false,
                        //     timer: 1000
                        // });
                    } else { // Se trata de un error
                        Toast.fire({
                            type: 'warning',
                            title: 'Signed in successfully'
                        })
                    }
                })
                .fail(function(error, error2) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Ocurrió un error al crear la región',
                        footer: 'Por favor, inténtelo de nuevo'
                    });
                    console.log(error, error2);
                    // alert(data, 'error');
                    // alert('Por favor, inténtelo de nuevo');
                    // ocultarModal();
                });
        }

        function reloadPage() {
            setTimeout(function() {
                window.location.href = window.location.href;
            }, 1000);
        }

        var informacion;

        function saveAllChanges() {
            informacion = $('#filter_settings, #permission_settings').serializeArray();
            informacion.push({ name: 'request_type', value: 'save_settings' });
            console.log(informacion);
            $.ajax({
                    type: "POST",
                    url: "services.php",
                    data: informacion,
                })
                .done(function(data) {
                    Swal.fire('Cambios guardados correctamente');
                    // console.log('La información obtenida es: ', data);
                })
                .fail(function(error, error2) {
                    Swal.fire('Hubo un error, recargue la página e intente de nuevo');
                    console.log(error, error2);
                });
        }
        //     });
        // });
    </script>
<?php
echo $OUTPUT->footer();
