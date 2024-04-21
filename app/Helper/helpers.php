<?php
function bn2en($number)
{
    $bnNumbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    $enNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    return str_replace($bnNumbers, $enNumbers, $number);
}
function en2bn($number)
{
    $enNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $bnNumbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

    return str_replace($enNumbers,$bnNumbers, $number);
}
