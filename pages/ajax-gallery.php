<?php
// Simulate gallery — in real case, query from DB
$gallery_html = '';

$image_list = [
    'kitten1.jpg',
    'kitten2.jpg',
    'kitten3.jpg',
    'kitten4.jpg'
];

foreach ($image_list as $img) {
    $thumb = "uploads/$img";
    $full = "uploads/$img";
    $gallery_html .= "
        <a href=\"$full\" class=\"grid-item\" data-src=\"$full\" data-exthumbimage=\"$thumb\">
            <img src=\"$thumb\" alt=\"Gallery Image\">
        </a>
    ";
}

echo json_encode([
    'gallery_html' => $gallery_html
]);
