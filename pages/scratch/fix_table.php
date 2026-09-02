<?php
$file = 'c:/xampp_7/htdocs/iQims/pages/inspection-rcd-pallet-list-all-pre.php';
$content = file_get_contents($file);
$content = str_replace(
    'class="display table mb-1 table-striped-thead table-wide table-md"',
    'class="display table mb-1 table-striped-thead table-wide table-md w-100" style="width: 100%;"',
    $content
);
file_put_contents($file, $content);
echo "Done\n";
?>
