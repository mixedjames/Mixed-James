<?php echo GetArticle('computers'); ?>

<h2>Series</h2>
<div class="articles">
  <a href="?cat=software-rendering">
    <h3>James' Guide to Software Rendering</h3>
    <p class="description">A series of articles about how 3d rendering
    on a computer really works.</p>
  </a>
</div>

<h2>Articles (by date order)</h2>
<div class="articles">

<?php

    foreach(ArticleIndex('computers') as $article) {
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