# Midlandjobs RSS/XML Feeds for Smartjobboard by RMcC

Add some feeds to your site using the [midlandjob_feeds] shortcode.....

---

## Download instructions

1. Click on the green "Code" button at the top of this page

2. Click "Download ZIP"

3. Install zip inside Wordpress as plugin

## Shortcode instructions

1. Put the url for the feed you want in the shortcode like this:

        [midlandjob_feeds url="https://midlandjobs.ie/feeds/standard.xml"]

2. to disable the publisher header at the top of the feed, use the flag disable_header:

        [midlandjob_feeds url="https://midlandjobs.ie/feeds/standard.xml" disable_header]

3. to disable the popup modals for each job in the feed, use the flag disable_modals:

        [midlandjob_feeds url="https://midlandjobs.ie/feeds/standard.xml" disable_modals]

4. to enable carousel mode for a feed, use the carousel flag

        [midlandjob_feeds url="https://midlandjobs.ie/feeds/standard.xml" carousel]

5. You can generate the feed links for the url part of the shortcode inside your smartjobboard backend, using the 'customize your feed' option

6. Paste this shortcode onto a page/post to display the feed. When editing a page/post, you can add a shortcode block specifically by searching for it within the blocks. Paste the shortcode intothe shortcode block.
 
## Demo

![alt text](https://github.com/[username]/[reponame]/blob/[branch]/demo.jpg?raw=true)