<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JSKOS-PHP Examples</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  </head>
  <body>
<a href="https://github.com/gbv/jskos-php-examples"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/e7bbb0521b397edbd5fe43e7f760759336b5e05f/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f677265656e5f3030373230302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_green_007200.png"></a>
    <div class="container">

<h1>JSKOS-PHP Examples</h1>
<p>
    This page provides sample applications and services that make use of 
    <a href="http://gbv.github.io/jskos">JSKOS data format for Knowledge Organization Systems</a>.
    All examples are written in PHP, based on 
    <a href="https://packagist.org/packages/gbv/jskos">JSKOS PHP library</a>, and available
    as Open Source <a href="https://github.com/gbv/jskos-php-examples">at GitHub</a>. Please use
    <a href="https://github.com/gbv/jskos-php-examples/issues">the issue tracker</a> for feedback!
</p>
<h2>Terminology Services</h2>
<p>
    The following web services wrap existing terminology databases to provide
    access via <a href="https://gbv.github.io/jskos-api">JSKOS-API</a>.
    JSKOS-API is far from being finally specified, so this is a preview.
</p>
<?php

include '../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;
$services = Yaml::parse(file_get_contents('services.yaml'));

foreach ($services as $name => $service) { 
    $source = "src/lib/${name}Service.php";
?>
    <h3><?= $name ?><small>
      &nbsp;
      <a href='https://github.com/gbv/jskos-php-examples/blob/master/<?= $source ?>'>
       <i class="fa fa-github"></i> source</a>
    </small>
    </h2>
<?php if ($service['about'] or $service['url']) { ?>
    <p>
        <span class="glyphicon glyphicon-arrow-right"></span>
        <?php if ($service['url']) echo "<a href='".$service['url']."'>"; ?>
        <?= htmlspecialchars($service['about'] ? $service['about'] : $service['url']); ?>
        <?php if ($service['url']) echo "</a>"; ?>
    </p> 
<?php } 
    $queryExamples= $service['examples'];
    if ($queryExamples) {
        echo "<table class='table table-condensed'>";
        echo "<thead><tr><th>sample queries to <a href='$name.php'>JSKOS-API endpoint</a></th></tr></thead>";
        echo "<tr>";
        foreach ($queryExamples as $query) {
            $query = http_build_query($query);
            echo "<td>";
            echo "<a href='".htmlentities("$name.php?$query")."'>";
            echo "?".htmlentities(urldecode($query));
            echo "</a></td></tr>";
        }
        echo "</table>";
    } else {
        echo "<a href='$name.php'>service endpoint</a>";
    }
    echo "</p>";
}
?>

<hr>
<a href="https://travis-ci.org/gbv/jskos-php-examples">
  <img src="https://travis-ci.org/gbv/jskos-php-examples.svg?branch=master">
</a>
<a href="https://coveralls.io/r/gbv/jskos-php-examples">
  <img src="https://coveralls.io/repos/github/gbv/jskos-php-examples/badge.svg?branch=master">
</a>

    </div>
  </body>
</html>
