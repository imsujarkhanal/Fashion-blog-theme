# MeroTheme Workflow And Widget Documentation

This document explains how the theme starts rendering, which template files are used, where widget areas are printed, where custom widgets are registered, and where each widget gets its values.

## 1. Big Picture Workflow

When a visitor opens a page, WordPress chooses a template file using the WordPress template hierarchy.

Basic flow:

```text
Browser requests URL
WordPress decides the template file
Template calls get_header()
header.php prints logo, menu, and header widget areas
Template prints page/post content
Template calls get_sidebar() if sidebar is needed
sidebar.php prints Sidebar widget area
Template calls get_footer()
footer.php prints footer widget areas and wp_footer()
```

Important idea:

`functions.php` does not directly print the page. It registers theme features, widget areas, widgets, menus, scripts, and includes helper files. The actual page HTML mostly comes from template files like `header.php`, `page.php`, `single.php`, `front-page.php`, `sidebar.php`, and `footer.php`.

## 2. Main Template Files

### `functions.php`

Purpose:

- Sets up theme support such as title tag, featured images, logo, HTML5 support, and menus.
- Registers widget areas using `register_sidebar()`.
- Defines custom widget classes using `WP_Widget`.
- Registers custom widgets using `register_widget()`.
- Loads helper files from the `inc/` folder.

Important sections:

- `merotheme_setup()` registers theme features and menus.
- `merotheme_widgets_init()` registers widget areas.
- Custom widget classes are defined in the same file.
- `merotheme_register_custom_widgets()` registers the main custom widgets.
- `merotheme_register_footer_widgets()` registers footer widgets.

### `header.php`

Purpose:

- Prints the HTML document start.
- Prints site logo/title.
- Prints social icons from ACF option fields.
- Prints the primary navigation menu.
- Prints either the homepage slider widget area or inner page hero widget area.

Important logic:

```php
if ( is_front_page() || is_home() ) {
	dynamic_sidebar( 'homepage-header-slider' );
} else {
	dynamic_sidebar( 'inner-page-hero-section' );
}
```

This means:

- Homepage/blog home uses the `Homepage Header Slider` widget area.
- Inner pages/posts use the `Inner Page Hero Section` widget area.

### `front-page.php`

Purpose:

- Used for the homepage when WordPress uses this theme file.
- Calls `get_header()`.
- Shows latest posts using `WP_Query`.
- Shows post featured images, dates, likes, comments, title, and excerpt.
- Calls `get_sidebar()` on the right side.
- Calls `get_footer()`.

Value sources:

- Posts come from `WP_Query`.
- Post image comes from the post Featured Image.
- Likes come from post meta key `post_likes`.
- Comments come from WordPress comment count.

### `page.php`

Purpose:

- Used for normal WordPress pages.
- Calls `get_header()`.
- Gets sidebar position from ACF option field `sidebar_position`.
- Prints the page title and page content.
- Calls `get_sidebar()` on left or right depending on the setting.
- Calls `get_footer()`.

Value sources:

- Page title from `the_title()`.
- Page content from `the_content()`.
- Sidebar position from `get_field( 'sidebar_position', 'option' )`.

### `single.php`

Purpose:

- Used for single blog posts.
- Calls `get_header()`.
- Gets sidebar position from ACF option field `sidebar_position`.
- Loads `template-parts/content.php`.
- Loads comments if enabled.
- Calls `get_sidebar()` on left or right.
- Calls `get_footer()`.

Value sources:

- Post layout comes from `template-parts/content.php`.
- Sidebar position from `get_field( 'sidebar_position', 'option' )`.

### `template-parts/content.php`

Purpose:

- Prints the markup for a single post or post loop item.
- Prints title, meta, featured image, and content.

Important call:

```php
merotheme_post_thumbnail();
```

That function is defined in `inc/template-tags.php`.

### `inc/template-tags.php`

Purpose:

- Contains reusable template helper functions.
- `merotheme_post_thumbnail()` controls how featured images are printed inside post/page content.

Important behavior:

- If there is no featured image, it returns early.
- On singular pages/posts, it prints the featured image inside `<div class="post-thumbnail">`.
- On archive/list views, it wraps the image in a permalink.

### `sidebar.php`

Purpose:

- Prints the main sidebar area.

Important call:

```php
dynamic_sidebar( 'sidebar-1' );
```

This prints widgets added to the `Sidebar` widget area in WordPress admin.

### `footer.php`

Purpose:

- Prints footer columns.
- Prints footer menu.
- Prints copyright text.
- Prints optional back-to-top button using ACF option fields.
- Calls `wp_footer()`.

Important calls:

```php
dynamic_sidebar( 'footer-col-1' );
dynamic_sidebar( 'footer-col-2' );
dynamic_sidebar( 'footer-col-3' );
```

Value sources:

- Footer widgets come from Appearance > Widgets.
- Footer menu comes from the `footer-menu` menu location.
- Back-to-top fields come from ACF option fields.

## 3. Widget Areas

Widget areas are registered in `functions.php` inside `merotheme_widgets_init()`.

| Widget Area Name | Widget Area ID | Registered In | Printed In | Purpose |
|---|---|---|---|---|
| Sidebar | `sidebar-1` | `functions.php` | `sidebar.php` | Main blog/page sidebar |
| Header Top Section | `header-top-section` | `functions.php` | Currently not printed in template | Intended for header top widgets |
| Homepage Header Slider | `homepage-header-slider` | `functions.php` | `header.php` | Homepage slider area |
| Inner Page Hero Section | `inner-page-hero-section` | `functions.php` | `header.php` | Inner page hero and breadcrumb |
| Footer Column 1 | `footer-col-1` | `functions.php` | `footer.php` | First footer column |
| Footer Column 2 | `footer-col-2` | `functions.php` | `footer.php` | Second footer column |
| Footer Column 3 | `footer-col-3` | `functions.php` | `footer.php` | Third footer column |

How to read this:

- `register_sidebar()` creates the widget area in admin.
- `dynamic_sidebar()` prints the widgets from that area on the frontend.
- If a widget area is registered but never printed with `dynamic_sidebar()`, widgets added there will not appear on the site.

## 4. Custom Widgets

Most custom widgets are defined in `functions.php`.

### MeroTheme Slider

Class:

```php
Merotheme_Slider_Widget
```

Registered by:

```php
register_widget( 'Merotheme_Slider_Widget' );
```

Usually placed in:

```text
Homepage Header Slider
```

Value source:

- Gets homepage ID using `get_option( 'page_on_front' )`.
- Reads ACF repeater field `slider_images` from the homepage.
- Reads each repeater row:
  - `slide_image`
  - `slide_title`
  - `slide_description`

Frontend output:

- Outputs `<section class="home-slider">`.
- Each slide outputs image, title, and description.

Admin fields:

- This widget itself does not have normal widget form fields.
- The values come from ACF fields on the homepage.

### MeroTheme Search

Class:

```php
Merotheme_Search_Widget
```

Value source:

- No saved widget fields.
- Outputs a search form directly.

Frontend output:

- Search form with input name `s`.
- Submits to `home_url( '/' )`.

### MeroTheme Social Links

Class:

```php
Merotheme_Social_Widget
```

Widget instance fields:

- `title`

ACF option fields:

- `header_facebook_url`
- `header_twitter_url`
- `header_pinterest_url`
- `header_linkedin_url`
- `header_google_plus_url`
- `header_rss_url`
- `header_behance_url`

Value source:

- Widget title comes from the widget settings.
- Social URLs come from ACF option fields.

Frontend output:

- Font Awesome social icons.

### MeroTheme Popular Posts

Class:

```php
Merotheme_Popular_Posts_Widget
```

Widget instance fields:

- `title`
- `number`

Value source:

- Title and number come from widget settings.
- Posts come from `WP_Query`.
- The query currently gets normal posts, limited by `number`.

Important note:

Despite the name "Popular Posts", the current query does not sort by views, comments, or likes. It simply gets posts using the default WordPress query order unless changed later.

Frontend output:

- Featured image, title, and date.

### MeroTheme Recent Posts

Class:

```php
Merotheme_Recent_Posts_Widget
```

Widget instance fields:

- `title`
- `number`

Value source:

- Title and number come from widget settings.
- Posts come from `WP_Query`.

Frontend output:

- Thumbnail, title, and date.

### MeroTheme Categories

Class:

```php
Merotheme_Categories_Widget
```

Widget instance fields:

- `title`
- `number`

Value source:

- Title and number come from widget settings.
- Categories come from WordPress categories through `wp_list_categories()`.

Frontend output:

- Category list.

### MeroTheme Tags

Class:

```php
Merotheme_Tags_Widget
```

Widget instance fields:

- `title`
- `number`

Value source:

- Title and number come from widget settings.
- Tags come from WordPress tags through `wp_tag_cloud()`.

Frontend output:

- Tag cloud.

### MeroTheme Inner Page Hero

Class:

```php
Merotheme_Inner_Page_Hero_Widget
```

Usually placed in:

```text
Inner Page Hero Section
```

Widget instance fields:

- `hero_image`

Value source:

- `hero_image` comes from the widget settings in Appearance > Widgets.
- The media picker behavior comes from `assets/js/widget-media.js`.

Frontend output:

```html
<div class="agile-banner" style="background-image: url('...');"></div>
```

Important:

- This widget now uses the image selected inside the widget.
- It does not use the page/post Featured Image.

### MeroTheme Breadcrumb

Class:

```php
Merotheme_Breadcrumb_Widget
```

Usually placed in:

```text
Inner Page Hero Section
```

Value source:

- Current page/post ID from `get_queried_object_id()`.
- Current title from `get_the_title( $page_id )`.
- Home URL from `home_url( '/' )`.

Frontend output:

- Breadcrumb with Home link and current page/post title.

### MeroTheme Footer Contact

Class:

```php
MeroTheme_Footer_Contact
```

Registered by:

```php
merotheme_register_footer_widgets()
```

Widget instance fields:

- `title`
- `address`
- `email`
- `phone`
- `website`

Value source:

- All values come from the widget form.

Usually placed in:

```text
Footer Column 1, Footer Column 2, or Footer Column 3
```

### MeroTheme Footer About

Class:

```php
MeroTheme_Footer_About
```

Widget instance fields:

- `title`
- `text`

Value source:

- Values come from the widget form.

### MeroTheme Newsletter

Class:

```php
MeroTheme_Footer_Newsletter
```

Widget instance fields:

- `title`
- `text`

Value source:

- Title and text come from the widget form.
- Email form is static HTML right now.

Important note:

- The newsletter form does not currently submit to a real email service or WordPress handler.

## 5. Where Widget Values Are Stored

Classic WordPress widgets save their settings in the WordPress database, usually in the `wp_options` table.

For custom widgets, values from `form()` are passed into `update()`, then saved by WordPress.

Example:

```php
public function form( $instance ) {
	// Shows fields in admin.
}

public function update( $new_instance, $old_instance ) {
	// Sanitizes and saves fields.
}

public function widget( $args, $instance ) {
	// Reads saved values and prints frontend HTML.
}
```

How to understand any widget:

1. Find the widget class in `functions.php`.
2. Read `form()` to know what admin fields it has.
3. Read `update()` to know how values are saved.
4. Read `widget()` to know how values are displayed on frontend.
5. Find `register_widget()` to confirm it is registered.
6. Check Appearance > Widgets to see which widget area contains it.
7. Find `dynamic_sidebar( 'area-id' )` to see where that widget area appears in templates.

## 6. ACF Option Fields

ACF option pages are registered in:

```text
inc/acf-options.php
```

Registered option pages:

- Header Settings
- Footer Settings
- Sidebar Settings

Common ACF option fields used in the theme:

| Field Name | Used In | Purpose |
|---|---|---|
| `header_facebook_url` | `header.php`, Social widget | Facebook URL |
| `header_twitter_url` | `header.php`, Social widget | Twitter URL |
| `header_pinterest_url` | `header.php`, Social widget | Pinterest URL |
| `header_linkedin_url` | `header.php`, Social widget | LinkedIn URL |
| `header_google_plus_url` | `header.php`, Social widget | Google Plus URL |
| `header_rss_url` | `header.php`, Social widget | RSS URL |
| `header_behance_url` | `header.php`, Social widget | Behance URL |
| `sidebar_position` | `page.php`, `single.php`, `search.php`, `404.php` | Left or right sidebar |
| `enable_back_to_top` | `footer.php` | Show/hide back-to-top button |
| `back_to_top_link` | `footer.php` | Back-to-top link target |
| `icon_class` | `footer.php` | Back-to-top icon class |
| `icon_size` | `footer.php` | Back-to-top icon size |

## 7. Menus

Menus are registered in `merotheme_setup()` inside `functions.php`.

Registered menu locations:

| Location | Used In | Purpose |
|---|---|---|
| `menu-1` | `header.php` | Main navigation |
| `footer-menu` | `footer.php` | Footer navigation |

Frontend calls:

```php
wp_nav_menu( array( 'theme_location' => 'menu-1' ) );
wp_nav_menu( array( 'theme_location' => 'footer-menu' ) );
```

## 8. Inner Page Hero Flow

Current flow:

```text
Visitor opens an inner page or post
WordPress loads page.php or single.php
Template calls get_header()
header.php checks page type
Because it is not homepage, header.php runs dynamic_sidebar( 'inner-page-hero-section' )
WordPress prints widgets placed in Inner Page Hero Section
MeroTheme Inner Page Hero widget prints .agile-banner
MeroTheme Breadcrumb widget prints breadcrumb
```

Current hero image source:

```text
Appearance > Widgets
Inner Page Hero Section
MeroTheme Inner Page Hero
Hero Image field
```

The selected image URL is saved in the widget instance as:

```text
hero_image
```

The admin image picker script is:

```text
assets/js/widget-media.js
```

## 9. How To Trace Any Section

Use this checklist whenever you want to understand a section:

1. Identify what page you are viewing.
   - Homepage?
   - Normal page?
   - Single post?
   - Search page?
   - 404 page?

2. Find the main template.
   - Homepage: `front-page.php`
   - Page: `page.php`
   - Single post: `single.php`
   - Sidebar: `sidebar.php`
   - Footer: `footer.php`

3. Follow template calls.
   - `get_header()` means open `header.php`.
   - `get_sidebar()` means open `sidebar.php`.
   - `get_footer()` means open `footer.php`.
   - `get_template_part()` means open the file in `template-parts/`.

4. Find widget areas.
   - Search for `dynamic_sidebar`.
   - Note the sidebar ID, for example `sidebar-1`.
   - Search that ID in `functions.php` to find `register_sidebar()`.

5. Find custom widgets.
   - Search for the widget title or class name in `functions.php`.
   - Read `widget()`, `form()`, and `update()`.

6. Identify value source.
   - `$instance[...]` means value comes from widget settings.
   - `get_field( ..., 'option' )` means value comes from ACF option page.
   - `get_option()` means value comes from WordPress options.
   - `WP_Query` means value comes from posts.
   - `the_post_thumbnail()` means value comes from Featured Image.
   - `wp_nav_menu()` means value comes from Appearance > Menus.

## 10. Quick Search Terms

Useful searches:

```text
dynamic_sidebar
register_sidebar
register_widget
class Merotheme
class MeroTheme
get_field
get_option
the_post_thumbnail
WP_Query
wp_nav_menu
```

These searches help you move from frontend output back to the code that controls it.

