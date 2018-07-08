<?php

function ConvertEndnotes($targetXmlDocument, $docxZipFile) {
  $endnoteStream = $docxZipFile->getFromName('word/endnotes.xml');
  $endnoteRelsStream = $docxZipFile->getFromName('word/_rels/endnotes.xml.rels');

  if ($endnoteStream) {
    $targetXPath = new DOMXPath($targetXmlDocument);
    $processor = new XSLTProcessor();
    $src = new DOMDocument();
    $stylesheet = new DOMDocument();
    $rels = new DOMDocument();

    $src->loadXML($endnoteStream);
    $stylesheet->load('word2html/word2html_endnotes.xml');

    $processor->importStylesheet($stylesheet);

    $output = $processor->transformToDoc($src);

    if ($endnoteRelsStream) {
      $rels->loadXML($endnoteRelsStream);
      ConvertAndExtractImages($output, $docxZipFile, $rels, $paths);
      ConvertLinks($output, $rels);
    }

    $endnodeNode = $targetXmlDocument->importNode($output->documentElement, TRUE);
    $endnoteDst = $targetXPath->query("//section[contains(@class, 'endnotes')]")->item(0);
    $endnoteDst->parentNode->replaceChild($endnodeNode, $endnoteDst);
  }
}

?>