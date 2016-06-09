<?php
require_once('TwitterAPIExchange.php');
function checkPosts() {
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
'oauth_access_token' => "",
'oauth_access_token_secret' => "",
'consumer_key' => "",
'consumer_secret' => ""
);
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";
if (isset($_GET['user']))  {$user = $_GET['user'];}  else {$user  = "realDonaldTrump";}
if (isset($_GET['count'])) {$count = $_GET['count'];} else {$count = 1;}
$getfield = "?screen_name=$user&count=$count&include_rts=false";
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
foreach($string as $items)
    {
        echo "<br/>";
        $lasttweet = file_get_contents('FILE HERE');
        $tweet_id = $items['id_str'];
        echo "last tweet was ";
        echo $lasttweet;
        echo " this tweet is ";
        echo $tweet_id;
        echo "<br/>";
        if ($lasttweet != $tweet_id){
        	echo "Tweet ID: ".$items['id_str']."<br />";
            echo "Tweet: ". $items['text']."<br />";
            echo "Tweeted by: ". $items['user']['name']."<br />";
            echo "Screen name: ". $items['user']['screen_name']."<br />";
        	$lasttweet = $tweet_id;
        	$file = 'FILE HERE';
        	file_put_contents($file, $tweet_id);
        	$lyrics = array("@realDonaldTrump Bawitdaba, da bang, da dang diggy diggy",
        		"@realDonaldTrump diggy, said the boogie, said up jump the boogie",
        		"@realDonaldTrump Bawitdaba da bang da bang diggy diggy diggy",
        		"@realDonaldTrump Shake the boogie said up jump the boogie",
        		"@realDonaldTrump And this is for the questions that don't have an answer",
        		"@realDonaldTrump The midnight glances And the topless dancers",
        		"@realDonaldTrump The can of freaks Cars packed with speakers",
        		"@realDonaldTrump The g's with the forty's And the chicks with beepers",
        		"@realDonaldTrump The northern lights And the southern comfort",
        		"@realDonaldTrump And it don't even matter if your veins are punctured",
        		"@realDonaldTrump All you bastards at the i.r.s. For the crooked cops and the cluttered desks",
        		"@realDonaldTrump For the shots of jack and the caps of meth Half pints of love and a fifth of stress",
        		"@realDonaldTrump I said it's all good and it's all in fun Now get in the pit and try to love someone!",
        		"@realDonaldTrump Wild mustangs The porno flicks All my homies in the county in cell block six",
        		"@realDonaldTrump The grits when there ain't enough eggs to cook And to d.b. cooper and the money he took",
        		"@realDonaldTrump You can look for answers but that ain't fun Now get in the pit and try to love someone!",
        		"@realDonaldTrump Bawitdaba, da bang, da dang diggy diggy",
        		"@realDonaldTrump diggy, said the boogie, said up jump the boogie"
        		);
        	$krtpics = array ('kid-rock-trump-1.jpg','kid-rock-trump-2.jpg','kid-rock-trump-3.jpg','kid-rock-trump-4.jpg','kid-rock-trump-5.jpg','kid-rock-trump-6.jpg','kid-rock-trump-7.jpg','kid-rock-trump-8.jpg','kid-rock-trump-9.jpg');
			$tweet_content = (array_rand($lyrics,1));
			$media_content = (array_rand($krtpics,1));
			echo $lyrics[$tweet_content];
            $twitter2 = new TwitterAPIExchange($settings);
            $url = 'https://upload.twitter.com/1.1/media/upload.json';
             $file = file_get_contents($krtpics[$media_content]);
             $data = base64_encode($file);
        $params = array(
            'media_data' => $data
        );
           $requestMethod2 = 'POST';
           $response = $twitter2->buildOauth($url, $requestMethod2)
            ->setPostfields($params)
             ->performRequest();
           echo $response;
            $response2 = json_decode($response);
            $cleanid = $response2->{'media_id'};
            echo $cleanid;
         //do the tweet
          $url = 'https://api.twitter.com/1.1/statuses/update.json';
            $postData = array('status' => $lyrics[$tweet_content], 'in_reply_to_status_id' =>$items['id_str'], 'media_ids' => $cleanid);
          echo $twitter2->buildOauth($url, $requestMethod2)
            ->setPostfields($postData)
             ->performRequest();
        }
    }
}
$timervar = 0;
while($timervar == 0) {
    checkPosts();
    sleep(5);
} 
?>