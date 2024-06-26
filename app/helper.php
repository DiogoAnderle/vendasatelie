<?php

//Return id of athenticated user
function userID()
{
    return auth()->user()->id;
}

//Return BRL currency format
function currencyBRLFormat($number)
{
    return 'R$ ' . number_format($number, 2, ',', '.');
}

//Return Numbers in full
function numbersInFull($number)
{
    return App\Models\NumbersInFull::converter($number, 'reais', false, 'centavos');
}

function isAdmin()
{
    return auth()->user()->admin;
}
