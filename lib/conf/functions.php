<?php

function URLout($URL)
{
    return str_replace(PUBLIC_URL, '@main@', $URL);
}

function URLin($URL)
{
    return str_replace('@main@', PUBLIC_URL, $URL);
}
