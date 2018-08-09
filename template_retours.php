<?php
/**
 * Template Name: Retours
 *
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

include("templates/login_redirecter");

$query = new WP_Query(array(
    'post_type' => 'retouren',
    'post_status' => 'publish',
    'numberposts' => -1
));
wp_reset_query();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/samti.png"/>
    <meta charset="UTF-8">
    <title>Samti orders</title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/styles/styles.css">
<body id="body">

<?php include_once "templates/header.php" ?>

<div class="retours-wrapper">
    <div class="content-wrapper">
<?php

while ($query->have_posts()) {
    $query->the_post();
    $post_id = get_the_ID();
    ?>
    <div class="row single-retour-head">
        <div class="col-12 single-retour-info-head js-expand-click">
            <h2>Retour #<?php echo get_field('id', $post_id);?></h2>
            <span><?php echo get_field('webshop', $post_id) ?></span>
        </div>
        <div style="display: none;" class="single-retour-body col-12 js-expander">
            <div class="row">
                <div class="col-8">
                    <h3 class="omschrijving-title">Omschrijving:</h3>
                    <p class="omschrijving">
                        <?php echo get_field('omschrijving', $post_id);?>
                    </p>
                    <a href="<?php echo get_edit_post_link( $post_id) ?>">Wordpress edit</a>
                </div>
                <div class="col-4">
                    <div style="background-image: url('<?php echo get_field('foto', $post_id);?>')" class="picture-wrapper"></div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
    </div>
</div>

<a href="<?php echo admin_url() . "post-new.php?post_type=retouren" ?>" class="add-retour-link ">
    <span>Voeg een nieuwe retour toe</span>
</a>

</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/scripts/app.js"></script>