=== Simple Attribution ===
Contributors: widgitlabs, evertiro
Donate link: https://evertiro.com/donate/
Tags: attribution, citation, cite, post, link
Requires at least: 3.0
Tested up to: 5.4.1
Stable tag: 2.1.2

A simple plugin to allow bloggers to add attribution to sourced posts.

== Description ==

Simple Attribution is just that... simple! It adds a meta box on post pages
which allows bloggers to specify the name and URL of the site a sourced article
originated from. Assuming both these fields are filled out, it appends the
attribution link to the bottom of the post.

Simple Attribution allows links to be generated in both text and image form,
allowing you to customize it to the feel of your website. Natively, it includes
5 icons which can be used to identify the attribution link instead of the
standard caption (which is editable through the options panel), and custom
icons can be used as well.

Don't like where we put the link? You have the option to disable
auto-attribution and put the link wherever you want it to display simply by
adding &lt;?php echo display_attribution(); ?&gt; to your template!

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins > Add New'
2. Search for 'Simple Attribution'
3. Activate Simple Attribution from your Plugins page

= From WordPress.org =

1. Download Simple Attribution
2. Upload the 'simple-attribution' folder to the '/wp-content/plugins' directory
   of your WordPress installation
3. Activate Simple Attribution from your Plugins page

== Frequently Asked Questions ==

None yet

== Changelog ==

= Version 2.1.2 =
* Improved: Code quality
* Updated: Settings library (Select2 improvements)

= Version 2.1.1 =
* Updated: Settings library (fixes sysinfo security vulnerability)

= Version 2.1.0 =
* Bring code up to current standards

= Version 2.0.1 =
* Only load admin scripts on our settings page!

= Version 2.0.0 =
* Complete rewrite!
* Completely backwards compatible (custom template-based stuff won't break)
* Now works with custom post types!
* Added Font Awesome icon support

= Version 1.1.2 =
* Update support link

= Version 1.1.1 =
* Fix bug with WordPress installed in subdirectory not properly saving settings

= Version 1.1.0 =
* Moved to class-based structure
* Added proper I18N

= Version 1.0 =
* Initial release
