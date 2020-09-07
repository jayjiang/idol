<?php
return [
    'view_dir_name' => 'template',// theme template
    'tpl_replace_string' => [
        "__STATIC__" => "/static/".App('http')->getName()
    ],
];