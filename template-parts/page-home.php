<?php
/*
Template Name: Home Page Layout
*/
get_header();

$pinned_args = array(
  'post_type' => 'news',
  'post_status' => 'publish',
  'posts_per_page' => 1,
  'orderby' => 'date',
  'order' => 'desc',
  'meta_query' => array(
		array(
			'key'     => 'news_pinned',
			'value'   => 1
		),
	),
);
$pinned_query = new WP_Query($pinned_args);
if ( $pinned_query->have_posts() ) {
	while ( $pinned_query->have_posts() ) {
		$pinned_query->the_post();
    // Include the page content template.
    echo "<div class='pinned'>";
    get_template_part( 'template-parts/content', 'pinned' );
    echo "</div>";
	}
	/* Restore original Post Data */
	wp_reset_postdata();
$fanfics_args = array(
  'post_type' => 'fanfic',
  'post_status' => 'publish',
  'posts_per_page' => 10,
  'orderby' => 'date',
  'order' => 'desc'
);

$newest_fanfics_query = new WP_Query($fanfics_args);
if ( $newest_fanfics_query->have_posts() ) {
  echo "<div class='latest-fanfics'>";
  echo "<h1>Latest Fanfics</h1>";
  $list_size = ceil($newest_fanfics_query->post_count / 2);
  echo "<ol class='left-list'>";
  $ff_idx = 1;
  while ( $newest_fanfics_query->have_posts() ) {
    $newest_fanfics_query->the_post();
    $series = wp_get_post_terms(get_the_id(), 'fandom-series');

    echo "<li>";
    echo "<a href='" . get_the_permalink() . "'>";
    echo $post->post_title . "</a><br/>";
    echo "<span class='fic-details'>";
    echo "By: " . get_the_author();
    if ( count( $series ) ) {
      $series_names = array();
      foreach ( $series as $series_obj ) {
        $series_names[] = $series_obj->name;
      }
      echo " | " . implode( ", ", $series_names);
    }
    echo "</span>";
    echo "</li>";
    if ($ff_idx == $list_size) {
      echo "</ol><ol class='right-list' start=" .( $list_size + 1) . ">";
    }
    $ff_idx++;
  }
  echo "</ol>";
  $fanfics = get_page_by_path('fanfics');
  echo "<div class='fanfics-link'><a href='" .  get_permalink($fanfics) . "'>Browse All Fanfics</a></div>";
  echo "<div style='clear:both;float:none;'></div></div>";
}
}


?>
<?php get_footer(); ?>
