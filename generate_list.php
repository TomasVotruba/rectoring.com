<?php

declare(strict_types = 1);

// Please keep these in alphabetical order
$languagesAndNamedLinks = [
    'Hacklang' => [
        'hhast' => 'https://github.com/hhvm/hhast#migrations'
    ]
    'PHP' => [
        'Rector' => 'https://getrector.org/'
    ],
    'Python' => [
        'Bowler' => 'https://pybowler.io/',
        'Rope' => 'https://github.com/python-rope/rope'
    ],
    'TypeScript' => [
        'tsmod' => 'https://github.com/WolkSoftware/tsmod',
        'vscode-refactorix' => 'https://github.com/krizzdewizz/vscode-refactorix',
    ]
];

$beginMarker = "<!-- List begin -->";
$endMarker = "<!-- List end -->";

$linksHtml = "\n";
$linksHtml .= "  <ul>\n";

foreach ($languagesAndNamedLinks as $language => $namedLinks) {
    $linksHtml .= "    <li>" . $language . "\n";
    $linksHtml .= "      <ul>\n";
    foreach ($namedLinks as $name => $link) {
        $linksHtml .= sprintf(
            "        <li><a href='%s'>%s</a></li>\n",
            $link,
            $name
        );
    }

    $linksHtml .= "      </ul>\n";
    $linksHtml .= "    </li>\n";
}

$linksHtml .= "  </ul>\n";
$linksHtml .= "\n";


$fileContents = file_get_contents(__DIR__ . "/index.html");

if ($fileContents === false) {
    echo "Failed to open index.html";
    exit(-1);
}

$beginMarkerPosition = strpos($fileContents, $beginMarker);
$endMarkerPosition = strpos($fileContents, $endMarker);

if ($beginMarkerPosition === false) {
    echo "Failed to find begin marker [$beginMarker]";
    exit(-1);
}

if ($endMarkerPosition === false) {
    echo "Failed to find begin marker [$endMarker]";
    exit(-1);
}

if ($endMarkerPosition <= $beginMarkerPosition) {
    echo "Error, end marker is before begin marker.";
    exit(-1);
}

$beforeContent = substr($fileContents, 0, $beginMarkerPosition + strlen($beginMarker));
$afterContent = substr($fileContents, $endMarkerPosition);

$newContents = $beforeContent . $linksHtml . $afterContent;

$written = file_put_contents(__DIR__ . "/index.html", $newContents);
if ($written === false) {
    echo "Probably failed to write index.html\n";
    exit(-1);
}

echo "Fin.\n";
