<?php
/**
 * Custom RSS Template - Active Plugins
 */
header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>

<?php
$apl = get_option('active_plugins');
$plugins = get_plugins();
$activated_plugins = array();
foreach ($apl as $p){           
    if( isset( $plugins[$p] ) ){
         array_push($activated_plugins, $plugins[$p]);
    }           
}
?>

<rss version="2.0"
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:wfw="http://wellformedweb.org/CommentAPI/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:atom="http://www.w3.org/2005/Atom"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
    <?php do_action('rss2_ns'); ?>>
    <channel>
        <title><?php bloginfo_rss('name'); ?> - Feed</title>
        <atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
        <link><?php bloginfo_rss('url') ?></link>
        <description><?php bloginfo_rss('description') ?></description>
        <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
        <language><?php echo get_option('rss_language'); ?></language>
        <sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'daily' ); ?></sy:updatePeriod>
        <sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
        <?php do_action('rss2_head'); ?>
        <?php
        if( $activated_plugins ) {
            foreach ($activated_plugins as $activated_plugin) {

                if ( !empty($activated_plugin['Description']) && !empty($activated_plugin['Name']) ) :

                    $pluginName = $activated_plugin['Name'];
                    $pluginDescription = $activated_plugin['Description'];

                    echo    '<item>
                                <title><![CDATA['.$pluginName.']]></title>
                                <content:encoded><![CDATA['.$pluginDescription.']]></content:encoded>
                            </item>';

                endif;

            }
        }
        ?>
    </channel>
</rss>

