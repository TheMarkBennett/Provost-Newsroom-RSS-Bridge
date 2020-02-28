<?php
/**
 * RSS Feed Template by Julia N.
 */
// Setting up content type and charset headers
header('Content-Type: '.feed_content_type('rss-http').';charset='.get_option('blog_charset'), true);
// Setting up valid XML encoding
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>

<!-- Declaring XML Validators namespaces -->
<rss version="2.0"
        xmlns:content="http://purl.org/rss/1.0/modules/content/"
        xmlns:wfw="http://wellformedweb.org/CommentAPI/"
        xmlns:dc="http://purl.org/dc/elements/1.1/"
        xmlns:atom="http://www.w3.org/2005/Atom"
        xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
        xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
        <?php do_action('rss2_ns'); ?>>
<!-- Declaring channel with articles data -->
<?php $dateTimeFormat = 'D, M d Y H:i:s'; ?>
<channel>
        <title><?php bloginfo_rss('name'); ?> - Feed</title>
        <!--<atom:link href="<?php bloginfo_rss('url') ?>/feed/" rel="self" type="application/rss+xml" /> -->
        <link><?php bloginfo_rss('url') ?></link>
        <description><?php bloginfo_rss('description') ?></description>
        <lastBuildDate><?php echo mysql2date($dateTimeFormat, get_lastpostmodified(), false); ?></lastBuildDate>
        <language><?php echo get_option('rss_language'); ?></language>
        <sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
        <sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
        <?php do_action('rss2_head'); ?>
        <?php while (have_posts()) : the_post(); ?>
                <item>
                        <title><?php the_title_rss(); ?></title>

                        <link><?php the_permalink_rss(); ?></link>

                        <pubDate><?php echo mysql2date($dateTimeFormat, get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>

                        <dc:creator><?php the_author(); ?></dc:creator>

                        <?php
/*
                        $categories = get_the_category();

                        if ( ! empty( $categories ) ) {

                          foreach( $categories as $category ) {

                          echo '<category><![CDATA['.esc_html($category->name).']]></category>';

                          }

                        }
*/
                        ?>



                        <guid isPermaLink="false"><?php the_guid(); ?></guid>

                        <description><![CDATA[<?php the_excerpt_rss() ?>]]></description>

                        <content:encoded><![CDATA[<?php the_content_feed() ?>]]></content:encoded>


                        <?php
                        if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( $post->ID ) ) {
                          $attachment_id = get_post_thumbnail_id($post->ID);

                          $featured_image = wp_get_attachment_image_src( $attachment_id, 'full' );

                          $url = $featured_image[0];

                          $width = $featured_image[1];

                          $height = $featured_image[2];

                          $length = filesize(get_attached_file($attachment_id));

                          $type = get_post_mime_type($attachment_id);

                          printf('<enclosure url="%s" length="%s" width="%s" height="%s" type="%s" />', $url, $length, $width, $height, $type);
                        }
                        ?>

                        <?php rss_enclosure(); ?>

                        <provostnews><?php if ( get_field('ucf_provost_newsroom_category') ){
                          $field = get_field_object( 'field_5e503f7bb4f52' );
                          //var_dump($field);
                          echo esc_attr($field['value']);
                        } ?></provostnews>

                        <?php do_action('rss2_item'); ?>
                </item>
        <?php endwhile; ?>
</channel>
</rss>
