<!DOCTYPE html>
<html>
<head>

  <title><?php echo $ARTICLE_TITLE; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="css/styles.css" type="text/css">
  <link
    rel="stylesheet"
    href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
    integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
    crossorigin="anonymous">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Gentium+Basic" rel="stylesheet">

</head>
<body>

  <nav class="header">

    <div class="mobile-header">
      <div class="left">
      MixedJames.co.uk
      </div>

      <div class="right-mobile">
        <a href="?cat=latest"><i class="fa fa-bars"></i></a>
      </div>

      <div class="right-desktop">
        <a href="javascript:void(0);" id="fullscreen"><i class="fa fa-expand-arrows-alt"></i></a>
      </div>
    </div>

  </nav>

  <nav class="side">
    <a href="?cat=latest">
      <i class="fa fa-newspaper"></i>
      <h1>Home</h1>
    </a>

    <a href="?cat=meducation">
      <i class="fa fa-user-md"></i>
      <h1>Medicine</h1>
      <p>Medical education resources.</p>
      <p class="aside">"Stuff I've learnt on the
      way to becoming a doctor..."</p>
    </a>

    <a href="?cat=computers">
      <i class="fa fa-rocket"></i>
      <h1>Computers</h1>
      <p>Programming thoughts etc.</p>
    </a>

    <a href="?cat=misc">
      <i class="fa fa-lightbulb"></i>
      <h1>Other</h1>
      <p>Ideas, thoughts & miscellany.</p>
      <p class="aside">"Stuff that someone with more time than me
      should do!"</p>
    </a>
  </nav>

  <nav class="footer">

    <div class="mobile-footer-links">
      <a href="?cat=meducation"><i class="fa fa-user-md"></i>Medicine</a>
      <a href="?cat=computers"><i class="fa fa-rocket"></i>Computers</a>
      <a href="?cat=misc"><i class="fa fa-lightbulb"></i>Other</a>
    </div>

  </nav>

  <article class="<?php echo $ARTICLE_CLASSES ?>">
