<?php

if (isset($_GET['source'])) {
    $source = preg_replace('#[^a-zA-Z0-9]#Uis', '', $_GET['source']);
    return unserialize(file_get_contents('../../cache/' . $source . '.cache'));
}
else
    return array();
