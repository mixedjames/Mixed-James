<?php

if (!isset($_GET['rId'])) {
  die('rId not specified.');
}

if (!isset($_GET['f'])) {
  die('f not specified.');
}

if (isset($_GET['n'])) {
  $zip = new ZipArchive();
  $path = '../articles/' . $_GET['f'] . '.zip';

  if($zip->open($path, 0)) {
    $resourcePath = $_GET['n'];
    $resourcePath = substr($resourcePath, 0 , (strrpos($resourcePath, "."))) . ".svg";

    $svgStream = $zip->getStream($resourcePath);
    if ($svgStream) {
      header("Content-Type: image/svg+xml");
      header("Content-Length: " . $zip->statName($resourcePath)['size']);

      fpassthru($svgStream);
      exit;
    }

  }
}

$zip = new ZipArchive();
$docxPath = '../articles/' . $_GET['f'] . '.docx';
if($zip->open($docxPath, 0) !== TRUE) {
  die('Failed to open "'.$docxPath.'"');
}

$relationships = new DOMDocument();
if ($relationships->loadXML($zip->getFromName('word/_rels/document.xml.rels')) !== TRUE) {
  die('Failed to load "'.$_GET['f'].'" (code = 1)');
}

$rIdQuery = new DOMXPath($relationships);
$rIdQuery->registerNamespace('w', 'http://schemas.openxmlformats.org/package/2006/relationships');
$relationships = $rIdQuery->query('/w:Relationships/w:Relationship[@Id = \''.$_GET['rId'].'\']');

if ($relationships->length == 0) {
  die('Failed to load "'.$_GET['f'].'" (code = 2)');
}

$target = $relationships->item(0)->attributes->getNamedItem('Target');
if (!$target) {
  die('Failed to load "'.$_GET['f'].'" (code = 3)');
}

header("Content-Type: " . GuessMimeType($target->value));
header("Content-Length: " . $zip->statName('word/' . $target->value)['size']);

fpassthru($zip->getStream('word/' . $target->value));
exit;

function GuessMimeType($filename) {
  switch(pathinfo($filename)['extension']) {
  case 'png':
    return 'image/png';

  case 'jpeg':
  case 'jpg':
    return 'image/jpeg';

  default:
    return 'application/octet-stream';
  }
}