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
        'France',
        'Germany',
        'Hungary',
        'Italy',
        'Slovenia',
        'Serbia',
    ])
) {
    die('No data');
}

$result = [
    'date'     => date('d.m.Y'),
    'default'  => [
        'currency' => 'USD',
        'price'    => 0,
    ],
    'regional' => [
        'currency' => 'EUR',
        'price'    => 0,
    ],
];

$page = file_get_contents('https://www.globalpetrolprices.com/' . $_GET['country'] . '/');
$parsedPage = phpQuery::newDocumentHTML($page);
$head = phpQuery::newDocumentHTML($parsedPage->find('#graphPageLeft > table:first > thead')->html());
$body = phpQuery::newDocumentHTML($parsedPage->find('#graphPageLeft > table:first > tbody')->html());

// Parse regional currency
$counter = 0;
foreach ($head['td'] as $cell) {
    $counter++;

    if ($counter === 3) {
        $result['regional']['currency'] = pq($cell)->html();
    }
}

// Parse fuel prices
$counter = 0;
foreach ($body['tr'] as $row) {
    $counter++;
    $result['date'] = cleanString(pq($row)->find('td.value:eq(0)')->html());

    if (
        ($_GET['fuel'] == 'gasoline' && $counter === 1) ||
        ($_GET['fuel'] == 'diesel' && $counter === 2) ||
        ($_GET['fuel'] == 'lpg' && $counter === 3)
    ) {
        $result['regional']['price'] = cleanString(pq($row)->find('td.value:eq(1)')->html());
        $result['default']['price'] = cleanString(pq($row)->find('td.value:eq(2)')->html());
    }
}

die(json_encode($result));
