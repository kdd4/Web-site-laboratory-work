<?php
if (!is_resource($data)) {
    header("Content-Type: text/plain; charset=utf-8");

    echo 'data is not a resource';
    return;
}

header("Content-Type: $type; charset=utf-8");

fpassthru($data);