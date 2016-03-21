<?php
/**
 * Twitter Feeds slider Widget
 */

if (!class_exists('doors_widget')) :

	class doors_widget extends WP_Widget
	{
		const TWEETS_COUNT = 5;
		const UPDATE_INTERVAL = 1800;
		const DATE_FORMAT = 'j F Y';
		const DISPLAY_DATE = TRUE;
		const LINKS_CLICKABLE = TRUE;
		const HIDE_ERRORS = TRUE;
		const ESCAPE_SPECIAL_CHARS = TRUE;

		private $wpHttp;

		function __construct()
		{
			$widget_ops = array('classname' => 'widget_twitter', 'description' => 'Display your latest tweets.');
			$this->WP_Widget('twitter-widget', 'Doors Twitter', $widget_ops);
			$this->wpHttp = new WP_Http();
		}

		function widget($args, $instance)
		{
			$before_widget = $after_widget = $before_title = $after_title = '';
			extract($args);

			global $updateInterval;

			// User-selected settings
			
			$consumerKey = !empty($instance['consumer_key']) ? $instance['consumer_key'] : '';
			$consumerSecret = !empty($instance['consumer_secret']) ? $instance['consumer_secret'] : '';
			$username = $instance['username'];
			$tweetsCount = $instance['posts'];
			$updateInterval = !empty($instance['update_interval']) ? $instance['update_interval'] : '';
			$hideErrors = $instance['hideerrors'];

			$printOptions = array(
				'dateFormat' => isset($instance['date']) ? $instance['date'] : self::DATE_FORMAT,
				'displayDate' => isset($instance['datedisplay']) ? $instance['datedisplay'] : FALSE,
				'linksClickable' => isset($instance['clickable']) ? $instance['clickable'] : FALSE,
				'escapeSpecialChars' => isset($instance['encodespecial']) ? $instance['encodespecial'] : FALSE
			);

			// Before widget (defined by themes)
			print($before_widget);

			// Set internal Wordpress feed cache update_interval, by default it's 12 hours or so
			add_filter('wp_feed_cache_transient_lifetime', array(&$this, 'getInterval'));
			include_once(ABSPATH . WPINC . '/feed.php');

			$cacheFile = $this->getCacheFile();

			// Title of widget (before and after defined by themes)
			if (!empty($title)) echo $before_title . $title . $after_title;

			$cacheFileIsInvalid = !file_exists($cacheFile) || (file_exists($cacheFile) && (filemtime($cacheFile) + $updateInterval) < time());
			if ($cacheFileIsInvalid) {
				try {
					$bearerToken = $this->getBearerToken($consumerKey, $consumerSecret);
					$tweets = $this->getTweets($bearerToken, $username, $tweetsCount);
					$html = $this->printTweets($tweets, $printOptions);
					$this->saveToCacheFile($html);
				} catch (DoorsException $exception) {
					if ($hideErrors) {
						$this->printCacheFile($cacheFile);
					} else {
						print($exception->getMessage());
					}
				}
			} else {
				$this->printCacheFile($cacheFile);
			}

			// After widget (defined by themes)
			print($after_widget);
		}

		function update($new_instance, $old_instance)
		{
			$instance = $old_instance;

			
			$instance['consumer_key'] = $new_instance['consumer_key'];
			$instance['consumer_secret'] = $new_instance['consumer_secret'];
			$instance['access_token'] = $new_instance['access_token_secret'];
			$instance['access_token_secret'] = $new_instance['access_token_secret'];
			$instance['username'] = $new_instance['username'];
			$instance['posts'] = $new_instance['posts'];
			$instance['update_interval'] = $new_instance['update_interval'];
			$instance['date'] = $new_instance['date'];
			$instance['datedisplay'] = $new_instance['datedisplay'];
			$instance['clickable'] = $new_instance['clickable'];
			$instance['hideerrors'] = $new_instance['hideerrors'];
			$instance['encodespecial'] = $new_instance['encodespecial'];

			// Delete the cache file when options were updated so the content gets refreshed on next page load
			$this->deleteCacheFile();

			return $instance;
		}


		function form($instance)
		{
			$defaults = array(
				'consumer_key' => '',
				'consumer_secret' => '',
				'access_token' => '',
				'access_token_secret' => '',
				'username' => '',
				'posts' => self::TWEETS_COUNT,
				'update_interval' => self::UPDATE_INTERVAL,
				'date' => self::DATE_FORMAT,
				'datedisplay' => self::DISPLAY_DATE,
				'clickable' => self::LINKS_CLICKABLE,
				'hideerrors' => self::HIDE_ERRORS,
				'encodespecial' => self::ESCAPE_SPECIAL_CHARS
			);
			$instance = wp_parse_args((array)$instance, $defaults);
			?>

        

        <p>
            <label for="<?php echo $this->get_field_id('consumer_key'); ?>">Consumer key:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('consumer_key'); ?>"
                   name="<?php echo $this->get_field_name('consumer_key'); ?>"
                   value="<?php echo $instance['consumer_key']; ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('consumer_secret'); ?>">Consumer secret:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('consumer_secret'); ?>"
                   name="<?php echo $this->get_field_name('consumer_secret'); ?>"
                   value="<?php echo $instance['consumer_secret']; ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('username'); ?>">Twitter username:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('username'); ?>"
                   name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo $instance['username']; ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('posts'); ?>">Number of posts to display</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('posts'); ?>"
                   name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('update_interval'); ?>">Update interval (in seconds):</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('interval'); ?>"
                   name="<?php echo $this->get_field_name('update_interval'); ?>" value="<?php echo $instance['update_interval']; ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('date'); ?>">Date format (see PHP <a
                    href="http://php.net/manual/en/function.date.php">date</a>):</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('date'); ?>"
                   name="<?php echo $this->get_field_name('date'); ?>" value="<?php echo $instance['date']; ?>">
        </p>

        <p>
            <input class="checkbox" type="checkbox"
			       <?php if ($instance['datedisplay']) echo 'checked="checked" '; ?>id="<?php echo $this->get_field_id('datedisplay'); ?>"
                   name="<?php echo $this->get_field_name('datedisplay'); ?>">
            <label for="<?php echo $this->get_field_id('datedisplay'); ?>">Display date</label>

            <br>

            <input class="checkbox" type="checkbox"
			       <?php if ($instance['clickable']) echo 'checked="checked" '; ?>id="<?php echo $this->get_field_id('clickable'); ?>"
                   name="<?php echo $this->get_field_name('clickable'); ?>">
            <label for="<?php echo $this->get_field_id('clickable'); ?>">Clickable URLs, names &amp; hashtags</label>

            <br>

            <input class="checkbox" type="checkbox"
			       <?php if ($instance['hideerrors']) echo 'checked="checked" '; ?>id="<?php echo $this->get_field_id('hideerrors'); ?>"
                   name="<?php echo $this->get_field_name('hideerrors'); ?>">
            <label for="<?php echo $this->get_field_id('hideerrors'); ?>">Hide error message if update fails</label>

            <br>

            <input class="checkbox" type="checkbox"
			       <?php if ($instance['encodespecial']) echo 'checked="checked" '; ?>id="<?php echo $this->get_field_id('encodespecial'); ?>"
                   name="<?php echo $this->get_field_name('encodespecial'); ?>">
            <label for="<?php echo $this->get_field_id('encodespecial'); ?>">HTML-encode special characters</label>
        </p>

		<?php
		}

		private function getBearerToken($consumerKey, $consumerSecret)
		{
			$bearerTokenCredentials = base64_encode(urlencode($consumerKey) . ':' . urlencode($consumerSecret));

			$postArgs = array(
				'headers' => array(
					'authorization' => "Basic $bearerTokenCredentials",
					'content-type' => 'application/x-www-form-urlencoded;charset=UTF-8',
					'content-length' => 29,
					'accept-encoding' => 'gzip'
				),
				'body' => 'grant_type=client_credentials'
			);
			$response = $this->wpHttp->post('https://api.twitter.com/oauth2/token', $postArgs);
                        
			if ($response['response']['code'] == 200) {
				$body = json_decode($response['body']);
				if (isset($body->token_type) && isset($body->access_token) && $body->token_type == 'bearer') {
					return $body->access_token;
				}
			}

			throw new DoorsException('Could not authenticate with Twitter: ' .
				$response['response']['code'] . ' ' . $response['response']['message']);
		}

		private function getTweets($bearerToken, $username, $count)
		{
			$getArgs = array(
				'headers' => array(
					'authorization' => "Bearer " . $bearerToken,
					'accept-encoding' => 'gzip'
				)
			);
			$response = $this->wpHttp
				->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=$username&count=$count", $getArgs);

			if ($response['response']['code'] == 200) {
				$tweets = json_decode($response['body']);
				return $tweets;
			}

			throw new DoorsException("Could not get tweets of Twitter user \"$username\":" .
				$response['response']['code'] . ' ' . $response['response']['message']);
		}

		private function printCacheFile()
		{
			$cacheFile = $this->getCacheFile();
			if (file_exists($cacheFile)) {
                                
				$result = @file_get_contents($cacheFile);
			}

			if (!empty($result)) {
				echo $result;
			}
		}

		private function printTweets($tweets, $options)
		{
			$html = '<div class="twitterholder text-center wow zoomIn animated" data-wow-delay="300ms" data-wow-duration="700ms">
					<div id="twitter_carousel" class="carousel slide carfade" data-ride="carousel">
                                        <div class="carousel-inner">';
                        $ti = 1;
			foreach ($tweets as $tweet) {
                                if($ti == 1){ $class= 'active';} else{$class='';}
				$html .= '<div class="item '.$class.'"><i class="fa fa-twitter white" style="font-size: 80px; margin-bottom: 35px;"></i>';

				$text = $tweet->text;
				$timestamp = strtotime($tweet->created_at);

				$isLessThanOneDayOld = (abs(time() - $timestamp)) < 86400;
				if ($isLessThanOneDayOld) {
					$timestamp = human_time_diff($timestamp) . ' ago';
				} else {
					$timestamp = date(($options['dateFormat']), $timestamp);
				}

				// HTML encode special characters like ampersands
				if ($options['escapeSpecialChars']) {
					$text = htmlspecialchars($text);
				}

				// Make links and Twitter names clickable
				if ($options['linksClickable']) {
					// Match URLs
					$text = preg_replace('`\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))`', '<a href="$0">$0</a>', $text);

					// Match @name
					$text = preg_replace('/(@)([a-zA-Z0-9\_]+)/', '@<a href="https://twitter.com/$2">$2</a>', $text);

					// Match #hashtag
					$text = preg_replace('/(#)([a-zA-Z0-9\_]+)/', '#<a href="https://twitter.com/search/?q=$2">$2</a>', $text);
				}

				$html .= '
							<h1 class="white twitterheading">' . $text . '</h1>';

				if ($options['displayDate']) $html .= '
						<p class="white"><a href="http://twitter.com/' . $tweet->user->screen_name . '/status/' . $tweet->id_str . '">@' . $tweet->user->screen_name . '</a>- '.$timestamp.'</p>';

				$html .= '
						</div>';
                                $ti++;
			}

			$html .= '</div>
					</div></div>
					';

			print($html);

			return $html;
		}

		private function saveToCacheFile($content)
		{
			@file_put_contents($this->getCacheFile(), $content);
		}

		private function deleteCacheFile()
		{
			unlink($this->getCacheFile());
		}

		private function getCacheFile()
		{
			$upload = wp_upload_dir();
			return $upload['basedir'] . '/_twitter_' . $this->number . '.txt';
		}

		function getInterval()
		{
			global $interval;
			return $interval;
		}
	}

	class DoorsException extends Exception {}

endif;


add_action('widgets_init', 'register_doors_widget');
function register_doors_widget() {
    register_widget('doors_widget');
}