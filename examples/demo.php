<?php
include_once('config.php');
require_once __DIR__ . '/../autoload.php';
$sentiment = new \PHPInsight\Sentiment();

$strings = array(
	1 => 'Weather today is rubbish',
	2 => 'This cake looks amazing',
	3 => 'His skills are mediocre',
	4 => 'He is very talented',
	5 => 'She is seemingly very agressive',
	6 => 'Marie was enthusiastic about the upcoming trip. Her brother was also passionate about her leaving - he would finally have the house for himself.',
	7 => 'To be or not to be?',
);

try {
    $bdd = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME.';charset=utf8', DBUSER, DBPASS);
    $stmt = $bdd->prepare("SELECT * FROM tweets LEFT JOIN author_tweet ON tweets.id_author_tweet = author_tweet.id_author_tweet");
    $stmt->execute();
    $donnees = $stmt->fetchAll();
    }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
$tweets = [];
foreach ($donnees as $tweet) {
    $tweet["tweet_sentiment_categorise"] = $sentiment->categorise($tweet["tweet_text"]);
    if ($tweet["tweet_sentiment_categorise"] == "neg") {
        $tweet["tweet_sentiment_categorise"] = "negatif";
        $tweet["color"] = "#d9534f";
    }   
    else if ($tweet["tweet_sentiment_categorise"] == "pos"){
        $tweet["tweet_sentiment_categorise"] = "positif";
        $tweet["color"] = "#5cb85c";   
    }
    else if ($tweet["tweet_sentiment_categorise"] == "neu"){
        $tweet["tweet_sentiment_categorise"] = "neutre";
        $tweet["color"] = "#fff702";
    }  
    $tweets[] = $tweet;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Lang" content="en">
    <title>Datumbox Twitter Sentiment Analysis Demo</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="./style.css">
</head>
<body>


<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Data API</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <!--                <li class="active">Results for -->
                <?php //echo count($results); ?><!-- tweets</li>-->
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!--                <li><a href="../navbar/">Default</a></li>-->
                <!--                <li><a href="../navbar-static-top/">Static top</a></li>-->
                <!--                <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>-->
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    <div class="col-lg-12" style="margin-top: 50px;">
        <div class="data-info">
            <div id="table1_wrapper" class="dataTables_wrapper no-footer">
                <div class="toolbar tool1">
                    <h5 class="zero-m">Results for <?php echo count($results); ?> tweets</h5>
                </div>
                <table id="table1"
                       class="display datatable table-striped table dataTable no-footer dtr-inline table-hover"
                       role="grid">
                    <thead>
                    <tr role="row">
                        <th>Id Tweet</th>
                        <th style="min-width: 100px">Nom d'utilisateur</th>
                        <th>Text</th>
                        <th>Date du post</th>
                        <th>Sentiment</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($tweets as $tweet){
                    ?>
                    <tr role="row" class="odd">
                            <?php echo "<td style='border-left: 3px solid ".$tweet["color"].";'>".$tweet["id_tweet"]."</td>"; ?>
                            <td> <?php echo $tweet["tweet_author_name"] ?></td>
                            <td> <?php echo $tweet["tweet_text"] ?> </td>
                            <td> <?php echo $tweet["tweet_created_at"] ?></td>
                            <td> <?php echo $tweet["tweet_sentiment_categorise"] ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="../../dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>


</body>
</html>