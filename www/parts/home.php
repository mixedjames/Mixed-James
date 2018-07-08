<?php echo GetArticle('home'); ?>

<div class="articles">

<?php

    foreach(ArticleIndex() as $article) {
      $cd = strtotime($article['dateCreated']);
?>

      <a href="?f=<?php echo($article['url']); ?>">
      <h3><?php echo($article['title']); ?></h3>
      <p class="date-posted"><?php echo($article['dateCreated']); ?></p>
      <p class="description"><?php echo($article['description']); ?></p>
      </a>

<?php
    }
?>

</div>