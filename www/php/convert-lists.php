<?php

/*
 * Reference: https://msdn.microsoft.com/en-us/library/ee922775(office.14).aspx#odc_Office14_ta_WorkingWithNumbering_MarkupSimpleBulleted
 */

function ConvertLists($htmlXmlDocument, $docxZipFile) {

  $src = new DOMDocument();
  $xmlString = $docxZipFile->getFromName('word/numbering.xml');
  if (strlen($xmlString) == 0) {
    return;
  }

  $src->loadXML($xmlString);

  $olQuery = new DOMXPath($htmlXmlDocument);
  $numberingQuery = new DOMXPath($src);
  $numberingQuery->registerNamespace('w', 'http://schemas.openxmlformats.org/package/2006/relationships');

  $lists = $olQuery->query('//ol');
  for ($i = $lists->length; $i --;) {
    $lId = $lists->item($i)->attributes->getNamedItem('numId')->value;
    $lLevel = $lists->item($i)->attributes->getNamedItem('listLevel')->value;

    $numElement = $numberingQuery->query('w:num[@w:numId= '. $lId .']/w:abstractNumId');
    if ($numElement->length == 0) { continue; }

    $anId = $numElement->item(0)->attributes->getNamedItem('val')->value;

    $aNumElement = $numberingQuery->query('w:abstractNum[@w:abstractNumId = '.$anId.']/w:lvl[@w:ilvl = '.$lLevel.']/w:numFmt');
    if ($aNumElement->length == 0) { continue; }

    $listType = $aNumElement->item(0)->attributes->getNamedItem('val')->value;

    $lists->item($i)->setAttribute('class', $listType . '-list');
    $lists->item($i)->removeAttribute('numId');
    $lists->item($i)->removeAttribute('listId');
    $lists->item($i)->removeAttribute('listLevel');
  }
}

?>