<?php
// Database connection
include '../db/db_connect.php';

// 1. Initialize your starting group ID
$current_new_group = 1574; 
$last_combination = "";

// 2. Fetch the records in the exact order shown in your image
$sql = "SELECT ir_id, ir_model, ir_type, ir_material 
        FROM inspection_records_group 
        WHERE ir_shift = 'N' 
        AND shift_date BETWEEN '2026-02-01' AND '2026-04-10'
        ORDER BY ir_id ASC";

$result = $db_con->query($sql);

while ($row = $result->fetch_assoc()) {
    $ir_id = $row['ir_id'];
    // Create a unique string for the current row's combination
    $current_combination = $row['ir_model'] . "-" . $row['ir_type'] . "-" . $row['ir_material'];

    // 3. Check if the combination has changed from the last row
    if ($current_combination !== $last_combination) {
        $current_new_group++; // Increment only when the group changes
        $last_combination = $current_combination;
    }

    // 4. Update the database with the calculated new_group
    $update_sql = "UPDATE inspection_records_group SET inspect_group = $current_new_group WHERE ir_id = $ir_id";
    $db_con->query($update_sql);
    
    echo "ID: $ir_id | Group: $current_new_group Updated.<br>";
}

echo "Finished updating all records.";
?>