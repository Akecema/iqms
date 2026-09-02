<?php 

session_start();
include '../db/db_connect.php';
include 'session-login.php';

$parmModel = $_GET['model_id'];
$cstatus = 'Y';

$query_type = "SELECT typeid, typemodel
                FROM model_type 
                    WHERE compcd = ? and plant = ? and typestatus = ? ORDER BY typemodel ASC ";
$get_type = $db_con->prepare($query_type); 
$get_type->bind_param("sss", $session_comp, $session_plant, $cstatus);
$get_type->execute();
$result_type = $get_type->get_result(); 

// $query_type = "SELECT typeid, typemodel, typeside FROM model_type WHERE compcd = ? and plant = ? and typestatus = ?  ORDER BY typemodel ASC ";
// $get_type = $db_con->prepare($query_type); 
// $get_type->bind_param("sss", $session_comp, $session_plant, $cstatus);
// $get_type->execute();
// $result_type = $get_type->get_result(); 

?>

<select class="form-control default-select h-auto wide cs_type" name="fd_type" id="fd_type" onChange="getMaterial('<?php echo $parmModel; ?>',this.value)">
    <option value="">Select Type</option>
    <?php
    while ($row_alltype = mysqli_fetch_array($result_type)) {
    ?>
        <option value="<?php echo $row_alltype['typeid']; ?>" 
            <?= (isset($_GET['fd_type']) && $_GET['fd_type'] == $row_alltype['typeid']) ? "selected" : "" ?>>
            <?php echo $row_alltype['typemodel']; ?>
        </option>
    <?php } ?>
</select>

<div class="invalid-feedback">
    Please select type.
</div>

<script>

$(function() {
    //Initialize Select2 Elements
    $('.default-select').select2()
});

</script>