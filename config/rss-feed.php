<?php
/*
Provost news rss feed configuration.
Creates an rss feed for every provost news catagory
links to rss feed template
filter each feed by its catagory
 */

/*
Creates a rss feed for all the provost news categories
 */

add_action('init', 'ucf_provostnews_rss_feed_creator');
function ucf_provostnews_rss_feed_creator(){


  $field = get_field_object('field_5e503f7bb4f52'); // get the select field with all the categories

  if( $field['choices'] ):

       foreach( $field['choices'] as $value => $label ): //loop through all the fields and add an rss feed for each

          $label = strtolower(str_replace(' ', '_', $label));

          $feedurl = 'pn'. $label ; // creates the feeds url

                   add_feed( $feedurl , 'ucf_provostnews_rss_feed_template'); //adds a new feed

      endforeach;

  endif;

    //  add_feed('pn', 'ucf_provostnews_rss_feed_template'); //feed for all post
}

/*
* rss feed template
*/
function ucf_provostnews_rss_feed_template(){

   require_once( plugin_dir_path( __DIR__ ) . 'rss-feed-template.php' );

}


/*
* Edit the new feeds to just include its own catagory
*/
add_action( 'pre_get_posts', 'ucf_provostnews_rss_feed_query_filter' );
function ucf_provostnews_rss_feed_query_filter( $query ) {

    if( $query->is_feed() && $query->is_main_query() && ! is_admin() ) { //check it the url is a feed


      $feedurl = $query->query["feed"]; // get the feed url

      $pn_catagory = preg_replace('/^pn/',"", $feedurl); //remove on/ from the url

      $field = get_field_object('field_5e503f7bb4f52'); // get the select field with all the categories

      $pn_array = array_map('strtolower',preg_replace('/\s+/', '_', $field['choices'])); //loops through all the provost categories with regex


        if ( ! in_array($pn_catagory,   $pn_array)) {

            return; // if it's not one of the provost news feeds exit
        }


            //Get original meta query
            $meta_query = $query->get('meta_query')? : [];

             $meta_query['relation'] = 'AMD';

            //Add our meta query to the original meta queries

              $meta_query[] = array(
                                  'key'=> 'ucf_provost_newsroom_checkbox',
                                  'value'=> True,
                                  'compare'=>'=',
                              );

            $meta_query[] = array(
                                'key'=> 'ucf_provost_newsroom_category',
                                'value'=> $pn_catagory,
                                'compare'=>'=',
                            );
              $query->set('meta_query',$meta_query);

            add_filter( 'option_posts_per_rss', 'ucf_provostnews_feed_posts_number' );


      }




  }

function ucf_provostnews_feed_posts_number(){

    return 10;
}
