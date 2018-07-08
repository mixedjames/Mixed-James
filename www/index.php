<?php
  require('php/get-article.php');
  require('php/article-index.php');

  $AJAX_REQUEST = false;
  $FILE_REQUEST = false;
  $CATEGORY_REQUEST = false;
  $ARTICLE_CLASSES = '';
  $ARTICLE_TITLE_BASE = 'MixedJames.co.uk';
  $ARTICLE_TITLE = $ARTICLE_TITLE_BASE;

  if (isset($_GET['ajax'])) {
    $AJAX_REQUEST = $_GET['ajax'] == 'true';
  }

  if (isset($_GET['f'])) {
    $FILE_REQUEST = $_GET['f'];
  }

  if (isset($_GET['cat']) && $_GET['cat'] != 'latest') {
    $CATEGORY_REQUEST = $_GET['cat'];
  }

  if (!$AJAX_REQUEST) {
    if ($FILE_REQUEST) {
      $p = GetArticleProperties($FILE_REQUEST);
      $ARTICLE_TITLE = $p['title'] . ' - ' . $ARTICLE_TITLE_BASE;

      $classes = explode(' ', $p['keywords']);
      foreach ($classes as $i => $cls) {
        $classes[$i] = 'tag-' . $cls;
      }
      $ARTICLE_CLASSES = implode(' ', $classes);
    }

    require('parts/header.php');
  }

  if ($FILE_REQUEST) {
    echo(GetArticle($FILE_REQUEST));
  }
  else if ($CATEGORY_REQUEST) {
    if ($AJAX_REQUEST) {
      echo(json_encode(ArticleIndex($CATEGORY_REQUEST)));
    }
    else {

      if (file_exists('parts/' . $CATEGORY_REQUEST . '.php')) {
        include('parts/' . $CATEGORY_REQUEST . '.php');
      }

      //OutputArticles(ArticleIndex($CATEGORY_REQUEST));

    }
  }
  else {
    if ($AJAX_REQUEST) {
      echo(json_encode(ArticleIndex()));
    }
    else {
      if (file_exists('parts/home.php')) {
        include('parts/home.php');
      }

      //OutputArticles(ArticleIndex());
    }
  }

  if (!$AJAX_REQUEST) {
    require('parts/footer.php');
  }
?>
