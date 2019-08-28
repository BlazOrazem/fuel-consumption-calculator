<?php

require('phpQuery/phpQuery/phpQuery.php');

function cleanString($string)
{
    $urlEncodedWhiteSpaceChars = explode(',', '%81,%7F,%C5%8D,%8D,%8F,%C2%90,%C2,%90,%9D,%C2%A0,%A0,%C2%AD,%AD,%08,%09,%0A,%0D');

    return str_replace($urlEncodedWhiteSpaceChars, '', urlencode($string));
}

if (
    !isset($_GET['country']) ||
    !isset($_GET['fuel']) ||
    !in_array($_GET['fuel'], ['gasoline', 'diesel', 'lpg']) ||
    !in_array($_GET['country'], [
        'Austria',
        'Bosnia-and-Herzegovina',
        'Croatia',
        'Germany',
        'Hungary',
        'Italy',
        'Slovenia',
        'Serbia',
    ])
) {
    die('No data');
}

$result = [];
$page = file_get_contents('https://www.globalpetrolprices.com/' . $_GET['country'] . '/' . $_GET['fuel'] . '_prices/');
$parse = phpQuery::newDocumentHTML($page);
$parse = phpQuery::newDocumentHTML($parse->find('#graphPageLeft > table:first > tbody')->html());

foreach ($parse['tr'] as $row) {
    $currency = cleanString(pq($row)->find('th:first')->html());
    $value = trim(pq($row)->find('td:first')->html());

    if ($currency == 'EUR') {
        $result['default'] = [
            'currency' => $currency,
            'price'    => $value,
        ];
    }

    if (!in_array($currency, ['EUR', 'USD'])) {
        $result['regional'] = [
            'currency' => $currency,
            'price'    => $value,
        ];
    }

    if (!isset($result['regional'])) {
        $result['regional'] = [
            'currency' => $currency,
            'price'    => $value,
        ];
    }
}

die(json_encode($result));
