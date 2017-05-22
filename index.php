<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Lang" content="en">
    <title>Datumbox Twitter Sentiment Analysis Demo</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<?php
include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/TwitterSentimentAnalysis.php');

$TwitterSentimentAnalysis = new TwitterSentimentAnalysis();

$results = $TwitterSentimentAnalysis->sentimentAnalysis();
?>
<h1>Results for <?php echo count($results); ?> tweets</h1>
<table border="1">
    <tr>
        <td>Id</td>
        <td>User</td>
        <td>Text</td>
        <td>Twitter Link</td>
        <td>Sentiment</td>
    </tr>
    <?php
    foreach ($results as $tweet) {
        var_dump($tweet);
        $color = NULL;
        if ($tweet['sentiment'] == 'true') {
            $color = '#00FF00';
        } else if ($tweet['sentiment'] == 'false') {
            $color = '#FF0000';
        } else if ($tweet['sentiment'] == 'neutral') {
            $color = '#FFFFFF';
        }
        ?>
        <tr style="background:<?php echo $color; ?>;">
            <td><?php echo $tweet['id']; ?></td>
            <td><?php echo $tweet['user']; ?></td>
            <td><?php echo $tweet['text']; ?></td>
            <td><a href="<?php echo $tweet['url']; ?>" target="_blank">View</a></td>
            <td><?php echo $tweet['sentiment']; ?></td>
        </tr>
        <?php
    }
    die();
    ?>
</table>
?>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>