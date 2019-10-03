<?php


// function local_hoteles_city_dashboard_get_categories(){
//     global $DB;
//     $categories = $DB->get_records_sql('SELECT id, name, path FROM {course_categories}');
//     if($categories == false){
//         return [];
//     }
//     $cats = array();
//     foreach($categories as $category){
//         $cats[$category->id] = $category->name;
//     }
//     return $cats;
// }

// function local_hoteles_city_dashboard_get_categories_with_subcategories(int $category_id, bool $returnAsArray = true/*, string $path, array $categories*/){
//     global $DB;
//     $category = $DB->get_record('course_categories', array('id' => $category_id));
//     $categories = array();
//     if($category){
//         $query = "SELECT id FROM {course_categories} WHERE path LIKE '{$category->path}%' AND id != {$category_id}";
//         array_push($categories, $category_id);
//         foreach($DB->get_records_sql($query) as $subc){
//             array_push($categories, $subc->id);
//         }
//     }
//     if($returnAsArray){
//         return $categories;
//     }else{
//         return implode(",", $categories);
//     }
// }

// function local_hoteles_city_dashboard_get_category_parent(){
//     if($data = get_config('local_hoteles_city_dashboard', LOCAL_HOTELES_CITY_DASHBOARD_CATEGORY_PARENT_NAME)){
//         return $data;
//     }else{
//         return 1; // Miscelaneous
//     }
// }

// /**
//  * @param int $badge_status Badge status: 0 = inactive, 1 = active, 2 = active+locked, 3 = inactive+locked, 4 = archived, -1 = all badge status
//  */
// function local_hoteles_city_dashboard_get_badges(int $badge_status = -1){
//     if(!is_int($badge_status)){
//         $status = -1;
//     }
//     global $DB;
//     if($badge_status != -1){
//         return $DB->get_records_menu('badge', array('status' => $badge_status), '', 'id,name');
//     }
//     return $DB->get_records_menu('badge', array(), '', 'id,name');
// }

// function local_hoteles_city_dashboard_get_activities(int $courseid, string $andwhere = ""){
//     global $DB;
//     $actividades = array();
//     $query  = "SELECT id, CASE ";
//     $tiposDeModulos = $DB->get_records('modules', array('visible' => 1), 'id,name');
//     foreach ($tiposDeModulos as $modulo) {
//         $nombre  = $modulo->name;
//         $alias = 'a'.$modulo->id;
//         $query .= ' WHEN cm.module = '.$modulo->id.' THEN (SELECT '.$alias.'.name FROM {'.$nombre.'} '.$alias.' WHERE '.$alias.'.id = cm.instance) ';
//     }
//     $query .= " END AS name
//     from {course_modules} cm
//     where course = {$courseid} {$andwhere} ";
//     return $DB->get_records_sql_menu($query);
// }

// function local_hoteles_city_dashboard_get_activities_completion(int $courseid, string $userids, string $fecha_inicial, string $fecha_final){

//     $activities = array();
//     if(empty($userids)){
//         return $activities;
//     }
//     global $DB;
//     $courseactivities = local_hoteles_city_dashboard_get_activities($courseid, " AND completion != 0 ");
//     foreach($courseactivities as $key => $activity){
//         $activityInformation = local_hoteles_city_dashboard_get_activity_completions($activityid = $key, $userids, $title = $activity, $fecha_inicial, $fecha_final);
//         array_push($activities, $activityInformation);
//     }
//     usort($activities, function ($a, $b) {return $a['completed'] < $b['completed'];});
//     return $activities;
// }

// function local_hoteles_city_dashboard_get_activity_completions(int $activityid, string $userids = "", $title = "", string $fecha_inicial, string $fecha_final){
//     $campo_fecha = "timemodified";
//     $filtro_fecha = "";
//     $filtro_fecha = local_hoteles_city_dashboard_create_sql_dates($campo_fecha, $fecha_inicial, $fecha_final);
//     global $DB;
//     $key = "module" . $activityid;
//     // $inProgress         = $DB->count_records_sql("SELECT count(*) FROM {course_modules_completion} WHERE coursemoduleid = {$activityid} AND userid IN ({$userids}) AND completionstate = 0");
//     $completed          = $DB->count_records_sql("SELECT count(*) FROM {course_modules_completion} WHERE coursemoduleid = {$activityid} AND userid IN ({$userids}) AND completionstate IN (1,2) {$filtro_fecha}");
//     // $completedWithFail  = $DB->count_records_sql("SELECT count(*) FROM {course_modules_completion} WHERE coursemoduleid = {$activityid} AND userid IN ({$userids}) AND completionstate = 3");
//     return compact('key', 'title', 'inProgress', 'completed', 'completedWithFail');
// }

// function local_hoteles_city_dashboard_get_competencies($conditions = array()){
//     global $DB;
//     return $DB->get_records('competency', $conditions);
// }

// function local_hoteles_city_dashboard_get_user_competencies($userid){
//     global $DB;
//     $sql = "SELECT c.*
//                 FROM {competency_usercomp} uc
//                 JOIN {competency} c
//                 ON c.id = uc.competencyid
//                 WHERE uc.userid = ?";
//     return $DB->get_records_sql($sql, array($userid));
// }

// function local_hoteles_city_dashboard_get_all_user_competencies(array $conditions = array()){
//     global $DB;
//     $competencies = $DB->get_records('competency', array(), '', 'id, shortname, shortname as title');
//     foreach($competencies as $competency){
//         $competency->proficiency = $DB->count_records('competency_usercomp', array('competencyid' => $competency->id, 'proficiency' => 1));
//     }
//     usort($competencies, function($a, $b){
//         return $a->proficiency - $b->proficiency;
//     });
//     return $competencies;
// }

// function local_hoteles_city_dashboard_get_last_month_key(array $columns){
//     $meses = "12_DICIEMBRE,11_NOVIEMBRE,10_OCTUBRE,9_SEPTIEMBRE,8_AGOSTO,7_JULIO,6_JUNIO,5_MAYO,4_ABRIL,3_MARZO,2_FEBRERO,1_ENERO";
//     $meses = explode(',', $meses);
//     foreach($meses as $mes){
//         $search = array_search($mes, $columns);
//         if($search !== false){
//             // _log("El índice retornado es: ", $search);
//             return $search;
//         }
//     }
//     return -1; // it will throw an error
// }

// function local_hoteles_city_dashboard_get_last_month_name(array $columns){
//     $meses = "12_DICIEMBRE,11_NOVIEMBRE,10_OCTUBRE,9_SEPTIEMBRE,8_AGOSTO,7_JULIO,6_JUNIO,5_MAYO,4_ABRIL,3_MARZO,2_FEBRERO,1_ENERO";
//     $meses = explode(',', $meses);
//     foreach($meses as $mes){
//         $search = array_search($mes, $columns);
//         if($search !== false){
//             // _log("El índice retornado es: ", $search);
//             return $mes;
//         }
//     }
//     return -1; // it will throw an error
// }

// function local_hoteles_city_dashboard_convert_month_name(string $monthName){
//     $parts = explode('_', $monthName);
//     return $parts[0];
// }

// function local_hoteles_city_dashboard_format_month_from_kpi($m){
//     if(empty($m)){
//         return "";
//     }
//     if(is_int($m)){
//         if($m <= 13){ // de 1 a 12
//             return $m;
//         }
//     }
//     if(is_string($m)){
//         $m = strtoupper($m);
//         $meses = [
//             1 => 'ENERO',
//             2 => 'FEBRERO',
//             3 => 'MARZO',
//             4 => 'ABRIL',
//             5 => 'MAYO',
//             6 => 'JUNIO',
//             7 => 'JULIO',
//             8 => 'AGOSTO',
//             9 => 'SEPTIEMBRE',
//             10 => 'OCTUBRE',
//             11 => 'NOVIEMBRE',
//             12 => 'DICIEMBRE',
//         ];
//         $busqueda = array_search($m, $meses);
//         if($busqueda !== false){
//             return $busqueda;
//         }
//         $meses = [
//             1 => 'ENE',
//             2 => 'FEB',
//             3 => 'MAR',
//             4 => 'ABR',
//             5 => 'MAY',
//             6 => 'JUN',
//             7 => 'JUL',
//             8 => 'AGO',
//             9 => 'SEP',
//             10 => 'OCT',
//             11 => 'NOV',
//             12 => 'DIC',
//         ];
//         $busqueda = array_search($m, $meses);
//         if($busqueda !== false){
//             return $busqueda;
//         }
//     }
//     return $m;
// }


// function local_hoteles_city_dashboard_get_gradable_items(int $courseid, int $hidden = 0){
//     if($hidden != 1 || $hidden != 0){
//         $hidden = 0;
//     }
//     global $DB;
//     return $DB->get_records_menu('grade_items', array('courseid' => $courseid, 'itemtype' => 'mod', 'hidden' => $hidden), '', 'id,itemname');
// }

// // function local_hoteles_city_dashboard_(){
    
// // }

// function local_hoteles_city_dashboard_get_indicators(string $from = ''){
//     $indicators = explode('/', LOCAL_HOTELES_CITY_DASHBOARD_INDICATORS);
//     if(!empty($from)){
//         $exists = array_search($from, $indicators);
//         if($exists !== false){
//             $exists++;
//             $filter = array();
//             for ($i=$exists; $i < count($indicators); $i++) { 
//                 array_push($filter, $indicators[$i]);
//             }
//             $indicators = $filter;
//         }
//     }
//     return $indicators;
// }

// function local_hoteles_city_dashboard_get_kpi_indicators(string $from = ''){
//     $indicators = explode('/', LOCAL_HOTELES_CITY_DASHBOARD_INDICATORS_FOR_KPIS);
//     if(!empty($from)){
//         $exists = array_search($from, $indicators);
//         if($exists !== false){
//             $exists++;
//             $filter = array();
//             for ($i=$exists; $i < count($indicators); $i++) { 
//                 array_push($filter, $indicators[$i]);
//             }
//             $indicators = $filter;
//         }
//     }
//     return $indicators;
// }

// function local_hoteles_city_dashboard_get_charts(){
//     return LOCAL_HOTELES_CITY_DASHBOARD_CHARTS;
// }


// function local_hoteles_city_dashboard_get_course_grade_item_id(int $courseid){
//     global $DB;
//     return $DB->get_field('grade_items', 'id', array('courseid' => $courseid, 'itemtype' => 'course'));
// }

// function local_hoteles_city_dashboard_get_selected_params(array $params){
//     $result = array();
//     if(!empty($params)){
//         $indicators = local_hoteles_city_dashboard_get_indicators();
//         foreach($params as $key => $param){
//             if(array_search($key, $indicators) !== false){
//                 $filter = array();

//                 $data = $params[$key];
//                 if(is_string($data) || is_numeric($data)){
//                     array_push($filter, $data);
//                 }elseif(is_array($data)){
//                     foreach ($data as $d) {
//                         array_push($filter, $d);
//                     }
//                 }

//                 if(!empty($filter)){
//                     $result[$key] = implode(', ', $filter);
//                 }
//             }
//         }

//         $fecha_inicial = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_inicial');
//         if(!empty($fecha_inicial)){
//             $result['fecha_inicial'] = $fecha_inicial;
//         }

//         $fecha_final = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_final');
//         if(!empty($fecha_final)){
//             $result['fecha_final'] = $fecha_final;
//         }
//     }
//     return $result;
// }


// function local_hoteles_city_dashboard_get_time_from_month_and_year(int $month, int $year){
//     $date = new DateTime("{$year}-{$month}-02");
//     return $date->format('U');
// }

// function local_hoteles_city_dashboard_get_ideales_as_js_script(){
//     $ideal_cobertura = get_config('local_hoteles_city_dashboard', 'ideal_cobertura');
//     if($ideal_cobertura === false){
//         $ideal_cobertura = 94;
//     }
//     $ideal_rotacion  = get_config('local_hoteles_city_dashboard', 'ideal_rotacion');
//     if($ideal_rotacion === false){
//         $ideal_rotacion = 85;
//     }
//     return "<script> var ideal_cobertura = {$ideal_cobertura}; var ideal_rotacion = {$ideal_rotacion}; </script>";
// }


// function local_hoteles_city_dashboard_get_courses_with_filter(bool $allCourses = false, int $type){
//     $LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS = get_config('local_hoteles_city_dashboard', 'LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS');
//     if($LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS === false && $LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS == ''){
//         $LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS = "";
//     }
//     switch ($type) {
//         case LOCAL_HOTELES_CITY_DASHBOARD_AVAILABLE_COURSES:
//             return local_hoteles_city_dashboard_get_courses($allCourses);
//             break;
//         case LOCAL_HOTELES_CITY_DASHBOARD_PROGRAMAS_ENTRENAMIENTO: // Cursos en línea
//         # not in
//             // $LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS = get_config('local_hoteles_city_dashboard', 'LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS');
//             if($LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS != ""){
//                 $where = " AND id NOT IN ({$LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS}) ";
//             }else{
//                 $where = "";
//             }
//             return local_hoteles_city_dashboard_get_courses($allCourses, $where);
//             break;
        
//         case LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS: // Cursos presenciales
//         # where id in
//             // $LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS = get_config('local_hoteles_city_dashboard', 'LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS');
//             if($LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS != ""){
//                 $where = " AND id IN ({$LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS}) ";
//             }else{
//                 return array();
//                 $where = "";
//             }
//             return local_hoteles_city_dashboard_get_courses($allCourses, $where);
//             break;
        
//         case LOCAL_HOTELES_CITY_DASHBOARD_COURSE_KPI_COMPARATIVE: // Cruce de kpis LOCAL_HOTELES_CITY_KPI_NA
//             $kpis = local_hoteles_city_dashboard_get_KPIS();
//             $wherecourseidin = array();

//             foreach($kpis as $key => $kpi){
//                 $name = 'kpi_' . $key;
//                 if( $config = get_config('local_hoteles_city_dashboard', $name)){
//                     array_push($wherecourseidin, $config);
//                 }
//                 // $title = get_string('kpi_relation', $ldm_pluginname) . ': ' . $kpi;
//                 // $description = get_string('kpi_relation' . '_desc', $ldm_pluginname);        
//                 // $setting = new admin_setting_configmultiselect($name, $title, $description, array(), $courses_min);
//                 // $page->add($setting);
//             }
//             if(!empty($wherecourseidin)){
//                 $wherecourseidin = array_unique($wherecourseidin);
//                 $wherecourseidin = implode(',', $wherecourseidin);
//                 $where = " AND id IN ({$wherecourseidin}) ";
//                 return local_hoteles_city_dashboard_get_courses($allCourses, $where);
//             }
//             return array();

//             return array_filter(local_hoteles_city_dashboard_get_courses($allCourses), function ($element){
//                 $config = get_config('local_hoteles_city_dashboard', 'course_kpi_' . $element->id);
//                 $result = ($config !== false && $config != LOCAL_HOTELES_CITY_KPI_NA);
//                 return $result;
//             });
//             break;
        
//         default:
//             return array();
//             break;
//     }
// }

// function local_hoteles_city_dashboard_get_kpi_overview(array $params = array(), bool $allCourses = false){
//     $kpis = local_hoteles_city_dashboard_get_KPIS();
//     $wherecourseidin = array();
//     $ids = array();
//     $configs = array();

//     foreach($kpis as $key => $kpi){
//         $name = 'kpi_' . $key;
//         if( $config = get_config('local_hoteles_city_dashboard', $name)){
//             if(empty($config)){
//                 continue;
//             }
//             $configs[$key] = explode(',', $config);
//             $ids = array_merge($ids, explode(',', $config));
//         }
//     }
//     if(empty($ids)){
//         return array();
//     }
//     $ids = array_unique($ids);
//     $ids = implode(',', $ids);
//     $where = " AND id IN ({$ids}) ";
//     $courses = local_hoteles_city_dashboard_get_courses($allCourses, $where);
//     foreach($courses as $key => $course){
//         $courses[$key] = local_hoteles_city_dashboard_get_course_information($key, false, false, $params, false);
//     }
//     $response = array();
//     foreach($configs as $kpi => $config){
//         $kpi_status = new stdClass();
//         $kpi_courses = array();
//         foreach($config as $course_id){
//             array_push($kpi_courses, $courses[$course_id]);
//         }
//         switch($kpi){
//             case LOCAL_HOTELES_CITY_KPI_OPS: // 1 // Aprobado, no aprobado y destacado
//                 $kpi_status->type = $kpis[LOCAL_HOTELES_CITY_KPI_OPS];
//                 break;
//             case LOCAL_HOTELES_CITY_KPI_HISTORICO: // 2 retorna el número de quejas
//                 $kpi_status->type = $kpis[LOCAL_HOTELES_CITY_KPI_HISTORICO];
                
//                 break;
//             case LOCAL_HOTELES_CITY_KPI_SCORCARD: // 3 Rotación rolling y rotación mensual
//                 $kpi_status->type = $kpis[LOCAL_HOTELES_CITY_KPI_SCORCARD];
//                 break;
//         }
//         $kpi_status->name = $kpis[$kpi];
//         $kpi_status->id = $kpi;
//         $kpi_status->courses = $kpi_courses;
//         $kpi_status->status = local_hoteles_city_dashboard_get_kpi_results($kpi, $params);
//         array_push($response, $kpi_status);
//     }
//     return ['type' => 'kpi_list', 'result' => $response];
    

//     if(!empty($wherecourseidin)){
//         $wherecourseidin = array_unique($wherecourseidin);
//         $wherecourseidin = implode(',', $wherecourseidin);
//         $where = " AND id IN ({$wherecourseidin}) ";
//         return local_hoteles_city_dashboard_get_courses($allCourses, $where);
//     }
//     return array();
// }

// /**
//  * @return array
//  */
// function local_hoteles_city_dashboard_get_courses_overview(int $type, array $params = array(), bool $allCourses = false){
//     if($type === LOCAL_HOTELES_CITY_DASHBOARD_COURSE_KPI_COMPARATIVE){
//         return local_hoteles_city_dashboard_get_kpi_overview($params, $allCourses);
//     }
//     $courses = local_hoteles_city_dashboard_get_courses_with_filter($allCourses, $type);
//     $courses_in_order = array();
//     foreach($courses as $course){
//         $course_information = local_hoteles_city_dashboard_get_course_information($course->id, $kpis = false, $activities = false, $params, false);        
//         if(empty($course_information)){
//             continue;
//         }
//         array_push($courses_in_order, $course_information);
//     }
//     usort($courses_in_order, function ($a, $b) {return $a->percentage < $b->percentage;});
//     return ['type' => 'course_list', 'result' => $courses_in_order];
// }

// function local_hoteles_city_dashboard_get_course_chart(int $courseid){
//     if($response = get_config('local_hoteles_city_dashboard', 'course_main_chart_' . $courseid)){
//         return $response;
//     }
//     return "bar";
// }

// // function local_hoteles_city_dashboard_get_course_color(int $courseid){
// //     if($response = get_config('local_hoteles_city_dashboard', 'course_main_chart_color_' . $courseid)){
// //         return $response;
// //     }
// //     return "#006491";
// // }

// function local_hoteles_city_dashboard_get_date_add_days(int $days = 1){
//     $date = new DateTime(date('Y-m-d'));

//     $date->modify("+{$days} day");
//     return $date->format('Y-m-d');
// }

// function local_hoteles_city_dashboard_create_slug($str, $delimiter = '_'){
//     $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
//     return $slug;
// } 

// function local_hoteles_city_dashboard_get_course_comparative(int $courseid, array $params){
//     $response = new stdClass();
//     global $DB;
//     $course = $DB->get_record('course', array('id' => $courseid), 'id, shortname, fullname');
//     $response->title = $course->fullname;
//     $response->key = 'course_' . $course->id;
//     $response->id = $course->id;
//     $response->shortname = $course->shortname;
//     $response->fullname = $course->fullname;
//     $indicators = local_hoteles_city_dashboard_get_indicators();
//     $conditions = local_hoteles_city_dashboard_get_wheresql_for_user_catalogues($params, $indicators);
//     if($course === false){
//         return array();
//     }
//     $fecha_inicial = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_inicial');
//     $fecha_final = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_final');
//     $indicator = $params['selected_filter'];
//     if(isset($params[$indicator])){
//         _log('Se tienen parámetros');
//     }
//     $catalogue = local_hoteles_city_dashboard_get_catalogue($indicator, $conditions->sql, $conditions->params);
//     $key = $indicator;
//     $comparative = array();
//     foreach($catalogue as $catalogue_item){
//         $item_to_compare = new stdClass();
//         $item_to_compare->name = $catalogue_item;
//         $params[$key] = [$catalogue_item];
//         $userids = local_hoteles_city_dashboard_get_user_ids_with_params($courseid, $params, false);                
//         if(empty($userids)){
//             $item_to_compare->enrolled_users = 0;
//             $item_to_compare->approved_users = 0;
//             $item_to_compare->percentage = local_hoteles_city_dashboard_percentage_of($item_to_compare->approved_users, $item_to_compare->enrolled_users);                    
//         }else{
//             $item_to_compare->enrolled_users = count($userids); //
//             $userids = implode(',', $userids);
//             $item_to_compare->approved_users = local_hoteles_city_dashboard_get_approved_users($courseid, $userids, $fecha_inicial, $fecha_final); //
//             $item_to_compare->percentage = local_hoteles_city_dashboard_percentage_of($item_to_compare->approved_users, $item_to_compare->enrolled_users);
//         }
//         array_push($comparative, $item_to_compare);
//     }
//     $response->comparative = $comparative;
//     $response->filter = $indicator;
//     return $response;
// }

// function local_hoteles_city_dashboard_get_email_provider_to_allow(){
//     if($email_provider = get_config('local_hoteles_city_dashboard', 'allowed_email_addresses_in_course')){
//         return $email_provider; // Ejemplo: @subitus.com.mx
//     }else{
//         return ""; // Permitirá todos los correos si no se configura esta sección
//     }
// }



// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_CATEGORY_PARENT_NAME", "parent_category");
// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_DEBUG", true);

// DEFINE("LOCAL_HOTELES_CITY_KPI_NA", 0);
// DEFINE("LOCAL_HOTELES_CITY_KPI_OPS", 1);
// DEFINE("LOCAL_HOTELES_CITY_KPI_HISTORICO", 2);
// DEFINE("LOCAL_HOTELES_CITY_KPI_SCORCARD", 3);

// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_NOFILTER", "__NOFILTER__");

// DEFINE('LOCAL_HOTELES_CITY_DASHBOARD_PROGRAMAS_ENTRENAMIENTO', 1);
// DEFINE('LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS', 2);
// DEFINE('LOCAL_HOTELES_CITY_DASHBOARD_COURSE_KPI_COMPARATIVE', 3);
// DEFINE('LOCAL_HOTELES_CITY_DASHBOARD_AVAILABLE_COURSES', 4);

// function local_hoteles_city_dashboard_get_course_tabs(){
//     return $tabOptions = [
//         LOCAL_HOTELES_CITY_DASHBOARD_PROGRAMAS_ENTRENAMIENTO => 'Programas de entrenamiento',
//         LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS => 'Campañas',
//         LOCAL_HOTELES_CITY_DASHBOARD_COURSE_KPI_COMPARATIVE => "Comparación de KPI's",
//     ];
// }

// function local_hoteles_city_dashboard_get_course_tabs_as_js_script(){
//     $result = json_encode(local_hoteles_city_dashboard_get_course_tabs());
//     return "<script> var ldm_course_tabs = {$result}; </script>";
// }

// function local_hoteles_city_dashboard_get_KPIS(){
//     return [
//         // LOCAL_HOTELES_CITY_KPI_NA => "N/A", // No kpi
//         LOCAL_HOTELES_CITY_KPI_OPS => "AUDITORÍA ICA",
//         LOCAL_HOTELES_CITY_KPI_HISTORICO => "TOTAL DE QUEJAS POR TIENDA",
//         LOCAL_HOTELES_CITY_KPI_SCORCARD => "INDICADORES RRHH"
//     ];
// }

// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_DEFAULT", 1);
// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_DEFAULT_AND_GRADE", 2);
// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_GRADE", 3);
// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_BADGE", 4);
// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_ACTIVITY", 5);
// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_AVG", 6);
// //DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_ATTENDANCE", 5);

// DEFINE('LOCAL_HOTELES_CITY_DASHBOARD_INDICATORS', 'regiones/distritos/entrenadores/tiendas/puestos/ccosto');
// DEFINE('LOCAL_HOTELES_CITY_DASHBOARD_INDICATORS_FOR_KPIS', 'regiones/distritos/tiendas/periodos');
// DEFINE('LOCAL_HOTELES_CITY_DASHBOARD_CHARTS', ['bar' => 'Barras', 'pie' => 'Pay', 'gauge' => 'Círculo']); //'bar/pie/gauge');


// function local_hoteles_city_dashboard_relate_column_with_fields(array $columns, array $requiredFields, bool &$hasRequiredColumns){
//     $response = array();
//     $notFound = array();
//     foreach($requiredFields as $field){
//         $pos = array_search($field, $columns);
//         if($pos === false){
//             $hasRequiredColumns = false;
//             array_push($notFound, $field);
//         }else{
//             $response[$field] = $pos;
//         }
//     }
//     if(!$hasRequiredColumns){
//         return $notFound;
//     }
//     return $response;
// }

// function local_hoteles_city_dashboard_get_catalogue(string $key, string $andWhereSql = '', array $query_params = array()){
//     $indicators = local_hoteles_city_dashboard_get_indicators();
//     if(array_search($key, $indicators) === false){
//         return [];
//     }
//     $fieldid = get_config('local_hoteles_city_dashboard', "filtro_" . $key);
//     if($fieldid === false){
//         return [];
//     }
//     $setting = "allow_empty_" . $key;
//     $allow_empty = get_config('local_hoteles_city_dashboard', $setting);
//     if($allow_empty) {
//         $allow_empty = "";
//     } else {
//         $allow_empty = " AND data != '' AND data IS NOT NULL ";
//     }
//     global $DB;
//     if($key == 'ccosto'){
//         $ccomfield = get_config('local_hoteles_city_dashboard', "filtro_idccosto");
//         if(!empty($ccomfield)){
//             if(!empty($allow_empty)){
//                 $_allow_empty = " AND uid_.data != '' AND uid_.data IS NOT NULL ";
//             }else{
//                 $_allow_empty = "";
//             }
//             // $query = "SELECT data from {user_info_data} as uid_ WHERE uid_.fieldid = {$fieldid} AND uid_.userid = uid.userid {$_allow_empty} (SELECT data as menu_value FROM {user_info_data} where fieldid = {$fieldid} {$andWhereSql} {$allow_empty} group by data) ";
//             // $query = "SELECT data as menu_id, COALESCE((SELECT data from {user_info_data} as uid_ WHERE uid_.fieldid = {$fieldid} AND uid_.userid = uid.userid {$_allow_empty} LIMIT 1), '') as menu_value
//             //  FROM {user_info_data} uid where fieldid = {$ccomfield} {$andWhereSql} {$allow_empty} group by menu_id HAVING menu_value != ''";
//             $query = "SELECT distinct data as menu_id, COALESCE((SELECT data from {user_info_data} as uid_ WHERE uid_.fieldid = {$ccomfield} AND uid_.userid = uid.userid {$_allow_empty} LIMIT 1), '') as menu_value
//              FROM {user_info_data} uid where fieldid = {$fieldid} {$andWhereSql} {$allow_empty} group by menu_id HAVING menu_value != '' ORDER BY menu_value ASC";
//             $result = $DB->get_records_sql_menu($query, $query_params);
//             // if($result){
//             //     $_result = array();
//             //     foreach($result as $key => $temporal){
//             //         $result
//             //     }
//             // }
//             // usort($result, function ($a, $b) {return $a->percentage < $b->percentage;});
//             return $result;
//         }
//     }
//     $query = "SELECT data, data as _data FROM {user_info_data} where fieldid = {$fieldid} {$andWhereSql} {$allow_empty} group by data order by data ASC ";
//     // _log('local_hoteles_city_dashboard_get_catalogue query', $query);
//     return $DB->get_records_sql_menu($query, $query_params);
// }

// function local_hoteles_city_dashboard_get_user_catalogues(array $params = array()){
//     $response = array();
//     $returnOnly = $indicators = local_hoteles_city_dashboard_get_indicators();
//     if(!empty($params['selected_filter'])){
//         $returnOnly = local_hoteles_city_dashboard_get_indicators($params['selected_filter']);
//     }
//     if(empty($returnOnly)){
//         return [];
//     }
    
//     $conditions = local_hoteles_city_dashboard_get_wheresql_for_user_catalogues($params, $indicators);
//     foreach($returnOnly as $indicator){
//         $response[$indicator] = local_hoteles_city_dashboard_get_catalogue($indicator, $conditions->sql, $conditions->params);
//     }
//     // _log($response);
//     return $response;
// }

// function local_hoteles_city_dashboard_get_wheresql_for_user_catalogues(array $params, $indicators){
//     $query_params = array();
//     $conditions = array();
//     $andWhereSql = "";
//     $response = new stdClass();
//     if(!empty($params)){
//         foreach($params as $key => $param){
//             if(array_search($key, $indicators) !== false){
//                 $fieldid = get_config('local_hoteles_city_dashboard', "filtro_" . $key);
//                 if($fieldid !== false){
//                     $data = $params[$key];
//                     if(is_string($data) || is_numeric($data)){
//                         array_push($conditions, " (fieldid = {$fieldid} AND data = ?)");
//                         array_push($query_params, $data);
//                     }elseif(is_array($data)){
//                         $fieldConditions = array();
//                         foreach ($data as $d) {
//                             array_push($fieldConditions, " ? ");
//                             array_push($query_params, $d);
//                         }
//                         if(!empty($fieldConditions)){
//                             array_push($conditions, "(fieldid = {$fieldid} AND data in (" . implode(",", $fieldConditions) . "))");
//                         }
//                     }
//                 }
//             }
//         }
//     }
//     if(!empty($conditions)){
//         $andWhereSql = " AND userid IN ( SELECT DISTINCT userid FROM {user_info_data} WHERE " . implode(' OR ', $conditions) . ")";
//     }
//     $response->sql = $andWhereSql;
//     $response->params = $query_params;
//     return $response;
// }

// function local_hoteles_city_dashboard_get_all_catalogues_for_kpi($kpi, $params = array()){
//     $indicators = array();
//     foreach(local_hoteles_city_dashboard_get_kpi_indicators() as $indicator){
//         $indicators[$indicator] = local_hoteles_city_dashboard_get_kpi_catalogue($indicator, $kpi, $params);
//     }
//     _log($indicators);
//     return $indicators;
// }

// function local_hoteles_city_dashboard_get_completion_modes(){
//     return [
//         LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_DEFAULT => "Finalizado/No finalizado (seguimiento de finalización configurado)",
//         // LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_DEFAULT_AND_GRADE => "Finalizado/No finalizado más calificación (por ponderación en curso pero no establecida para finalización de curso)",
//         LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_GRADE => "Calificación de una actividad",
//         LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_BADGE => "Obtención de una insignia",
//         LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_ACTIVITY => "Finalización de una actividad",
//     ];
// }

// function local_hoteles_city_dashboard_get_course_grade(int $userid, stdClass $course, $default = -1,  $scale = 10){
//     global $DB;
//     $grade = $default;
//     $query = "SELECT grades.finalgrade as finalgrade, items.grademax as grademax FROM {grade_grades} grades JOIN {grade_items} items
//     ON grades.itemid = items.id where items.itemtype = 'course' AND items.courseid = {$course->id} AND grades.userid = {$userid}";
//     if($data = $DB->get_record_sql($query)){
//         if($data->grademax > 0){
//             $grade = $data->finalgrade / $data->grademax * $scale;
//         }
//     }
//     return $grade;
// }

// /**
//  * @param $userid int
//  * @param $course_completion_info intance of $course = $DB->get_record('course', array('id' => $course->id)); $info = new completion_info($course);
//  */
// function local_hoteles_city_dashboard_get_completed_activities_in_course(int $userid, $course_completion_info){
//     if(is_int($course_completion_info)){
//         global $DB;
//         $course = $DB->get_record('course', array('id' => $course_completion_info));
//         $course_completion_info = new completion_info($course);
//     }
//     $defaultResponse = 0;
//     if($course->id === 1){
//         return $defaultResponse;
//     }
//     global $USER, $DB;
    
//     $context = context_course::instance($course->id);

//     // // Get course completion data.
//     $course = $DB->get_record('course', array('id' => $course->id));
//     $info = new completion_info($course);

//     // Load criteria to display.
//     $completions = $course_completion_info->get_completions($userid);

//     // Check if this course has any criteria.
//     if (empty($completions)){
//         return $defaultResponse;
//     }

//     // Check this user is enroled.
//     if ($info->is_tracked_user($userid)){

//         $completed_activities = 0;

//         // Loop through course criteria.
//         foreach ($completions as $completion){
//             $criteria = $completion->get_criteria();
//             $complete = $completion->is_complete();
//             if($complete){
//                 $completed_activities++;
//             }
//         }
//         return $completed_activities;
//     }

//     return $defaultResponse;
// }

// function local_hoteles_city_dashboard_get_course_completion(int $userid, stdClass $course, $completion_info = null ){
//     if($completion_info == null){
//         require_once(__DIR__ . '/../../lib/completionlib.php');
//         $completion_info = new completion_info($course);
//     }

// }

// function local_hoteles_city_dashboard_get_module_grade(int $userid, int $moduleid, int $scale = 10){
//     global $DB;
//     $grade = 0;
//     $query = "SELECT grades.finalgrade as finalgrade, items.grademax as grademax FROM {grade_grades} grades JOIN {grade_items} items
//     ON grades.itemid = items.id where items.itemtype = 'mod' AND grades.userid = {$userid} AND items.iteminstance = {$moduleid}";
//     if($data = $DB->get_record_sql($query)){
//         if($data->grademax > 0){
//             $grade = $data->finalgrade / $data->grademax * $scale;
//         }
//     }
//     return $grade;
// }

// function local_hoteles_city_dashboard_is_enrolled(int $courseid, int $userid){
//     return is_enrolled(context_course::instance($courseid), $userid);    
// }

// function local_hoteles_city_dashboard_user_has_access(bool $throwError = true){
//     $has_capability = has_capability('local/hoteles_city_dashboard:view', context_system::instance());
//     if(!$has_capability){ // si el rol del usuario no tiene permiso, buscar si está en la configuración: allowed_email_admins
//         if(isloggedin()){
//             $allowed_email_admins = get_config('local_hoteles_city_dashboard', 'allowed_email_admins');
//             if(!empty($allowed_email_admins)){
//                 $allowed_email_admins = explode(' ', $allowed_email_admins);
//                 if(!empty($allowed_email_admins)){
//                     global $USER;
//                     $email = $USER->email;
//                     if(in_array($email, $allowed_email_admins) !== false){
//                         $has_capability = true;
//                     }
//                 }
//             }
//         }
//     }
//     if($throwError){
//         if(!$has_capability){
//             print_error('Usted no tiene permiso para acceder a esta sección');
//         }
//     }else{
//         return $has_capability;
//     }
// }