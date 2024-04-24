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
function customShortName($string){
    $acronym = '';
    $words = explode(' ', $string);
    foreach ($words as $word) {
        $acronym .= strtoupper($word[0]);
    }
    return $acronym;
}
function en2bnTime($time) {
    // Convert numerical time to Bangla numerals
    $banglaNumerals = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    $time = str_replace(range(0, 9), $banglaNumerals, $time);

    // Convert AM/PM to Bangla
    $time = str_replace(['AM', 'PM'], ['পূর্বাহ্ন', 'অপরাহ্ন'], $time);

    return $time;
}
function en2bnMonth($enMonth)
{
    $en = ["January","February","March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    $bn = ["জানুয়ারি","ফেব্রুয়ারি","মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর"];
    return str_replace($en,$bn,$enMonth);
}
