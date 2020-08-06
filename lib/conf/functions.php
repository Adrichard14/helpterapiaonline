<?php

function URLout($URL)
{
    return str_replace(PUBLIC_URL, '@main@', $URL);
}

function URLin($URL)
{
    return str_replace('@main@', PUBLIC_URL, $URL);
}

function xml2array($xmlObject, $out = [])
{
    foreach ((array)$xmlObject as $index => $node) {
        $out[$index] = (is_object($node)) ? xml2array($node) : $node;
    }
    return $out;
}
