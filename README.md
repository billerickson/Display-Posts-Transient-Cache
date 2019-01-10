# Display Posts - Transient Cache

**Contributors:** billerickson  
**Tags:** shortcode, pages, posts, page, query, display, list, cache, transient
**Requires at least:** 3.0  
**Tested up to:** 5.0  
**Stable tag:** 1.0.0  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html

## Description

[Display Posts](https://displayposts.com) is the simplest way to query and display content in WordPress.

This plugin extends Display Posts by letting you cache queries using transients. Example:

`[display-posts transient_key="be_recent_posts" transient_expiration="DAY_IN_SECONDS"]`

### Parameters

* `transient_key` - This should be a unique key you define. Each key will be cached separately, so if you're using the same shortcode on multiple pages you can use the same key for each one (cache it once rather than separately)
* `transient_expiration` - This is how long (in seconds) the data should be cached. You can specify a number (ex: `86400`), or use one of the [time constants](https://codex.wordpress.org/Easier_Expression_of_Time_Constants) to make it easier to read (ex: `WEEK_IN_SECONDS`). You can also multiply the constants (ex: `2 * DAY_IN_SECONDS` ).
