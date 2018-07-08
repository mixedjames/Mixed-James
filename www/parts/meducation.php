<?php echo GetArticle('meducation'); ?>

<h2>Articles</h2>
<?php OutputArticles(ArticleIndex(array('meducation', 'article'))); ?>

<h2>James' Notes</h2>
<?php OutputArticles(ArticleIndex(array('meducation', 'notes'))); ?>

<?php
  function OutputArticles($articles) {
?>
<div class="articles">

<?php
    foreach($articles as $article) {
      $cd = strtotime($article['dateCreated']);
?>

      <a href="?f=<?php echo($article['url']); ?>">
      <h3><?php echo($article['title']); ?></h3>
      <p class="date-posted"><?php echo($article['dateCreated']); ?></p>
      <p class="description"><?php echo($article['description']); ?></p>
      </a>

<?php
    }
  }
?>

</div>