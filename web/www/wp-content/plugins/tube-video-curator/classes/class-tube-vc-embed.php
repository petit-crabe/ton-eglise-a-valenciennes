<?php
/**
 * Tube_VC_Embed
 * 
 * Functions to insert videos into posts
 * 
 * @package Tube_Video_Curator
 * @subpackage Classes
 * @author  .TUBE gTLD <https://www.live.tube>
 * @copyright Copyright 2017, TUBE®
 * @link https://www.wptools.tube
 * @since 1.0.0
 */
 
class Tube_VC_Embed {
  
  public static $instance;
  
  public static $cached_embeds;
  
  public static function init() {
      if ( is_null( self::$instance ) )
          self::$instance = new Tube_VC_Embed();
      return self::$instance;
  }
  
  // Constructor  
  
  function __construct() {              
          
    self :: $cached_embeds = array();
          
    // add video placement filter to the body class
    add_filter('body_class', array( $this, 'add_tube_video_placement_to_body_class' ) );
              
    // add video embded filter to the_content
    add_filter( 'the_content', array( $this, 'insert_video_into_post') );
              
    // add video schema inside head tag
    add_action( 'wp_head', array( $this, 'add_video_schema_to_head') );
    
    // create a shortcode to embed a video
    add_shortcode( 'tube_video', array( $this, 'get_video_embed') );

  } 
  
    
    
  function insert_video_into_post($content){
    
    global $post;
    
    // if not single post, or not in the loop, do nothing
    if ( ! is_main_query() || ! $post || ! is_single( $post->ID ) || ! in_the_loop() ) :
      
      return $content;
      
    endif;
    
    // get the embed code for the video    
    $video_embed = $this -> get_video_embed( $post->ID );

    if ( ! $video_embed ):
      
      return $content;
      
    endif;
      
    // wrap the video in a div
    $video_embed = '<div class="tube-video-wrap">' . $video_embed . '</div>';
    
    // get the video placement option
    $video_placement = get_option( 'tube_vc_video_placement' );

    // get the video schema (NOT USED)
    // $video_schema = $this -> get_video_schema( $post->ID );
    
    // add the schema to the content
    // $content = $content . $video_schema;
    
    if ( $video_placement == 'above' ) :
    
      // put the video before the content
      return $video_embed . $content;
      
    elseif ( $video_placement == 'below' ) :
    
      // put the video after the content
      return $content . $video_embed;
      
    else:
    
      return $content;
      
    endif;    
    
  }
  
  
  function get_video_embed( $args = NULL ){
    
    global $post;
    
    // check if already stored locally
    if ( array_key_exists( $post->ID , self :: $cached_embeds ) ):
        return self :: $cached_embeds[ $post->ID ];
    endif;
      
    
    $defaults = array(
      'post_id' => $post->ID,
    );
    $args = wp_parse_args( $args, $defaults );
    
    // get the video URL for the post
    $video_url = get_post_meta( $args['post_id'], 'tube_video_oembed_url', true);     
     
    // get the video site for the post
    $video_site = get_post_meta( $args['post_id'], 'tube_video_site', true);
    
    // if no video URL or site , do nothing
    if ( ! $video_url || ! $video_site ) :
      
      return NULL;
      
    endif;   

    
    global $tube_video_curator;
    
    // customize the embed based on the site
    switch ($video_site):
      
      case 'twitch':
        
        global $wp_embed;
        
        // Can't use wp_oembed_get with "fake" oembed handler via wp_embed_register_handler
        // so using global w/ shortcode method
        $video_embed = $wp_embed->shortcode(NULL, $video_url);
        
        $video_embed = Tube_Video_Curator::$tube_twitch_videos -> custom_twitch_oembed_args( $video_embed );
        
        break;
      
      case 'vimeo':
        
        
        $video_embed = wp_oembed_get( $video_url );
        
        $video_embed = Tube_Video_Curator::$tube_vimeo_videos -> custom_vimeo_oembed_args( $video_embed );
        break;
      
      case 'youtube':
        
        
        $video_embed = wp_oembed_get( $video_url );
        
        $video_embed = Tube_Video_Curator::$tube_youtube_videos -> custom_youtube_oembed_args( $video_embed );
        break;
      
      default:
        
        $video_embed =  wp_oembed_get( $video_url );
        break;
        
    endswitch;
    
    $data_atts = array(
      'postid' => $post->ID
    );
    
    $data_atts = apply_filters( 'tube_vc_filter_embed_data_atts', $data_atts );
    
    $data_atts_str = '';
    
    foreach( $data_atts as $data_att_key => $data_att_value ):
      $data_atts_str .= 'data-'.$data_att_key.'="' . esc_attr( $data_att_value ) .  '" ';
    endforeach;  
    
    $video_embed = '<div class="tube-vc-embed" ' . $data_atts_str. '>' . $video_embed . '</div>';
    
    // store for re-use if needed
    self :: $cached_embeds[ $post->ID ] = $video_embed;
     
    // return the embed code for the video
    return $video_embed;
    
  }

  
  function add_video_schema_to_head( ){
    
    global $post;

    if ( ! $post ):
      
      return;
      
    endif;
    
    // get the embed code for the video    
    $video_embed = $this -> get_video_embed( $post->ID );

    if ( ! $video_embed ):
      
      return;
      
    endif;
    
    preg_match('/src="([^"]+)"/', $video_embed, $src_match);
    
    if ( ! is_array( $src_match ) || 0 == count( $src_match ) ):
      
      return;
      
    endif;
      
    $embed_url = $src_match[1];
        
    $title = get_the_title( $post->ID );
    
    // remove and re-add filter to prevent endless loop
    // TODO: Figure out why this prevents shortcodes from getting rendered inside post content
    remove_filter( 'the_content', array( $this, 'insert_video_into_post') );    
    $excerpt = get_the_excerpt( $post->ID );
    add_filter( 'the_content', array( $this, 'insert_video_into_post') );    
    
    $thumbnail_url = get_the_post_thumbnail_url( $post->ID, 'full');
    
    $video_date = get_post_meta( $post->ID, 'tube_video_date', true );    
    $video_date = date('Y-m-d', strtotime($video_date));  
    
    $creator_name = get_post_meta( $post->ID, 'tube_video_creator_name', true );
    
    $permalink = get_the_permalink( $post->ID );
    
    ?>
    
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "VideoObject",
      "name": <?php echo json_encode( $title ); ?>,
      "description": <?php echo json_encode( $excerpt ); ?>,
      "thumbnailUrl": <?php echo json_encode( $thumbnail_url ); ?>,
      "uploadDate": <?php echo json_encode( $video_date ); ?>,
      "url": <?php echo json_encode( $permalink ); ?>,
      "embedUrl": <?php echo json_encode( $embed_url ); ?>,
      "creator": {
        "@type": "Person",
        "name": <?php echo json_encode( $creator_name ); ?>
      }
    }
    </script> 
    
    
    <?php
  
  }
  
  // add the video placement to the body class  
  function add_tube_video_placement_to_body_class($classes){
    
    global $post;
    
    // make sure there's a post on a single page, or do nothing
    if ( ! $post || ! is_singular() ) :
      
      return $classes;
      
    endif;
    
    // get the video ID for the post
    $has_video = get_post_meta( $post -> ID, 'tube_video_id', true );    
    
    // make sure there's a video for the post, or do nothing
    if ( ! $has_video ) :
      
      return $classes;
      
    endif;
             
    // get the video placement option
    $video_placement = get_option( 'tube_vc_video_placement' );

    // if no video placement option, do nothing
    if ( ! $video_placement ):
      
      return $classes;
      
    endif;
      
    $classes[] = sanitize_html_class('video-placement-' . $video_placement);
 
    return $classes;
  
  }



    
}
