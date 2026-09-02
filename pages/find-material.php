<?php 
session_start();
include '../db/db_connect.php';
include 'session-login.php';

$parmModel = $_GET['model_id'];
$parmType = $_GET['type_id'];
$cstatus = 'Y';

$query_matno = "SELECT matid, matno FROM material_header WHERE modelid = ? and typeid = ? and compcd = ? and plant = ? and matstatus = ? ORDER BY matno ASC ";
$get_matno = $db_con->prepare($query_matno); 
$get_matno->bind_param("iisss", $parmModel, $parmType, $session_comp, $session_plant, $cstatus);
$get_matno->execute();
$result_matno = $get_matno->get_result(); 

?>

<select class="form-control default-select h-auto wide cs_material" name="fd_material" id="fd_material">
    <option value="">Select Part No</option>
    <?php
    while ($row_allmatno = mysqli_fetch_array($result_matno)) {
    ?>
        <option value="<?php echo $row_allmatno['matid']; ?>" 
            <?= (isset($_GET['fd_material']) && $_GET['fd_material'] == $row_allmatno['matid']) ? "selected" : "" ?>>
            <?php echo $row_allmatno['matno']; ?>
        </option>
    <?php } ?>
</select>

<div class="invalid-feedback">
    Please select part no.
</div>

<script>

$(function() {
    //Initialize Select2 Elements
    $('.default-select').select2()
});

</script>