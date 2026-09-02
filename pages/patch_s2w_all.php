<?php
$file = 'c:\xampp_7\htdocs\iQims\pages\fetch-ip-s2w-section-rcd-all.php';
$content = file_get_contents($file);

// 1. Replace Edit Button Logic
$searchEdit = <<<'EOD'
        if (in_array($row['rp_s2w_status'], [12, 13, 16])) {
            // EDIT button
            $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1"
                            data-bs-toggle="tooltip" title="Edit S2W Report" 
                            data-encrpid="'.$enc_rpid.'" 
                            data-irid="'.$row['ir_id'].'" 
                            data-status="'.$row["rp_s2w_status"].'" data-encstatus="'.$enc_status.'"
                            data-model="'.$row['ir_model'].'" data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                            <i class="fa fa-edit"></i>
                        </button>';
        }
EOD;

$replaceEdit = <<<'EOD'
        if (in_array($row['rp_s2w_status'], [12, 13, 16])) {
            if ($canEdit) {
                // EDIT button
                $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1"
                                data-bs-toggle="tooltip" title="Edit S2W Report" 
                                data-encrpid="'.$enc_rpid.'" 
                                data-irid="'.$row['ir_id'].'" 
                                data-status="'.$row["rp_s2w_status"].'" data-encstatus="'.$enc_status.'"
                                data-model="'.$row['ir_model'].'" data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                                <i class="fa fa-edit"></i>
                            </button>';
            } else {
                 // VIEW button
                $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1"
                                data-bs-toggle="tooltip" title="View S2W Report" 
                                data-encrpid="'.$enc_rpid.'" 
                                data-irid="'.$row['ir_id'].'"
                                data-status="'.$row["rp_s2w_status"].'" data-encstatus="'.$enc_status.'"
                                data-model="'.$row['ir_model'].'" data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                                <i class="fa fa-list"></i>
                            </button>';
            }
        }
EOD;

// Normalize line endings
$content = str_replace("\r\n", "\n", $content);
$searchEdit = str_replace("\r\n", "\n", $searchEdit);
$replaceEdit = str_replace("\r\n", "\n", $replaceEdit);

if (strpos($content, $searchEdit) !== false) {
    $content = str_replace($searchEdit, $replaceEdit, $content);
    echo "Edit Match Found!\n";
} else {
    echo "Edit Match NOT Found!\n";
    // Debug: print similar lines?
}

// 2. Replace Cancel Button Logic
// Note: The search string must account for trailing spaces in the comment
$searchCancel = <<<'EOD'
        elseif (in_array($row['rp_s2w_status'], [10])) { //pending review,pending approval
            // CANCEL button           
            $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1"
                            data-bs-toggle="tooltip" title="Cancel S2W" 
                            data-encrpid="'.$enc_rpid.'" 
                            data-irid="'.$row['ir_id'].'" 
                            data-status="'.$row["rp_s2w_status"].'" data-encstatus="'.$enc_status.'" 
                            data-model="'.$row['ir_model'].'" data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                            <i class="fa fa-times"></i>
                        </button>';
        }
EOD;

$replaceCancel = <<<'EOD'
        elseif (in_array($row['rp_s2w_status'], [10])) { //pending review,pending approval
            if ($canEdit) {
                // CANCEL button
                $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1"
                                data-bs-toggle="tooltip" title="Cancel S2W" 
                                data-encrpid="'.$enc_rpid.'" 
                                data-irid="'.$row['ir_id'].'" 
                                data-status="'.$row["rp_s2w_status"].'" data-encstatus="'.$enc_status.'" 
                                data-model="'.$row['ir_model'].'" data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                                <i class="fa fa-times"></i>
                            </button>';
            } else {
                 // VIEW button
                $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1"
                                data-bs-toggle="tooltip" title="View S2W Report" 
                                data-encrpid="'.$enc_rpid.'" 
                                data-irid="'.$row['ir_id'].'"
                                data-status="'.$row["rp_s2w_status"].'" data-encstatus="'.$enc_status.'"
                                data-model="'.$row['ir_model'].'" data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                                <i class="fa fa-list"></i>
                            </button>';
            }
        }
EOD;

$searchCancel = str_replace("\r\n", "\n", $searchCancel);
$replaceCancel = str_replace("\r\n", "\n", $replaceCancel);

if (strpos($content, $searchCancel) !== false) {
    $content = str_replace($searchCancel, $replaceCancel, $content);
    echo "Cancel Match Found!\n";
} else {
    echo "Cancel Match NOT Found! (Likely whitespace issue)\n";
    // Attempt fuzzy match for Cancel? 
    // Let's try matching everything between elseif line and closing brace
    $pattern = '/elseif \(in_array\(\$row\[\'rp_s2w_status\'\], \[10\]\)\) \{.*?\}\s*elseif/s';
    // Warning: this regex needs to match until end of block.
    // Simpler: match the header line
    $cancelHeader = "elseif (in_array(\$row['rp_s2w_status'], [10])) { //pending review,pending approval";
    
    // Find where this header starts
    $pos = strpos($content, $cancelHeader);
    if ($pos !== false) {
        echo "Cancel Header Found at $pos\n";
        // Find closing brace. It should be followed by next statement or EOF or new block.
        // The block ends effectively before the next Loop Iteration or check? 
        // No, it's followed by `//Shift`.
        $endPos = strpos($content, "//Shift", $pos);
        if ($endPos !== false) {
            // Backtrack to find closing brace of elseif
            $bracePos = strrpos(substr($content, 0, $endPos), '}');
            if ($bracePos !== false) {
                // Replace content
                $length = $bracePos - $pos + 1;
                $originalBlock = substr($content, $pos, $length);
                echo "Replacing fuzzy block...\n";
                $content = substr_replace($content, $replaceCancel, $pos, $length);
                 echo "Fuzzy match applied.\n";
            }
        }
    }
}

file_put_contents($file, $content);
?>
