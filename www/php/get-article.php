<?php

require_once('convert-lists.php');
require_once('convert-endnotes.php');

function GetArticleProperties($f) {
  $zip = new ZipArchive();
  if ($zip->open('articles/' . $f . '.docx', 0) !== TRUE) {
    throw new Exception('Unable to open file "' . $f . '"');
  }

  $docProps = new DOMDocument();
  $docProps->loadXML($zip->getFromName('docProps/core.xml'));

  $query = new DOMXPath($docProps);
  $query->registerNamespace('cp', 'http://schemas.openxmlformats.org/package/2006/metadata/core-properties');
  $query->registerNamespace('dc', 'http://purl.org/dc/elements/1.1/');
  $query->registerNamespace('dcterms', 'http://purl.org/dc/terms/');
  $query->registerNamespace('dcmitype', 'http://purl.org/dc/dcmitype/');
  $query->registerNamespace('xsl', 'http://www.w3.org/2001/XMLSchema-instance');

  // <cp:keywords>, <dc:title>, <dc:description>
  $title = $query->query('/cp:coreProperties/dc:title')->item(0)->nodeValue;
  $keywords = $query->query('/cp:coreProperties/cp:keywords')->item(0)->nodeValue;
  $description = $query->query('/cp:coreProperties/dc:description')->item(0)->nodeValue;
  $dateCreated = $query->query('/cp:coreProperties/dcterms:created')->item(0)->nodeValue;
  $dateUpdated = $query->query('/cp:coreProperties/dcterms:modified')->item(0)->nodeValue;

  return array(
    'title' => $title,
    'keywords' => $keywords,
    'description' => $description,
    'dateCreated' => $dateCreated,
    'lastModified' => $dateUpdated
  );
}

function GetArticle($f) {
  $zip = new ZipArchive();
  if ($zip->open('articles/' . $f . '.docx', 0) !== TRUE) {
    throw new Exception('Unable to open file "' . $f . '"');
  }

  $processor = new XSLTProcessor();
  $src = new DOMDocument();
  $stylesheet = new DOMDocument();

  $src->loadXML($zip->getFromName('word/document.xml'));
  $stylesheet->load('word2html/word2html.xml');

  $processor->setParameter('', 'sourceFile', $f);
  $processor->importStylesheet($stylesheet);
  $html = $processor->transformToDoc($src);

  ConvertLists($html, $zip);
  ConvertEndnotes($html, $zip);

  $zip->close();

  //return $processor->transformToXML($src);
  return $html->saveHTML();
}