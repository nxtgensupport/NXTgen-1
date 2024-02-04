<?php

/* ---------------------------------------------  */
// Function to get attachment image from ID 
/* ---------------------------------------------  */
if ( ! function_exists( 'be_wp_get_attachment' ) ) {
    function be_wp_get_attachment( $attachment_id ) {
        $attachment = get_post( $attachment_id );
        if(isset($attachment) && !empty($attachment)) {
            $image_attributes = wp_get_attachment_image_src( $attachment->ID, 'full' );
            return array (
                'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
                'caption' => $attachment->post_excerpt,
                'description' => $attachment->post_content,
                'href' => get_permalink( $attachment->ID ),
                'src' => $attachment->guid,
                'title' => $attachment->post_title,
                'width' => ( empty( $image_attributes ) || empty( $image_attributes[1] ) ) ? '': $image_attributes[1],
                'height' => ( empty( $image_attributes ) || empty( $image_attributes[2] ) ) ? '': $image_attributes[2],
            );
        }
        return false;
    }
}

if( ! function_exists( 'be_is_json' ) ) {
    function be_is_json( $string ) {
        json_decode( $string );
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

function exp_get_categories_as_module_option() {
    $post_categories = get_categories();
	$category_options = array();
	foreach( $post_categories as $category ) {
		if( is_object( $category ) ) {
			$category_options[ $category->slug ] = $category->name;
		}
    }
    return $category_options;
}

if( ! class_exists( 'MailChimp' ) ) {
	class MailChimp {
    	private $api_key;
    	private $api_endpoint = 'https://<dc>.api.mailchimp.com/2.0';
    	private $verify_ssl   = false;

    	/**
    	* Create a new instance
     	* @param string $api_key Your MailChimp API key
     	*/
    	function __construct($api_key) {
        	$this->api_key = $api_key;
        	list(, $datacentre) = explode('-', $this->api_key);
        	$this->api_endpoint = str_replace('<dc>', $datacentre, $this->api_endpoint);
    	}

	    /**
	     * Call an API method. Every request needs the API key, so that is added automatically -- you don't need to pass it in.
	     * @param  string $method The API method to call, e.g. 'lists/list'
	     * @param  array  $args   An array of arguments to pass to the method. Will be json-encoded for you.
	     * @return array          Associative array of json decoded API response.
	     */
	    public function call($method, $args=array(), $timeout = 10) {
	        return $this->makeRequest($method, $args, $timeout);
	    }

	    /**
	     * Performs the underlying HTTP request. Not very exciting
	     * @param  string $method The API method to be called
	     * @param  array  $args   Assoc array of parameters to be passed
	     * @return array          Assoc array of decoded result
	     */
    	private function makeRequest($method, $args=array(), $timeout = 10) {      
        	$args['apikey'] = $this->api_key;
        	$url = $this->api_endpoint.'/'.$method.'.json';
	        if (function_exists('curl_init') && function_exists('curl_setopt')){
	            $ch = curl_init();
	            curl_setopt($ch, CURLOPT_URL, $url);
	            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	            curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');       
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	            curl_setopt($ch, CURLOPT_POST, true);
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl);
	            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
	            $result = curl_exec($ch);
	            curl_close($ch);
	        } else {
	            $json_data = json_encode($args);
	            $result    = file_get_contents($url, null, stream_context_create(array(
	                'http' => array(
	                    'protocol_version' => 1.1,
	                    'user_agent'       => 'PHP-MCAPI/2.0',
	                    'method'           => 'POST',
	                    'header'           => "Content-type: application/json\r\n".
	                                          "Connection: close\r\n" .
	                                          "Content-length: " . strlen($json_data) . "\r\n",
	                    'content'          => $json_data,
	                ),
	            )));
	        }
        	return $result ? json_decode($result, true) : false;
    	}
	}
}

/**
 * AJAX Mailchimp subscription.
 */
if ( ! function_exists( 'be_themes_mailchimp_subscription' ) ) {
	function be_themes_mailchimp_subscription() {
		if( empty( $_POST['email'] ) ) {
			wp_send_json( array(
				'status'  => 'error',
				'data' => __( 'Email Address is missing.', 'exponent-modules'),
			 ) );
		}
		if( empty($_POST['api_key']) || empty( $_POST['list_id'] ) ) {
			wp_send_json( array(
				'status'  => 'error',
				'data' => __( 'Api Key or List Id is missing.', 'exponent-modules'),
			 ) );
		}

		$email = sanitize_email( $_POST['email'] );
		$api_key = $_POST['api_key'];
		$list_id = $_POST['list_id'];

		$success = empty( $_POST['success_text'] ) ? __( 'Thank you, you have been added to our mailing list.','exponent-modules' ) : sanitize_text_field( $_POST['success_text'] );

		$phone = $fname = $lname = '';
		$api_endpoint = 'https://<dc>.api.mailchimp.com/3.0/';
		list( , $datacentre ) = explode( '-', $api_key );
		$api_endpoint = str_replace( '<dc>', $datacentre, $api_endpoint );

		$body = apply_filters( 'exponent_mailchimp_data', [
			'email_address'     => $email,
			'merge_fields'      => [
				'FNAME' => $fname,
				'LNAME' => $lname,
				'PHONE' => $phone,
			],
			'email_type'        => 'html',
			'status'            => 'subscribed',
			'double_optin'      => false,
			'update_existing'   => true,
			'replace_interests' => false,
			'send_welcome'      => false,
		] );

		$response = wp_remote_post( $api_endpoint . '/lists/' . $list_id . '/members', [
			'headers'   => [
				'Content-Type'  => 'application/json',
				'Authorization' => 'Basic '. base64_encode( 'user:' . $api_key ),
			],
			'body'      => wp_json_encode( $body ),
			'sslverify' => false,
		] );

		if ( is_wp_error( $response ) ) {
			wp_send_json( [
				'status'  => 'error',
				'data' => $response->get_error_message(),
			] );
		} else {
			$result = json_decode( wp_remote_retrieve_body( $response ), true );
			$response = [];
			
			if ( isset( $result['status'] ) && ! isset( $result['errors'] ) && ( $result['status'] == 'subscribed'  ||  $result['status'] == 400 ) ) {
				$response['status'] = 'success';
				$response['data'] = $success;
			} else {
				$response['status'] = 'error';
				$response['data'] = empty( $result['title'] ) ? __( 'Something went wrong. Please try again later.', 'exponent-modules' ) : $result['title'];
			}

			wp_send_json( $response );
		}
	}

	add_action( 'wp_ajax_nopriv_mailchimp_subscription', 'be_themes_mailchimp_subscription' );
	add_action( 'wp_ajax_mailchimp_subscription', 'be_themes_mailchimp_subscription' );
}

/* ---------------------------------------------  */
// Function to publish share buttons
// Used in exponent's single post and single product page. Moved out of theme due to envato's theme rules.
/* ---------------------------------------------  */
if ( ! function_exists( 'exponent_get_share_button' ) ) {
	function exponent_get_share_button($url = '', $title = '', $id = '', $size = 'tiny', $before = '', $after = '', $bold = false ) {
		$output = '';
		$media = '';
		if( !empty( $id ) ) {
			$attachment = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );
			$media =  ( $attachment ) ? $attachment[0] : '';
		}
		if( !empty( $url ) ) {
			$output .= $before;
			if( !$bold ) {
				$output .= '<a href="https://www.facebook.com/sharer/sharer.php?u='.urlencode($url).'" class="custom-share-button" target="_blank"><i class="exp-icon exponent-icon-facebook plain ' . $size . '"></i></a>';
				$output .= '<a href="http://twitter.com/intent/tweet?text='.urlencode($title).'&url='.urlencode($url).'" class="custom-share-button" target="_blank"><i class="exp-icon exponent-icon-twitter plain ' . $size . '"></i></a>';
				// $output .= '<a href="https://plus.google.com/share?url='.urlencode($url).'" class="custom-share-button" target="_blank"><i class="exp-icon exponent-icon-gplus plain ' . $size . '"></i></a>';
				$output .= '<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url='.urlencode($url).'&amp;title='.urlencode($title).'" class="custom-share-button" target="_blank"><i class="exp-icon exponent-icon-linkedin plain ' . $size . '"></i></a>';
				$output .= '<a href="https://www.pinterest.com/pin/create/button/?url='.urlencode($url).'&media='.urlencode($media).'&description='.urlencode($title).'" class="custom-share-button" target="_blank"  data-pin-do="buttonPin" data-pin-config="above"><i class="exp-icon exponent-icon-pinterest plain ' .$size . '"></i></a>';
			}else {
				$output .= '<a href="https://www.facebook.com/sharer/sharer.php?u='.urlencode($url).'" class="custom-share-button be-bold-share be-bold-share-facebook" target="_blank"><span class = "be-share-icon"><i class="exp-icon exponent-icon-facebook plain ' . $size . '"></i></span><span class = "be-share-text">' .  __( 'Share', 'exponent' ) . '</span></a>';
				$output .= '<a href="http://twitter.com/intent/tweet?text='.urlencode($title).'&url='.urlencode($url).'" class="custom-share-button be-bold-share be-bold-share-twitter" target="_blank"><span class = "be-share-icon"><i class="exp-icon exponent-icon-twitter plain ' . $size . '"></i></span><span class = "be-share-text">' .  __( 'Tweet', 'exponent' ) . '</span></a>';
				$output .= '<a href="https://www.pinterest.com/pin/create/button/?url='.urlencode($url).'&media='.urlencode($media).'&description='.urlencode($title).'" class="custom-share-button be-bold-share be-bold-share-pinterest" target="_blank"  data-pin-do="buttonPin" data-pin-config="above"><span class = "be-share-icon"><i class="exp-icon exponent-icon-pinterest plain ' .$size . '"></i></span><span class = "be-share-text">' .  __( 'Pin it', 'exponent' ) . '</span></a>';
				// $output .= '<a href="https://plus.google.com/share?url='.urlencode($url).'" class="custom-share-button be-bold-share be-bold-share-googleplus" target="_blank"><span class = "be-share-icon"><i class="exp-icon exponent-icon-gplus plain ' . $size . '"></i></span><span class = "be-share-text">' .  __( 'Share', 'exponent' ) . '</span></a>';
				$output .= '<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url='.urlencode($url).'&amp;title='.urlencode($title).'" class="custom-share-button be-bold-share be-bold-share-linkedin" target="_blank"><span class = "be-share-icon"><i class="exp-icon exponent-icon-linkedin plain ' . $size . '"></i></span><span class = "be-share-text">' .  __( 'Share', 'exponent' ) . '</span></a>';
			}
			$output .= $after;
		}
		return $output;
	}
}

if ( ! function_exists( 'exponent_modules_gdpr_options' ) ) {
    function exponent_modules_gdpr_options(){
        $options = array(
            'youtube' => array(
                'label' => "Youtube",
                'description' => __( "Consent to display content from YouTube.", 'exponent-modules' ),
                'required' => false
            ),
            'vimeo' => array(
                'label' => "Vimeo",
                'description' => __( "Consent to display content from Vimeo.", 'exponent-modules' ),
                'required' => false
            ), 
        );
        foreach( $options as $option => $value ){
            be_gdpr_register_option($option,$value);
        }
	}
	add_action('be_gdpr_register_options','exponent_modules_gdpr_options');
}

?>