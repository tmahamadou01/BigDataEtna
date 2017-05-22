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

   <div class="container">
           <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                   <h1>Datumbox Twitter Sentiment Analysis</h1>
                   <p>Type your keyword below to perform Sentiment Analysis on Twitter Results:</p>
                    <form action="#" method="get">
                      <div class="form-group">
                        <label for="email">Entrez un mot :</label>
                        <input type="text" name="q" placeholder="Saisissez votre mot" class="form-control"></input><br/>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Chercher"></input>
                   </form>
                </div>
               <div class="col-md-2"></div>
           </div>
       </div>

   <?php

    if(isset($_GET['q']) && $_GET['q']!='') {
      echo "Welcome: ". $_GET['q']. "<br />";
      //die();
    include_once(dirname(__FILE__).'/config.php');
    include_once(dirname(__FILE__).'/TwitterSentimentAnalysis.php');

    $TwitterSentimentAnalysis = new TwitterSentimentAnalysis('859f0a4bfad7984c584e1e6f085b7052', 'NSxE5Xq6nLtVO2RBnX5ykfdYt','eHKPsU4EYLvLRFywXY6gfraB3AvqCqdB7fvBpPEz8YjNH06vHV', '957526753-1tmAYr0tAmfjenV7XzQurwSm66pKzGd7uDquVEJQ', 'O5baEXhvdcW1VohTNROn5quG79InN6fPLgV0XKFtPbZCu');
    var_dump($TwitterSentimentAnalysis);
    $twitterSearchParams=array(
        'q'=>$_GET['q'],
        'lang'=>'en',
        'count'=>10,
    );
    //die("je marrete");
    $results=$TwitterSentimentAnalysis->sentimentAnalysis($twitterSearchParams);
    //var_dump($results);
    //die();
    ?>
    <h1>Results for "<?php echo $_GET['q']; ?>"</h1>
    <table border="1">
        <tr>
            <td>Id</td>
            <td>User</td>
            <td>Text</td>
            <td>Twitter Link</td>
            <td>Sentiment</td>
        </tr>
        <?php
        foreach($results as $tweet) {
            var_dump($tweet);
            $color=NULL;
            if($tweet['sentiment']=='true') {
                $color='#00FF00';
            }
            else if($tweet['sentiment']=='false') {
                $color='#FF0000';
            }
            else if($tweet['sentiment']=='neutral') {
                $color='#FFFFFF';
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
    <?php
    }
   ?>
   
   <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>