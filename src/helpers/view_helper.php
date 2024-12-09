<?php

function view($path) {
    require __DIR__ . "/../views/" . $path . ".view.php";
}

function render_page($content) {
    $_page_content = $content;
    require __DIR__ . "/../views/layout.view.php";
}
