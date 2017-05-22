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

<?php
include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/TwitterSentimentAnalysis.php');

$TwitterSentimentAnalysis = new TwitterSentimentAnalysis();

$results = $TwitterSentimentAnalysis->sentimentAnalysis();
?>


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
                    foreach ($results as $tweet) {
                        if ($tweet['sentiment'] == "Positif") {
                            $color = "#1f9eba";
                        } else {
                            $color = "#f44336";
                        } ?>
                        <tr role="row" class="odd">
                            <td style="border-left: 3px solid <?php echo $color ?>"><a href="<?php echo $tweet['url']; ?>" target="_blank"><?php echo $tweet['id']; ?></a></td>
                            <td><?php echo $tweet['user']; ?></td>
                            <td><?php echo $tweet['text']; ?></td>
                            <td><span class="label label-default"><?php echo $tweet['date']; ?> <i
                                            class="zmdi zmdi-time"></i></span></td>
                            <td><?php echo $tweet['sentiment']; ?></td>
                        </tr>
                    <?php } ?>
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