<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->

    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>

    <div class="wrap base" role="document">
      <div class="inner-wrap">
        <main>

            <?php function case_study_projects() { ?> <?php // *** START Creating function to be pulled through accross all pages ***/ ?>
              <?php if( have_rows('case_studies_builder') ): ?> <?php // *** START Creating page builder fields ***/ ?>

                <?php $block_id = 0; ?> <?php // assigns zero index to ID ?>

                <?php while ( have_rows('case_studies_builder') ) : the_row(); ?>

                  <?php //************* MAIN BANNER *************?>

                  <?php if( get_row_layout() == 'project_column_4' ): ?>

                      <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: top center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                      ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <h2><?php the_sub_field('header'); ?></h2>
                          <!-- <div class="row"> -->
                            <div class="col-sm-4">
                              <div class="content">
                                <?php the_sub_field('content_area_1'); ?>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="content">
                                <?php the_sub_field('content_area_2'); ?>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="content">
                                <?php the_sub_field('content_area_3'); ?>
                              </div>
                            </div>
                          <!-- </div> -->
                        </div>
                      </div>

                  <?php endif; ?>
                <?php endwhile; ?>
              <?php endif; ?>
            <?php } ?>

            <?php function event_fields() { ?> <?php // *** START Creating function to be pulled through accross all pages ***/ ?>
              <?php if( have_rows('event_builder') ): ?> <?php // *** START Creating page builder fields ***/ ?>

                <?php $block_id = 0; ?> <?php // assigns zero index to ID ?>

                <?php while ( have_rows('event_builder') ) : the_row(); ?>

                  <?php //************* MAIN BANNER *************?>

                  <?php 
                    if( get_row_layout() == 'events' ): 


                      $event_name = get_field('event_name');
                      $location = get_field('location');
                      $organiser = get_field('organiser');
                      $cost = get_field('cost');

                      $rsvp = strtotime(get_field('rsvp'));
                      $rsvpDate = date_i18n("d M Y", $rsvp);

                      $start_date_picker = strtotime(get_field('start_date_picker'));

                      $d = date_i18n("d", $start_date_picker); // Single Date eg 05
                      $D = date_i18n("D", $start_date_picker); // Day eg Monday
                      $M = date_i18n("M", $start_date_picker); // Day eg January
                      $Y = date_i18n("Y", $start_date_picker); // Day eg 2017



                      /*Start Date*/
                      //$start_date_picker = strtotime(get_field('start_date_picker'));
                      $startDate = date_i18n("Ymd", $start_date_picker);

                      /*Start Time*/
                      $start_time_picker = strtotime(get_field('start_date_picker'));
                      $startTime = date_i18n("Hi00", $start_date_picker);
                      $startTimeFull = date_i18n("H:i a", $start_date_picker);

                      /*Start Output*/
                      $openingDateTime = $startDate."T".$startTime."Z";



                      /*End Date*/  
                      $end_date_picker = strtotime(get_field('end_date_picker'));
                      $endDate = date_i18n("Ymd", $end_date_picker);

                      /*End Time*/
                      $end_time_picker = strtotime(get_field('end_date_picker'));
                      $endTime = date_i18n("Hi00", $end_date_picker);
                      $endTimeFull = date_i18n("H:i a", $end_date_picker);
                      
                      /*End Output*/
                      $ClosingDateTime = $endDate."T".$endTime."Z";


                      $sessionTimes = $startTimeFull." - ".$endTimeFull;
                  ?>

                      <div id="<?php echo $block_id++; ?>" class="events">
                        <div class="container">
                          <!-- <div class="row">
                            <div class="col-sm-12 col-md-9 event-details">
                              <div class="content">
                                <div class="top-level">
                                  <h3><?php the_title(); ?></h3>
                                  <span>Date:</span> <?php echo $startDate; ?><br />
                                  <span>Time:</span> <?php echo $startTimeFull; ?> - <?php the_sub_field('end_time'); ?>
                                </div>
                                <span>RSVP:</span> <?php echo $rsvpDate; ?> | <span>Venue:</span> <?php the_sub_field('venue'); ?><br />
                                <span>Organiser:</span> <?php the_sub_field('organiser'); ?> | <span>Cost:</span> <?php the_sub_field('cost'); ?>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-3 interested">
                              <div class="content">
                                <h4>Interested?</h4>
                                <a href="#gform_wrapper_18" class="btn transparent-white-green">Book Now</a>
                              </div>
                            </div>
                          </div> -->
                          <?php the_sub_field('content_area'); ?>
                        </div>
                      </div>

                  <?php elseif( get_row_layout() == 'one_column' ): ?>
                      <?php

                        if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                          $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                        } else { // defaults value to colour

                          $style = "background-color: " . get_sub_field('background_type_colour');
                        }
                      ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="row">
                            <div class="col-sm-12">
                              <?php the_sub_field('content_area'); ?>
                            </div>
                          </div>
                        </div>
                      </div>


                   
                  
                  <?php elseif( get_row_layout() == 'schedule' ): ?>

                    <div class="schedule">
                    <strong>Schedule</strong>
                    
                    <?php

                      // check if the repeater field has rows of data
                      if( have_rows('slot') ): ?>
                        <ul>
                         <?php while ( have_rows('slot') ) : the_row(); ?>

                             
                              
                              <li><span class="time"><?php the_sub_field('time')?> </span>
                              <span class="details"><?php the_sub_field('details'); ?> </span>
                              </li>

                           


                        <?php  endwhile; ?>
                           </ul>

                        </div>
                      <?php endif; ?> 
           


                  <?php elseif( get_row_layout() == 'slider' ): ?>
                      <!-- http://codepen.io/bkainteractive/pen/VLxLYp -->
                      <?php

                        if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                          $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                        } else { // defaults value to colour

                          $style = "background-color: " . get_sub_field('background_type_colour');
                        }
                      ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="row">
                            <div class="col-md-12 heroSlider-fixed">
                              <div class="overlay"></div>
                              <!-- Slider -->
                              <!-- <div class="slider responsive"> -->
                                <?php the_sub_field('content_area'); ?>
                              <!-- </div> -->
                            </div>
                          </div>
                        </div>
                      </div>
                      
                  <?php endif; ?>
                <?php endwhile; ?>
              <?php endif; ?>
            <?php } ?>

            <?php function services_before_related_projects() { ?> <?php // *** START Creating function to be pulled through accross all pages ***/ ?>
              <?php if( have_rows('post_builder') ): ?> <?php // *** START Creating page builder fields ***/ ?>

                <?php $block_id = 0; ?> <?php // assigns zero index to ID ?>

                <?php while ( have_rows('post_builder') ) : the_row(); ?>

                  <?php if( get_row_layout() == 'before_related_projects' ): ?>

                      <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: top center; background-image: url('" . get_sub_field('background_type_image') ."')";

                        } else { // defaults value to colour

                          $style = "background-color: " . get_sub_field('background_type_colour');
                        }
                      ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="row">
                            <div class="col-sm-12 col-md-6 left">
                              <?php the_sub_field('content_area_1'); ?>
                            </div>
                            <div class="col-sm-12 col-md-6 right">
                              <?php the_sub_field('content_area_2'); ?>
                            </div>
                          </div>
                        </div>
                      </div>

                  <?php endif; ?>

                <?php endwhile; ?>
              <?php endif; ?>
            <?php } ?>

            <?php function custom_fields() { ?> <?php // *** START Creating function to be pulled through accross all pages ***/ ?>

              <?php if( have_rows('page_builder') ): ?> <?php // *** START Creating page builder fields ***/ ?>

                <?php $block_id = 0; ?> <?php // assigns zero index to ID ?>

                <?php while ( have_rows('page_builder') ) : the_row(); ?>

                  <?php //************* MAIN BANNER *************?>

                  <?php if( get_row_layout() == 'main_banner' ): ?>

                    <?php
                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-position: top center; background-size: cover; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-position-y: 0px; background-size: cover; background-color: " . get_sub_field('background_type_colour');
                      }
                    ?>

                    <div id="banner" class="<?php the_sub_field('section_class'); ?> desktop hidden-sm hidden-xs" style="<?php echo $style; ?>">
                      <div class="container">
                        <div class="content">
                          <section>
                            <?php the_sub_field('content_area_1'); ?>
                          </sectio>
                        </div>
                      </div>
                    </div>


                    <?php  if (is_page( 'services' )) { ?>

                        <div id="banner" class="<?php the_sub_field('section_class'); ?> mobile hidden-lg hidden-md visible-sm visible-xs">
                          <?php
                            if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image
                              $image_url = get_sub_field('background_type_image', 'mobile-banner');
                              $mobilestyle = "background-repeat: no-repeat; background-position: top center; background-size: cover; background-image: url('" . $image_url ."')";
                            } else { // defaults value to colour
                              $mobilestyle = "background: #2c2c2c;";
                            }
                          ?>
                          <div class="thumb" style="<?php echo $mobilestyle ?>">
                            <div class="container">
                              <div class="content">
                                <section>
                                  <?php the_sub_field('content_area_1'); ?>
                                </section>
                              </div>
                            </div>
                          </div>
                        </div>

                    <?php } else { ?>

                        <div id="banner" class="<?php the_sub_field('section_class'); ?> mobile hidden-lg hidden-md visible-sm visible-xs">
                          <?php
                            if( kdmfi_has_featured_image( 'mobile-featured-image' ) ) {
                              $image_url = kdmfi_get_featured_image_src('mobile-featured-image', 'mobile-banner');
                              $mobilestyle = "background-repeat: no-repeat; background-position: top center; background-size: cover; background-image: url('" . $image_url ."')";
                            } else {
                              $mobilestyle = "background: #2c2c2c;";
                            }
                          ?>
                          <div class="thumb" style="<?php echo $mobilestyle ?>">
                            <div class="container">
                              <div class="content">
                                <section>
                                  <?php the_sub_field('content_area_1'); ?>
                                </section>
                              </div>
                            </div>
                          </div>
                        </div>

                    <?php } ?>


                    <?php elseif( get_row_layout() == 'banner_two' ): ?>

                    <?php
                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-position: top center; background-size: cover; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-position-y: 0px; background-size: cover; background-color: " . get_sub_field('background_type_colour');
                      }
                    ?>

                    <div id="banner" class="<?php the_sub_field('section_class'); ?> desktop hidden-sm hidden-xs" style="<?php echo $style; ?>">
                      <div class="container">
                        <div class="content">
                          <section>
                            <?php the_sub_field('content_area_1'); ?>
                          </sectio>
                        </div>
                      </div>
                    </div>

                    <div id="banner" class="<?php the_sub_field('section_class'); ?> mobile hidden-lg hidden-md visible-sm visible-xs">
                      <div class="thumb" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="content">
                            <section>
                              <?php the_sub_field('content_area_1'); ?>
                            </section>
                          </div>
                        </div>
                      </div>
                    </div>



                  <?php //************* COL-SM-12 ROW *************?>
                  <?php elseif( get_row_layout() == 'full_width' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                    ?>

                    <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                      <?php the_sub_field('content_area'); ?>
                    </div>


                  <?php elseif( get_row_layout() == 'column_12' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                    ?>

                    <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                      <div class="container">
                        <div class="row">
                          <div class="col-sm-12">
                            <?php the_sub_field('content_area'); ?>
                          </div>
                        </div>
                      </div>
                    </div>


                  <?php //************* COL-SM-12 ROW *************?>
                  <?php elseif( get_row_layout() == 'column_12' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                    ?>

                    <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                      <div class="container">
                        <div class="col-sm-12">
                          <?php the_sub_field('content_area'); ?>
                        </div>
                      </div>
                    </div>

                  
                  <?php //************* COL-SM-6 ROW *************?>
                  <?php elseif( get_row_layout() == 'column_6' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                        } else { // defaults value to colour

                          $style = "background-color: " . get_sub_field('background_type_colour');
                        }
                      ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="row">
                            <div class="col-sm-12 col-md-6 left">
                              <?php the_sub_field('content_area_1'); ?>
                            </div>
                            <div class="col-sm-12 col-md-6 right">
                              <?php the_sub_field('content_area_2'); ?>
                            </div>
                          </div>
                        </div>
                      </div>

                  
                  <?php //************* COL-SM-6 FULL WIDTH ROW *************?>
                  <?php elseif( get_row_layout() == 'column_6_full_width' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image') { // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                        } else { // defaults value to colour

                          $style = "background-color: " . get_sub_field('background_type_colour');
                        }
                      ?>

                      <?php
                      if (get_sub_field('background_type_2') == 'image') { // checks to see if the radio button's value is image

                        $style2 = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image_2') ."')";

                        } else { // defaults value to colour

                          $style2 = "background-color: " . get_sub_field('background_type_colour_2');
                        }
                      ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" >
                        <div class="row">
                          <div class="col-sm-12 col-md-6 left" style="<?php echo $style; ?>">
                            <?php the_sub_field('content_area_1'); ?>
                          </div>
                          <div class="col-sm-12 col-md-6 right" style="<?php echo $style2; ?>">
                            <div class="content">
                              <?php the_sub_field('content_area_2'); ?>
                            </div>
                          </div>
                        </div>
                      </div>

                  
                  <?php //************* COL-SM-8-4 ROW *************?>
                  <?php elseif( get_row_layout() == 'column_8_4' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                        } else { // defaults value to colour

                          $style = "background-color: " . get_sub_field('background_type_colour');
                        }
                      ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="row">
                            <div class="col-sm-12 col-md-8 left">
                              <?php the_sub_field('content_area_1'); ?>
                            </div>
                            <div class="col-sm-12 col-md-4 right">
                              <?php the_sub_field('content_area_2'); ?>
                            </div>
                          </div>
                        </div>
                      </div>


                  <?php //************* COL-SM-4 ROW *************?>
                  <?php elseif( get_row_layout() == 'column_4' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                    ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="row">
                            <div class="col-sm-4">
                              <?php the_sub_field('content_area_1'); ?>
                            </div>
                            <div class="col-sm-4">
                              <?php the_sub_field('content_area_2'); ?>
                            </div>
                            <div class="col-sm-4">
                              <?php the_sub_field('content_area_3'); ?>
                            </div>
                          </div>
                        </div>
                      </div>

                    <?php //************* COL-SM-3 ROW *************?>

                    <?php elseif( get_row_layout() == 'column_3' ): ?>

                      <?php

                          if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                    ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="header"><?php the_sub_field('header'); ?></div>
                          <div class="row">
                            <div class="threeCols">
                              <div class="col-sm-12 col-md-4 cols">
                                <?php the_sub_field('content_area_1'); ?>
                              </div>
                              <div class="col-sm-12 col-md-4 cols">
                                <?php the_sub_field('content_area_2'); ?>
                              </div>
                              <div class="col-sm-12 col-md-4 cols">
                                <?php the_sub_field('content_area_3'); ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                  
                  <?php //************* OUR SERVICES ROW *************?>
                  <?php elseif( get_row_layout() == 'home_our_services' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                    ?>

                    <?php

                       $args = array(
                        'post_type' => 'services',
                        // 'category_name' => 'services',
                        'orderby' => 'title',
                        'order' => 'ASC',
                        'posts_per_page' => 6
                      );

                      $the_query = new WP_Query( $args );
                    ?>

                    <?php if ( $the_query->have_posts() ) : ?>
                      <div id="ourServices-Column" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="content">
                            <div class="row">
                              <div class="header col-lg-12 col-md-12 col-sm-12 col-xs-12"><h1><?php the_sub_field('header'); ?></h1></div>
                              <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 articles">
                                  <a href="<?php the_permalink() ?>"><?php the_post_thumbnail('full') ?></a>
                                  <div class="title"><h2><?php the_title(); ?></h2></div>
                                  <div class="excerpt"><?php the_excerpt(); ?></div>
                                </div>
                              <?php endwhile; endif; ?>
                              <?php wp_reset_query(); ?>
                            </div>
                            <div class="row">

                              <div class="description default">

                                <div class="default">
                                  <div class="intro col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <?php the_sub_field('content_area_1'); ?>
                                  </div>
                                  <div class="content col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <?php the_sub_field('content_area_2'); ?>
                                  </div>
                                  <div class="content col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <?php the_sub_field('content_area_3'); ?>
                                  </div>
                                </div>

                                <!-- <div class="article">
                                  <div class="intro col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <?php the_sub_field('content_area_1'); ?>
                                  </div>
                                  <div class="content col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <?php the_sub_field('content_area_2'); ?>
                                  </div>
                                  <div class="content col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <?php the_sub_field('content_area_3'); ?>
                                  </div>
                                </div> -->

                              </div>

                            </div>

                          </div>
                        </div>
                      </div>
                    <?php endif; ?>


                  <?php //************* TIMELINE ROW *************?>
                  <?php elseif( get_row_layout() == 'timeline' ): ?>

                    <?php if( have_rows('timeline_date') ): ?>
                      <div id="<?php echo $block_id++; ?>" class="section timeline no-top-padding"> 
                        <div class="container">
                          <div class="row">
                            <ul class="slides">

                              <?php while( have_rows('timeline_date') ): the_row(); 

                                // vars
                                $date = get_sub_field('date' );
                                $content = get_sub_field('content');
                                ?>

                                <li class="slide">
                                  <div class="date"><?php echo $date; ?></div>
                                </li>

                              <?php endwhile; ?>

                            </ul>

                            <ul class="slides-content">

                              <?php while( have_rows('timeline_date') ): the_row(); 

                                // vars
                                $date = get_sub_field('date' );
                                $content = get_sub_field('content');
                                ?>

                                <li class="slide">
                                  <div class="content"><?php echo $content; ?></div>
                                </li>

                              <?php endwhile; ?>

                            </ul>
                            
                          </div>
                        </div>
                      </div>
                    <?php endif; ?>

                  
                  <?php //************* HOME CASE STUDIES ROW *************?>
                  <?php elseif( get_row_layout() == 'home_case_studies' ): ?>

                    <?php
                      /* Background 1=====================================================*/
                      if (get_sub_field('background_type1') == 'image'){ // checks to see if the radio button's value is image

                        $style1 = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image1') ."')";

                      } else { // defaults value to colour

                        $style1 = "background-color: " . get_sub_field('background_type_colour1');
                      }

                      /* Background 2=====================================================*/
                      if (get_sub_field('background_type2') == 'image'){ // checks to see if the radio button's value is image

                        $style2 = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image2') ."')";

                      } else { // defaults value to colour

                        $style2 = "background-color: " . get_sub_field('background_type_colour2');
                      }

                      /* Background 3=====================================================*/
                      if (get_sub_field('background_type3') == 'image'){ // checks to see if the radio button's value is image

                        $style3 = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image3') ."')";

                      } else { // defaults value to colour

                        $style3 = "background-color: " . get_sub_field('background_type_colour3');
                      }

                      /* Background 4=====================================================*/
                      if (get_sub_field('background_type4') == 'image'){ // checks to see if the radio button's value is image

                        $style4 = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image4') ."')";

                      } else { // defaults value to colour

                        $style4 = "background-color: " . get_sub_field('background_type_colour4');
                      }
                    ?>

                    <div id="hp-case-studies" class="<?php the_sub_field('section_class'); ?>">
                      <div class="full-container">
                          <div class="col-sm-6 hover-zoom" style="<?php echo $style1; ?>">
                            <div class="content">
                              <h1><?php the_sub_field('header1'); ?></h1>
                              <?php the_sub_field('content_area_1'); ?>
                            </div>
                          </div>
                          <div class="col-sm-3 col_2 hover-zoom" style="<?php echo $style2; ?>">
                            <?php the_sub_field('content_area_2'); ?>
                          </div>
                          <div class="col-sm-3 col_3 hover-zoom">
                            <div class="row" style="<?php echo $style3; ?>">
                              <?php the_sub_field('content_area_3'); ?>
                            </div>
                            <div class="row" style="<?php echo $style4; ?>">
                              <?php the_sub_field('content_area_4'); ?>
                            </div>
                          </div>
                      </div>
                    </div>

                  
                  <?php //************* MAPS ROW *************?>
                  <?php elseif( get_row_layout() == 'maps' ): ?>
                    <div id="<?php the_sub_field('section_class'); ?>">
                      <div id="map_container">
                        <div id="map"></div>
                      </div>
                    </div>

                  
                  <?php elseif( get_row_layout() == 'column_4_x_9' ): ?>

                      <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                      ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="row">

                            <?php if( get_sub_field('content_area_1') ): ?>
                              <div class="col-xs-12 col-sm-6 col-md-4 content">
                                <?php the_sub_field('content_area_1'); ?>
                              </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_2') ): ?>
                              <div class="col-xs-12 col-sm-6 col-md-4 content">
                                <?php the_sub_field('content_area_2'); ?>
                              </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_3') ): ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 content">
                              <?php the_sub_field('content_area_3'); ?>
                            </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_4') ): ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 content">
                              <?php the_sub_field('content_area_4'); ?>
                            </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_5') ): ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 content">
                              <?php the_sub_field('content_area_5'); ?>
                            </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_6') ): ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 content">
                              <?php the_sub_field('content_area_6'); ?>
                            </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_7') ): ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 content">
                              <?php the_sub_field('content_area_7'); ?>
                            </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_8') ): ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 content">
                              <?php the_sub_field('content_area_8'); ?>
                            </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_9') ): ?>
                              <div class="col-xs-12 col-sm-6 col-md-4 content">
                                <?php the_sub_field('content_area_9'); ?>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>


                  <?php endif; ?>

                <?php endwhile; ?>

              <?php else : ?>

              <?php endif; ?><?php // *** END Creating page builder fields ***/ ?>

              <?php if( have_rows('post_builder') ): ?> <?php // *** START Creating post builder fields ***/ ?>

                <?php $block_id = 0; ?> <?php // assigns zero index to ID ?>

                <?php while ( have_rows('post_builder') ) : the_row(); ?>

                  <?php //************* MAIN BANNER *************?>

                  <?php if( get_row_layout() == 'main_banner' ): ?>


                    <?php


                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: top center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                    ?>

                    <div id="banner" class="<?php the_sub_field('section_class'); ?> desktop hidden-sm hidden-xs" style="<?php echo $style; ?>">
                      <div class="container">
                        <div class="content">
                          <section>
                            <?php the_sub_field('content_area'); ?>
                          </sectio>
                        </div>
                      </div>
                    </div>

                    <div id="banner" class="<?php the_sub_field('section_class'); ?> mobile hidden-lg hidden-md visible-sm visible-xs">
                      <?php
                        if( kdmfi_has_featured_image( 'mobile-featured-image' ) ) {
                          $image_url = kdmfi_get_featured_image_src('mobile-featured-image', 'mobile-banner');
                          $mobilestyle = "background-repeat: no-repeat; background-position: top center; background-size: cover; background-image: url('" . $image_url ."')";
                        } else {
                          $mobilestyle = "background: #2c2c2c;";
                        }
                      ?>
                      <div class="thumb" style="<?php echo $mobilestyle ?>">
                        <div class="container">
                          <div class="content">
                            <section>
                              <?php the_sub_field('content_area'); ?>
                            </section>
                          </div>
                        </div>
                      </div>
                    </div>


                  <?php elseif( get_row_layout() == 'full_width' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                    ?>

                    <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                      <?php the_sub_field('content_area'); ?>
                    </div>


                  <?php elseif( get_row_layout() == 'column_12' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                    ?>

                    <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                      <div class="container">
                        <div class="row">
                          <div class="col-sm-12">
                            <?php the_sub_field('content_area'); ?>
                          </div>
                        </div>
                      </div>
                    </div>

                  <?php elseif( get_row_layout() == 'column_6' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                        } else { // defaults value to colour

                          $style = "background-color: " . get_sub_field('background_type_colour');
                        }
                      ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="row">
                            <div class="col-sm-12 col-md-6 left">
                              <?php the_sub_field('content_area_1'); ?>
                            </div>
                            <div class="col-sm-12 col-md-6 right">
                              <?php the_sub_field('content_area_2'); ?>
                            </div>
                          </div>
                        </div>
                      </div>


                    <?php elseif( get_row_layout() == 'column_4' ): ?>

                      <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                      ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="row">

                            <div class="col-sm-4">
                              <?php the_sub_field('content_area_1'); ?>
                            </div>
                            <div class="col-sm-4">
                              <?php the_sub_field('content_area_2'); ?>
                            </div>
                            <div class="col-sm-4">
                              <?php the_sub_field('content_area_3'); ?>
                            </div>
                          </div>
                        </div>
                      </div>


                    <?php elseif( get_row_layout() == 'column_4_x_9' ): ?>

                      <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                      ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="row">

                            <?php if( get_sub_field('content_area_1') ): ?>
                              <div class="col-xs-12 col-sm-6 col-md-4 content">
                                <?php the_sub_field('content_area_1'); ?>
                              </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_2') ): ?>
                              <div class="col-xs-12 col-sm-6 col-md-4 content">
                                <?php the_sub_field('content_area_2'); ?>
                              </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_3') ): ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 content">
                              <?php the_sub_field('content_area_3'); ?>
                            </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_4') ): ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 content">
                              <?php the_sub_field('content_area_4'); ?>
                            </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_5') ): ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 content">
                              <?php the_sub_field('content_area_5'); ?>
                            </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_6') ): ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 content">
                              <?php the_sub_field('content_area_6'); ?>
                            </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_7') ): ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 content">
                              <?php the_sub_field('content_area_7'); ?>
                            </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_8') ): ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 content">
                              <?php the_sub_field('content_area_8'); ?>
                            </div>
                            <?php endif; ?>

                            <?php if( get_sub_field('content_area_9') ): ?>
                              <div class="col-xs-12 col-sm-6 col-md-4 content">
                                <?php the_sub_field('content_area_9'); ?>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>


                  <?php endif; ?>
                <?php endwhile; ?>
              <?php endif; ?>

              <?php if( have_rows('case_studies_builder') ): ?> <?php // *** START Creating Case Studies builder fields ***/ ?>

                <?php $block_id = 0; ?> <?php // assigns zero index to ID ?>

                <?php while ( have_rows('case_studies_builder') ) : the_row(); ?>

                  <?php //************* MAIN BANNER *************?>

                  <?php if( get_row_layout() == 'main_banner' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: top center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-position-y: 0px; background-size: cover; background-color: " . get_sub_field('background_type_colour');
                      }
                    ?>

                    <div id="banner" class="<?php the_sub_field('section_class'); ?> desktop hidden-sm hidden-xs" style="<?php echo $style; ?>" data-stellar-background-ratio="0">
                      <div class="container">
                        <div class="content">
                          <section>
                            <?php the_sub_field('content_area'); ?>
                          </section>
                        </div>
                      </div>
                    </div>

                    <div id="banner" class="<?php the_sub_field('section_class'); ?> mobile hidden-lg hidden-md visible-sm visible-xs">
                      <?php
                        if( kdmfi_has_featured_image( 'mobile-featured-image' ) ) {
                          $image_url = kdmfi_get_featured_image_src('mobile-featured-image', 'mobile-banner');
                          $mobilestyle = "background-repeat: no-repeat; background-position: top center; background-size: cover; background-image: url('" . $image_url ."')";
                        } else {
                          $mobilestyle = "background: #2c2c2c;";
                        }
                      ?>
                      <div class="thumb" style="<?php echo $mobilestyle ?>">
                        <div class="container">
                          <div class="content">
                            <section>
                              <?php the_sub_field('content_area'); ?>
                            </section>
                          </div>
                        </div>
                      </div>
                    </div>


                  <?php elseif( get_row_layout() == 'full_width' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                    ?>

                    <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                      <?php the_sub_field('content_area'); ?>
                    </div>


                  <?php elseif( get_row_layout() == 'column_12' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                    ?>

                    <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                      <div class="container">
                        <div class="row">
                          <div class="col-sm-12">
                            <?php the_sub_field('content_area'); ?>
                          </div>
                        </div>
                      </div>
                    </div>


                  <?php elseif( get_row_layout() == 'column_6' ): ?>

                    <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                        } else { // defaults value to colour

                          $style = "background-color: " . get_sub_field('background_type_colour');
                        }
                      ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="row">
                            <div class="col-sm-12 col-md-6 left">
                              <?php the_sub_field('content_area_1'); ?>
                            </div>
                            <div class="col-sm-12 col-md-6 right">
                              <?php the_sub_field('content_area_2'); ?>
                            </div>
                          </div>
                        </div>
                      </div>



                    <?php elseif( get_row_layout() == 'column_4' ): ?>

                      <?php

                      if (get_sub_field('background_type') == 'image'){ // checks to see if the radio button's value is image

                        $style = "background-repeat: no-repeat; background-size: cover; background-position: center center; background-image: url('" . get_sub_field('background_type_image') ."')";

                      } else { // defaults value to colour

                        $style = "background-color: " . get_sub_field('background_type_colour');
                      }
                      ?>

                      <div id="<?php echo $block_id++; ?>" class="<?php the_sub_field('section_class'); ?>" style="<?php echo $style; ?>">
                        <div class="container">
                          <div class="row">
                            <div class="col-sm-4">
                              <?php the_sub_field('content_area_1'); ?>
                            </div>
                            <div class="col-sm-4">
                              <?php the_sub_field('content_area_2'); ?>
                            </div>
                            <div class="col-sm-4">
                              <?php the_sub_field('content_area_3'); ?>
                            </div>
                          </div>
                        </div>
                      </div>


                  <?php endif; ?>
                <?php endwhile; ?>
              <?php endif; ?>

          <?php }?> <?php // *** END Creating function to be pulled through accross all pages ***/ ?>

          <?php include Wrapper\template_path(); ?>
        </main><?php // /.main ?>
      </div><?php // /.content ?>
    </div><?php // /.wrap ?>
    <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>

    <!-- Modal -->
    <div class="modal fade" id="YoutubeModal" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="modal-body">
            <div style="position:relative;height:0;padding-bottom:56.21%"><iframe src="https://www.youtube.com/embed/pG5fnVwZ3S0?ecver=2&rel=0" style="position:absolute;width:100%;height:100%;left:0" width="641" height="360" frameborder="0" allowfullscreen></iframe></div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
