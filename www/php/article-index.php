<?php
function ArticleIndex($hasTag = NULL) {

  $source = realpath('articles');
  $urlBase = '';

  $rdi = new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS);
  $i = new RecursiveIteratorIterator(
    $rdi,
    RecursiveIteratorIterator::SELF_FIRST,
    RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
  );

  $sourcePathParts = count(explode(DIRECTORY_SEPARATOR, realpath($source)));
  $json = array();

  foreach ($i as $path => $dir) {

    if (pathinfo($path, PATHINFO_EXTENSION) != 'docx') {
      continue;
    }

    $pathRelativeToSource = array_slice(
      explode(DIRECTORY_SEPARATOR, $dir->getPath()),
      $sourcePathParts
    );

    $url = implode('/', $pathRelativeToSource);

    if ($result = IndexFile($path, $url, $hasTag)) {
      $json[] = $result;
    }
  }

  usort($json, 'CompareArticleCreateDate');

  return $json;
}

function CompareArticleCreateDate($a, $b) {
  $aTime = strtotime($a['dateCreated']);
  $bTime = strtotime($b['dateCreated']);

  return ($aTime < $bTime) ? 1 : -1;
}

function IndexFile($path, $url, $hasTag = NULL) {

  $zip = new ZipArchive();
  if ($zip->open($path, 0) !== TRUE) {
    //throw new Exception('Unable to open.');
    return FALSE;
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

  $zip->close();

  $keywordsArray = explode(' ', $keywords);
  if (in_array('hidden', $keywordsArray)) {
    return false;
  }

  if (isset($hasTag)) {
    if (is_string($hasTag) && !in_array($hasTag, $keywordsArray)) {
      return false;
    }
    else if (
      is_array($hasTag)
      && count(array_intersect($hasTag, $keywordsArray)) != count($hasTag)
    ) {
      return false;
    }
  }

  return array(
    'url' => $url . '/' . pathinfo($path, PATHINFO_FILENAME),
    'title' => $title,
    'keywords' => $keywords,
    'description' => $description,
    'dateCreated' => $dateCreated,
    'lastModified' => $dateUpdated
  );

} // function

?>