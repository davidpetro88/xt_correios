<?php

if (!empty($_POST)) {

    //---user.
    $user = array('user' => $_POST['user'],
        'pssw' => $_POST['password'],
        'zip_code' => str_replace('-', '', $_POST['zip_code']));

    //---services
    for ($i = 0; $i < count($_POST['active']); $i++) {

        $active[] = explode('_', $_POST['active'][$i]);
    }
    $service = $active;

    // make the array.
    $correiosPost = array('user' => $user,
        'service' => $service);

    $getValuesForm = $this->getValuesForm($correiosPost);

    echo $getValuesForm;
} else {
    die("false");
    echo false;
}
