<?php

/*
Plugin Name: Social Share Sidebar
Plugin URI: http://www.seo-copilot.co.uk
Description: Displays Social Sidebar
Version: 9.9.9
Author: Callum
*/

function social_share_style() 
{
    wp_register_style("social-share-style-file", plugin_dir_url(__FILE__) . "style.css");
    wp_enqueue_style("social-share-style-file");
}

add_action("wp_enqueue_scripts", "social_share_style");

function social_share_menu_item()
{
  add_submenu_page("options-general.php", "Social Share Sidebar", "Social Share Sidebar", "manage_options", "social-share", "social_share_page"); 
}

add_action("admin_menu", "social_share_menu_item");

// Admin Area

function social_share_page()
{
   ?>
      <div class="wrap">
         <h1>Social Sharing Options</h1>
 
         <form method="post" action="options.php">
            <?php
               settings_fields("social_share_config_section");
 
               do_settings_sections("social-share");
                
               submit_button(); 
            ?>
         </form>
      </div>
   <?php
}

function social_share_settings()
{
    add_settings_section("social_share_config_section", "", null, "social-share");
 
    add_settings_field("social-share-enable", "Enable / Disable", "social_share_enable_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-facebook", "Show Facebook button?", "social_share_facebook_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-twitter", "Show Twitter share button?", "social_share_twitter_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-linkedin", "Show LinkedIn share button?", "social_share_linkedin_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-google", "Show Google+ share button?", "social_share_google_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-mail", "Show Email share button?", "social_share_mail_checkbox", "social-share", "social_share_config_section");
 
    register_setting("social_share_config_section", "social-share-enable");
    register_setting("social_share_config_section", "social-share-facebook");
    register_setting("social_share_config_section", "social-share-twitter");
    register_setting("social_share_config_section", "social-share-linkedin");
    register_setting("social_share_config_section", "social-share-google");
    register_setting("social_share_config_section", "social-share-mail");
}
function social_share_enable_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-enable" value="1" <?php checked(1, get_option('social-share-enable'), true); ?> />
        <hr />
   <?php
}

function social_share_facebook_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-facebook" value="1" <?php checked(1, get_option('social-share-facebook'), true); ?> />
   <?php
}

function social_share_twitter_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-twitter" value="1" <?php checked(1, get_option('social-share-twitter'), true); ?> />
   <?php
}

function social_share_linkedin_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-linkedin" value="1" <?php checked(1, get_option('social-share-linkedin'), true); ?> />
   <?php
}

function social_share_google_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-google" value="1" <?php checked(1, get_option('social-share-google'), true); ?> />
   <?php
}

function social_share_mail_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-mail" value="1" <?php checked(1, get_option('social-share-mail'), true); ?> />
   <?php
}
 
add_action("admin_init", "social_share_settings");


// Front End Display

function add_social_share_icons($content) {

    $html = $html . "<ul id='social-sidebar' class='hidden-xs'>";

    global $post;

    $url = get_permalink($post->ID);
    $url = esc_url($url);

    if(get_option("social-share-facebook") == 1)
    {
        $html = $html . "<li><a class='fa fa-facebook' target='_blank' href='http://www.facebook.com/sharer.php?u=" . $url . "'><span>Facebook</span></a></li>";
    }

    if(get_option("social-share-twitter") == 1)
    {
        $html = $html . "<li><a class='fa fa-twitter' target='_blank' href='https://twitter.com/share?url=" . $url . "'><span>Twitter</a></li>";
    }

    if(get_option("social-share-linkedin") == 1)
    {
        $html = $html . "<li><a class='fa fa-linkedin linkedin' target='_blank' href='http://www.linkedin.com/shareArticle?url=" . $url . "'><span>LinkedIn</span></a></li>";
    }

    if(get_option("social-share-google") == 1)
    {
        $html = $html . "<li><a class='fa fa-google gplus' target='_blank' href='https://plus.google.com/share?url=" . $url . "'><span>Google+</span></a></li>";
    }

    if(get_option("social-share-mail") == 1)
    {
        $html = $html . "<li><a class='fa fa-envelope github' href='mailto:?body=" . $url . "'><span>Email</span></a></li>";
    }

    $html = $html . "</ul>";

    echo $content =  $html . $content;

}
function showSidebar() {
    add_action("wp_footer", "add_social_share_icons");
}

if(get_option("social-share-enable") == 1) {
    showSidebar();
};

