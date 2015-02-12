<?php

$twitter_username = "Envato"; 											// <- Your twitter Username
$consumerkey = "NUpqyogOrudpewmXjsa1w"; 								// <- Your Consumer key
$consumersecret = "guBaK4hoLTaPPxUt6DjSnid6RTNXXTvUzqDavhvM"; 			// <- Your Consumer Secret
$accesstoken = "491190981-AMje5HGKBsOBQBefYywDV1sOf0awdV095lcXFwQn"; 	// <- Your Access Token
$accesstokensecret = "T2q6Q9TfdRmubaPGqsiiFcrH1aYvCa8XNJURLgpS9wQ"; 	// <- Your Access Token Secret
$tweets_number = 10; 													// <- How many tweets you want to retrieve

session_start();
require_once("twitteroauth/twitteroauth.php");

function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
	$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
	return $connection;
}

$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);

$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitter_username."&count=".$tweets_number);

// http://css-tricks.com/snippets/php/time-ago-function/
function ago($time) {
	$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	$lengths = array("60","60","24","7","4.35","12","10");

	$now = time();
	    $difference    = $now - $time;
	    $tense         = "ago";

	for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
	    $difference /= $lengths[$j];
	}

	$difference = round($difference);

	if($difference != 1) {
	    $periods[$j].= "s";
	}

	return "$difference $periods[$j] ago ";
}
?>

<div class="tweet-box">
	<div id="twitter-carousel" class="carousel slide">
		<div class="carousel-inner">
		<?php
		$first = true;
		foreach($tweets as $tweet) {
			if ($first) { ?>
				<div class="item active">
				<p>
				<?php
				$latestTweet = $tweet->text;
				$latestTweet = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '&nbsp;<a href="http://$1" target="_blank">http://$1</a>&nbsp;', $latestTweet);
				$latestTweet = preg_replace('/@([a-z0-9_]+)/i', '&nbsp;<a href="http://twitter.com/$1" target="_blank">@$1</a>&nbsp;', $latestTweet);
				echo $latestTweet; ?>
				</p>
				<?php
				$twitterTime = strtotime($tweet->created_at);
				$timeAgo = ago($twitterTime);
				?>
				<a href="http://twitter.com/<?php echo $tweet->user->name; ?>/statuses/<?php echo $tweet->id_str; ?>"><?php echo $timeAgo; ?></a>
				</div>
				<?php
				$first = false;
			} else { ?>
				<div class="item">
				<p>
				<?php
				$latestTweet = $tweet->text;
				$latestTweet = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '&nbsp;<a href="http://$1" target="_blank">http://$1</a>&nbsp;', $latestTweet);
				$latestTweet = preg_replace('/@([a-z0-9_]+)/i', '&nbsp;<a href="http://twitter.com/$1" target="_blank">@$1</a>&nbsp;', $latestTweet);
				echo $latestTweet; ?>
				</p>
				<?php
				$twitterTime = strtotime($tweet->created_at);
				$timeAgo = ago($twitterTime);
				?>
				<a href="http://twitter.com/<?php echo $tweet->user->name; ?>/statuses/<?php echo $tweet->id_str; ?>"><?php echo $timeAgo; ?></a>
				</div>
				<?php 
			}
		}
		?>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function () {
	"use strict";
	$("#twitter-carousel").carousel({interval: 3000});
});
</script>
<?php 
?>