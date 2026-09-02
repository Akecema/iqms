<?php 

session_start();
include '../db/db_connect.php';
include 'session-login.php';

$company_m = $_GET['comp_id'];
$cstatus = 'AC';

$query_branch = "SELECT branch_id,branch_name FROM branch WHERE branch_co_id = ? AND branch_status = ? ORDER BY branch_name ASC ";
$get_branch = $db_con->prepare($query_branch); 
$get_branch->bind_param("is", $company_m, $cstatus);
$get_branch->execute();
$result_branch = $get_branch->get_result(); 

?>

<select class="form-control default-select h-auto wide embranch" id="ebranch">
    <!-- <option value="">Select Branch</option> -->
    <?php
    while ($row_allbranch = mysqli_fetch_array($result_branch)) {
    ?>
        <option value="<?php echo $row_allbranch['branch_id']; ?>" 
            <?= (isset($_GET['ebranch']) && $_GET['ebranch'] == $row_allbranch['branch_id']) ? "selected" : "" ?>>
            <?php echo $row_allbranch['branch_name']; ?>
        </option>
    <?php } ?>
</select>

<div class="invalid-feedback">
    Please select branch.
</div>

<script>

$(function() {
    //Initialize Select2 Elements
    $('.default-select').select2()
});

</script>