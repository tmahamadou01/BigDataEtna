<?php
include_once(dirname(__FILE__).'/DatumboxAPI.php');
include_once(dirname(__FILE__).'/config.php');


class TwitterSentimentAnalysis {

    public function __construct(){

    }

    public function sentimentAnalysis() {
        $tweets=$this->getTweets();

        return $this->findSentiment($tweets);
    }

    public function getTweets() {
        try
        {
            $bdd = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME.';charset=utf8', DBUSER, DBPASS);
            $stmt = $bdd->prepare("SELECT * FROM tweets LEFT JOIN author_tweet ON tweets.id_author_tweet = author_tweet.id_author_tweet LIMIT 1");
            $stmt->execute();
            $donnees = $stmt->fetchAll();
            return $donnees;
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
    }

    protected function findSentiment($tweets) {
        $DatumboxAPI = new DatumboxAPI(datumbox_api_key); //initialize the DatumboxAPI client
        $results=array();
        foreach($tweets as $tweet) { //foreach of the tweets that we received
            // if(isset($tweet['metadata']['iso_language_code'])) { //perform sentiment analysis only for the English Tweets
            $sentiment=$DatumboxAPI->TwitterSentimentAnalysis($tweet['tweet_text']); //call Datumbox service to get the sentiment
//            if($sentiment == false) { //if the sentiment is not false, the API call was successful.
                $results[]=array( //add the tweet message in the results
                    'id'=>$tweet['tweet_id'],
                    'user'=>$tweet['tweet_author_name'],
                    'text'=>$tweet['tweet_text'],
                    'url'=>'https://twitter.com/'.$tweet['tweet_author_name'].'/status/'.$tweet['tweet_id'],
                    'sentiment'=>$sentiment ? "Positif" : "Négatif"
                );
//            }
            // }

        }

        unset($tweets);
        unset($DatumboxAPI);

        //var_dump($results);
        //die();
        return $results;
    }
}
