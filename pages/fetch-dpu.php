<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';
file_put_contents("debug_org.txt", print_r($_POST, true));
header('Content-Type: application/json');

if ($_POST['action'] === 'list_dpu_report') {

    $fy = $db_con->real_escape_string($_POST['filter_fy']);

    if (empty($fy)) {
        $fy = date('Y');
    }

    $columns = ['b.modid', 'b.modcode'];
    $sql_models = "SELECT b.modid, b.modcode FROM model_details b WHERE b.compcd = '$session_comp' and b.plant = '$session_plant' and b.modstatus = 'Y' ";
    
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql_models .= " AND (b.modcode LIKE '%$search%') ";
    }
    
    $sql_models .= " ORDER BY b.modid ASC ";

    $sql_vol = "SELECT * FROM dpu_volume WHERE financial_year = '$fy'";
    $res_vol = $db_con->query($sql_vol);
    $vols = [];
    if ($res_vol) {
        while($v = $res_vol->fetch_assoc()) {
            $vols[$v['model_id']] = $v;
        }
    }

    // MONTH() matches calendar month.
    $sql_def = "SELECT inspection_records.ir_model, MONTH(inspection_records.shift_date) as mth, COUNT(inspection_defect.defect_id) as tot
                FROM inspection_defect 
                JOIN inspection_records ON inspection_records.ir_id = inspection_defect.rcd_ir_id 
                WHERE inspection_records.financial_yr = '$fy'
                GROUP BY inspection_records.ir_model, MONTH(inspection_records.shift_date)";
    // Since shift_date handles proper production date, it's safer than inspect_date.
    
    $res_def = $db_con->query($sql_def);
    $defs = [];
    if ($res_def) {
        while($d = $res_def->fetch_assoc()) {
            $defs[$d['ir_model']][$d['mth']] = floatval($d['tot']);
        }
    }

    $m_map = [
            'feb' => 2, 'mac' => 3, 'apr' => 4, 'may' => 5, 'june' => 6,
            'july' => 7, 'aug' => 8, 'sept' => 9, 'oct' => 10, 'nov' => 11,
            'december' => 12, 'jan' => 1
    ];

    $limit = "";
    if ($_POST['length'] != -1) {
        $limit = " LIMIT {$_POST['start']}, {$_POST['length']} ";
    }
    
    $queryTotal = $db_con->query($sql_models);
    $queryData = $db_con->query($sql_models . $limit);

    $data = array();
    $no = $_POST['start'] + 1;

    while ($row = $queryData->fetch_assoc()) {
        $mid = $row['modid'];
        $sub_array = array();
        $sub_array[] = $no++ .'.';
        $sub_array[] = '<span class="fw-bold">'.$row['modcode'].'</span>';

        foreach ($m_map as $col => $mth_num) {
            
            $vol = isset($vols[$mid][$col]) ? floatval($vols[$mid][$col]) : 0;
            $def = isset($defs[$mid][$mth_num]) ? $defs[$mid][$mth_num] : 0;


            if ($vol > 0) {
                $dpu = number_format(($def / $vol), 4);
                $def_color_class = ($dpu != 0) ? 'text-grey-hard' : 'text-grey-lt';
                $sub_array[] = '<span class="fw-semibold '.$def_color_class.'">'.$dpu.'</span>';
            } else {
                $sub_array[] = ($def > 0) ? '<span class="text-danger" title="'.$def.' defects without volume">Vol 0</span>' : '-';
            }
        }

        $data[] = $sub_array;
    }

    echo json_encode([
        "draw"            => intval($_POST["draw"]),
        "recordsTotal"    => $queryTotal ? $queryTotal->num_rows : 0,
        "recordsFiltered" => $queryTotal ? $queryTotal->num_rows : 0,
        "data"            => $data
    ]);
    exit;
}

if ($_POST['action'] === 'get_dpu_chart') {

    $fy = $db_con->real_escape_string($_POST['filter_fy']);

    if (empty($fy)) {
        $fy = date('Y');
    }

    $sql_vol = "SELECT * FROM dpu_volume WHERE financial_year = '$fy'";
    $res_vol = $db_con->query($sql_vol);
    $vols = [];

    if ($res_vol) {
        while($v = $res_vol->fetch_assoc()) {
            $vols[$v['model_id']] = $v;
        }
    }

    $sql_def = "SELECT inspection_records.ir_model, MONTH(inspection_records.shift_date) as mth, COUNT(inspection_defect.defect_id) as tot
                FROM inspection_defect 
                JOIN inspection_records ON inspection_records.ir_id = inspection_defect.rcd_ir_id 
                WHERE inspection_records.financial_yr = '$fy'
                GROUP BY inspection_records.ir_model, MONTH(inspection_records.shift_date)";
    
    $res_def = $db_con->query($sql_def);
    $defs = [];

    if ($res_def) {
        while($d = $res_def->fetch_assoc()) {
            $defs[$d['ir_model']][$d['mth']] = floatval($d['tot']);
        }
    }

    $m_map = [
            'feb' => 2, 'mac' => 3, 'apr' => 4, 'may' => 5, 'june' => 6,
            'july' => 7, 'aug' => 8, 'sept' => 9, 'oct' => 10, 'nov' => 11,
            'december' => 12, 'jan' => 1
    ];

    $sql_models = "SELECT modid, modcode FROM model_details WHERE compcd = '$session_comp' and plant = '$session_plant' and modstatus = 'Y'";
    $res_models = $db_con->query($sql_models);
    $models_map = [];
    if ($res_models) {
        while($m = $res_models->fetch_assoc()) {
            $models_map[$m['modid']] = $m['modcode'];
        }
    }

    $models_with_data = [];
    foreach($vols as $mid => $v) {
        $models_with_data[$mid] = true;
    }
    foreach($defs as $mid => $dm) {
        $models_with_data[$mid] = true;
    }

    $series = [];
    foreach($models_with_data as $mid => $val) {
        $modcode = isset($models_map[$mid]) ? $models_map[$mid] : "Unknown Model ($mid)";
        $model_dpu = [];
        $model_def = [];
        $model_vol = [];
        
        foreach ($m_map as $col => $mth_num) {
            $vol = isset($vols[$mid][$col]) ? floatval($vols[$mid][$col]) : 0;
            $def = isset($defs[$mid][$mth_num]) ? floatval($defs[$mid][$mth_num]) : 0;
            
            $dpu_val = ($vol > 0) ? ($def / $vol) : 0;
            $model_dpu[] = round($dpu_val, 4);
            $model_def[] = $def;
            $model_vol[] = $vol;
        }
        
        $series[] = [
            'name' => $modcode,
            'data' => $model_dpu,
            'defects' => $model_def,
            'volumes' => $model_vol
        ];
    }

    usort($series, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });

    echo json_encode([
        'status' => 'success',
        'series' => $series
    ]);
    exit;
}

if ($_POST['action'] === 'list_monthly_dpu_table') {

    $fy = $db_con->real_escape_string($_POST['filter_fy']);

    if (empty($fy)) {
        $fy = date('Y');
    }

    $sql_models = "SELECT b.modid, b.modcode FROM model_details b WHERE b.compcd = '$session_comp' and b.plant = '$session_plant' and b.modstatus = 'Y' ORDER BY b.modid ASC";
    
    $sql_vol = "SELECT * FROM dpu_volume WHERE financial_year = '$fy'";
    $res_vol = $db_con->query($sql_vol);
    $vols = [];
    if ($res_vol) {
        while($v = $res_vol->fetch_assoc()) {
            $vols[$v['model_id']] = $v;
        }
    }

    $sql_target = "SELECT * FROM dpu_target WHERE financial_year = '$fy'";
    $res_target = $db_con->query($sql_target);
    $targets = [];
    if ($res_target) {
        while($t = $res_target->fetch_assoc()) {
            $targets[$t['model_id']] = $t;
        }
    }

    $sql_def = "SELECT inspection_records.ir_model, MONTH(inspection_records.shift_date) as mth, COUNT(inspection_defect.defect_id) as tot
                FROM inspection_defect 
                JOIN inspection_records ON inspection_records.ir_id = inspection_defect.rcd_ir_id 
                WHERE inspection_records.financial_yr = '$fy'
                GROUP BY inspection_records.ir_model, MONTH(inspection_records.shift_date)";
    
    $res_def = $db_con->query($sql_def);
    $defs = [];
    if ($res_def) {
        while($d = $res_def->fetch_assoc()) {
            $defs[$d['ir_model']][$d['mth']] = floatval($d['tot']);
        }
    }

    $m_map = [
            'jan' => 1, 'feb' => 2, 'mac' => 3, 'apr' => 4, 'may' => 5, 'june' => 6,
            'july' => 7, 'aug' => 8, 'sept' => 9, 'oct' => 10, 'nov' => 11,
            'december' => 12
    ];

    $res_models = $db_con->query($sql_models);
    $models = [];
    if ($res_models) {
        while($m = $res_models->fetch_assoc()){
            $models[] = $m;
        }
    }

    $data = [];
    
    foreach ($m_map as $col_name => $mth_num) {
        $first_in_month = true;
        $m_lbl = ucfirst($col_name == 'mac' ? 'Mar' : ($col_name == 'december' ? 'Dec' : substr($col_name, 0, 3)));
        
        foreach ($models as $row) {
            $mid = $row['modid'];
            $vol = isset($vols[$mid][$col_name]) ? floatval($vols[$mid][$col_name]) : 0;
            $def = isset($defs[$mid][$mth_num]) ? floatval($defs[$mid][$mth_num]) : 0;
            $target = isset($targets[$mid][$col_name]) ? floatval($targets[$mid][$col_name]) : 0;

            if ($vol > 0 || $def > 0) {
                $dpu_val = ($vol > 0) ? ($def / $vol) : 0;
                $dpu = number_format($dpu_val, 4);
                
                $def_color_class = ($def != 0) ? 'text-red-light' : '';
                $dpu_color_class = ($dpu_val > $target) ? 'text-grey-lt' : 'text-grey-lt';
                $bullet_class = ($dpu_val > $target) ? 'bg-merah' : 'bg-hijau';
                $tooltip_text = ($dpu_val > $target) ? 'Above Target' : 'Below Target';
                $bullet = '<span class="status-bullet '.$bullet_class.'" title="'.$tooltip_text.'" data-bs-toggle="tooltip"></span>';
                
                $sub_array = [];
                $sub_array[] = $first_in_month ? '<span class="fw-bold">'.$m_lbl.'</span>' : '';
                $sub_array[] = $row['modcode'];
                $sub_array[] = '<span class="fw-semibold '.$def_color_class.'">'.$def.'</span>';
                $sub_array[] = '<span class="fw-semibold">'.$vol.'</span>';
                $sub_array[] = '<div class="d-flex align-items-center">'.$bullet.'<span class="fw-semibold '.$dpu_color_class.' ms-2">'.$dpu.'</span></div>';
                $sub_array[] = '<span class="fw-semibold">'.$target.'</span>';
                
                $data[] = $sub_array;
                $first_in_month = false;
            }
        }
    }

    echo json_encode([
        "data" => $data
    ]);
    exit;
}

if ($_POST['action'] === 'get_monthly_dpu_chart') {

    $fy = $db_con->real_escape_string($_POST['filter_fy']);
    
    if (empty($fy)) {
        $fy = date('Y');
    }

    $sql_models = "SELECT b.modid, b.modcode FROM model_details b WHERE b.compcd = '$session_comp' and b.plant = '$session_plant' and b.modstatus = 'Y' ORDER BY b.modid ASC";
    
    $sql_vol = "SELECT * FROM dpu_volume WHERE financial_year = '$fy'";
    $res_vol = $db_con->query($sql_vol);
    $vols = [];
    if ($res_vol) {
        while($v = $res_vol->fetch_assoc()) {
            $vols[$v['model_id']] = $v;
        }
    }

    $sql_target = "SELECT * FROM dpu_target WHERE financial_year = '$fy'";
    $res_target = $db_con->query($sql_target);
    $targets = [];
    if ($res_target) {
        while($t = $res_target->fetch_assoc()) {
            $targets[$t['model_id']] = $t;
        }
    }

    $sql_def = "SELECT inspection_records.ir_model, MONTH(inspection_records.shift_date) as mth, COUNT(inspection_defect.defect_id) as tot
                FROM inspection_defect 
                JOIN inspection_records ON inspection_records.ir_id = inspection_defect.rcd_ir_id 
                WHERE inspection_records.financial_yr = '$fy'
                GROUP BY inspection_records.ir_model, MONTH(inspection_records.shift_date)";
    $res_def = $db_con->query($sql_def);
    $defs = [];
    if ($res_def) {
        while($d = $res_def->fetch_assoc()) {
            $defs[$d['ir_model']][$d['mth']] = floatval($d['tot']);
        }
    }

    $m_map = [
            'jan' => 1, 'feb' => 2, 'mac' => 3, 'apr' => 4, 'may' => 5, 'june' => 6,
            'july' => 7, 'aug' => 8, 'sept' => 9, 'oct' => 10, 'nov' => 11,
            'december' => 12
    ];

    $month_labels = [];
    foreach ($m_map as $col_name => $mth_num) {
        $month_labels[$col_name] = ucfirst($col_name == 'mac' ? 'Mar' : ($col_name == 'december' ? 'Dec' : substr($col_name, 0, 3)));
    }

    $res_models = $db_con->query($sql_models);
    $models = [];
    if ($res_models) {
        while($m = $res_models->fetch_assoc()){
            $models[] = $m;
        }
    }

    // Build categories = just the month labels (shared X axis)
    $categories = array_values($month_labels);

    // Per-model volume bars and DPU lines
    foreach ($models as $row) {
        $mid = $row['modid'];
        $vol_data = [];
        $dpu_data = [];
        $has_data = false;

        foreach ($m_map as $col_name => $mth_num) {
            $vol = isset($vols[$mid][$col_name]) ? floatval($vols[$mid][$col_name]) : 0;
            $def = isset($defs[$mid][$mth_num]) ? floatval($defs[$mid][$mth_num]) : 0;
            $dpu_val = ($vol > 0) ? round($def / $vol, 4) : null;

            $vol_data[] = $vol > 0 ? $vol : null;
            $dpu_data[] = $dpu_val;
        }

        if (array_filter($vol_data) || array_filter($dpu_data)) {
            $has_data = true;
        }

        if ($has_data) {
            $series[] = [
                'name' => $row['modcode'] . ' Vol',
                'type' => 'column',
                'data' => $vol_data
            ];
            $series[] = [
                'name' => $row['modcode'] . ' DPU',
                'type' => 'line',
                'data' => $dpu_data
            ];
        }
    }

    echo json_encode([
        'status' => 'success',
        'categories' => $categories,
        'model_count' => count($models),
        'series' => $series
    ]);
    exit;
}

if ($_POST['action'] === 'get_pdi_performance') {

    $fy = $db_con->real_escape_string($_POST['filter_fy']);
    if (empty($fy)) {
        $fy = date('Y');
    }

    $m_map = [
        'feb' => 2, 'mac' => 3, 'apr' => 4, 'may' => 5, 'june' => 6,
        'july' => 7, 'aug' => 8, 'sept' => 9, 'oct' => 10, 'nov' => 11,
        'december' => 12, 'jan' => 1
    ];

    // Current month and year for stopping the loop
    $current_month = intval(date('n'));
    $current_year = intval(date('Y'));
    
    // Determine which months to show
    // If $fy is current year, show until current month.
    // If $fy is past, show all 12 months.
    // If $fy is future, show none? No, let's just show until current if it's the current FY.
    
    // For now, let's just calculate for all and the frontend will filter if needed, 
    // or we just return the months that have passed in the FY.
    
    $sql_vol = "SELECT SUM(feb) as feb, SUM(mac) as mac, SUM(apr) as apr, SUM(may) as may, SUM(june) as june, 
                       SUM(july) as july, SUM(aug) as aug, SUM(sept) as sept, SUM(oct) as oct, SUM(nov) as nov, 
                       SUM(december) as december, SUM(jan) as jan 
                FROM dpu_volume WHERE financial_year = '$fy'";
    $res_vol = $db_con->query($sql_vol);
    $vols = $res_vol ? $res_vol->fetch_assoc() : [];

    $sql_def = "SELECT MONTH(inspection_records.shift_date) as mth, COUNT(inspection_defect.defect_id) as tot
                FROM inspection_defect 
                JOIN inspection_records ON inspection_records.ir_id = inspection_defect.rcd_ir_id 
                WHERE inspection_records.financial_yr = '$fy'
                GROUP BY MONTH(inspection_records.shift_date)";
    $res_def = $db_con->query($sql_def);
    $defs = [];
    if ($res_def) {
        while($d = $res_def->fetch_assoc()) {
            $defs[$d['mth']] = floatval($d['tot']);
        }
    }

    $data = [];
    $total_def_ytd = 0;
    $total_vol_ytd = 0;

    foreach ($m_map as $col => $m_num) {
        
        $v = isset($vols[$col]) ? floatval($vols[$col]) : 0;
        $d = isset($defs[$m_num]) ? floatval($defs[$m_num]) : 0;
        
        $dpu = ($v > 0) ? ($d / $v) : 0;
        
        $data[$col] = [
            'vol' => $v,
            'def' => $d,
            'dpu' => $dpu
        ];

        $total_def_ytd += $d;
        $total_vol_ytd += $v;
    }

    $ytd_dpu = ($total_vol_ytd > 0) ? ($total_def_ytd / $total_vol_ytd) : 0;

    echo json_encode([
        'status' => 'success',
        'data' => $data,
        'ytd' => $ytd_dpu,
        'fy' => $fy
    ]);
    exit;
}

?>