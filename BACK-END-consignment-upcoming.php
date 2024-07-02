<?php
/*
 * List View for upcoming consignments
 */

$featuredImage = get_field('featured_image');
$startDate = get_field('sales_date_start');
$endDate = get_field('sales_date_end');
$closedDate = get_field('entries_closed_date');
$sellingDateText = get_field('selling_date_text');
$sortingTabs = get_field('sorting_tabs');
$consignment_post = get_page_by_title('2024 Fasig-Tipton July Horses of Racing Age Sale', OBJECT, 'consignment');
$consignment_id = $consignment_post ? $consignment_post->ID : 0;

function clean($string)
{
    $string = str_replace(' ', '', $string);
    return preg_replace('/[^A-Za-z0-9\-]/', '', strtolower($string));
}

// Build Custom Consignment Tabs
function display_upcoming_consignment($consignment_id, $sortingTabs)
{
    if (empty($sortingTabs)) {
        $consignmentArgs = array(
            'post_type' => 'horse',
            'post_status' => 'publish',
            'meta_key' => 'horsehosting_hip_number',
            'orderby'  => 'meta_value',
            'order'    => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'horsehosting_consignment',
                    'compare' => 'LIKE',
                    'value' => $consignment_id,
                ),
            ),
            'posts_per_page' => -1,
        );
    } else {
        $consignmentArgs = array(
            'post_type' => 'horse',
            'post_status' => 'publish',
            'meta_key' => 'horsehosting_hip_number',
            'orderby'  => 'meta_value',
            'order'    => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'horsehosting_consignment',
                    'compare' => 'LIKE',
                    'value' => $consignment_id,
                ),
            ),
            'tax_query' => array(
                array(
                    'taxonomy' => 'tag',
                    'field'    => 'slug',
                    'terms'    => $sortingTabs,
                ),
            ),
            'posts_per_page' => -1,
        );
    }
    $consignment_query = new WP_Query($consignmentArgs);

    if ($consignment_query->have_posts()) {
        echo '<div class="row">';
        while ($consignment_query->have_posts()) {
            $consignment_query->the_post();
            echo '<div class="col-12 col-md-3 mb-4">';
            echo '<div class="upcoming-consignment-horse gold-border p-5 text-center h-100">';
            echo '<p>';
            echo '<strong class="h4">HIP ' . get_field('horsehosting_hip_number') . '</strong><br>';
            echo '<strong class="h4">' . get_the_title() . '</strong><br>';
            echo get_field('horsehosting_birth_year') . ' ';
            echo get_field('horsehosting_color') . ' ';
            echo get_field('horsehosting_sex') . ' by ';
            echo get_field('horsehosting_sire') . ' ';

            $passport_document = get_field('passport_document');
            if ($passport_document) {
                echo '<a href="' . $passport_document . '" class="btn gold-border mt-4 card-btn html5lightbox">Passport</a>';
            }

            $catalogue_url = get_field('horsehosting_catalogue_url');
            if ($catalogue_url) {
                echo '<a href="' . $catalogue_url . '" class="btn gold-border mt-4 card-btn html5lightbox">Enhanced Catalogue</a>';
            }

            echo '</p>';
            echo '<img src="' . get_template_directory_uri() . '/images/no-photo-blank.png" class="flip-card-back-img">';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>' . esc_html__('Sorry, no horses matched your criteria.') . '</p>';
    }
}
?>

<?php
if ($sortingTabs) : ?>
    <div class="row mt-5 mb-5">
        <div class="col-12">
            <div class="nav justify-content-center" id="consignment-tabs" role="tablist">

                <button class="nav-link active blue" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all" aria-selected="true">
                    <strong>All</strong>
                </button>

                <?php if ($sortingTabs['tab_1']) : ?>
                    <button class="nav-link blue" id="nav-<?php echo clean($sortingTabs['tab_1']); ?>-tab" data-bs-toggle="tab" data-bs-target="#nav-<?php echo clean($sortingTabs['tab_1']); ?>" type="button" role="tab" aria-controls="nav-<?php echo clean($sortingTabs['tab_1']); ?>" aria-selected="true">
                        <strong><?php echo $sortingTabs['tab_1']; ?></strong>
                    </button>
                <?php endif; ?>

                <?php if ($sortingTabs['tab_2']) : ?>
                    <button class="nav-link blue" id="nav-<?php echo clean($sortingTabs['tab_2']); ?>-tab" data-bs-toggle="tab" data-bs-target="#nav-<?php echo clean($sortingTabs['tab_2']); ?>" type="button" role="tab" aria-controls="nav-<?php echo clean($sortingTabs['tab_2']); ?>" aria-selected="false" tabindex="-1">
                        <strong><?php echo $sortingTabs['tab_2']; ?></strong>
                    </button>
                <?php endif; ?>

                <?php if ($sortingTabs['tab_3']) : ?>
                    <button class="nav-link blue" id="nav-<?php echo clean($sortingTabs['tab_3']); ?>-tab" data-bs-toggle="tab" data-bs-target="#nav-<?php echo clean($sortingTabs['tab_3']); ?>" type="button" role="tab" aria-controls="nav-<?php echo clean($sortingTabs['tab_3']); ?>" aria-selected="false" tabindex="-1">
                        <strong><?php echo $sortingTabs['tab_3']; ?></strong>
                    </button>
                <?php endif; ?>

                <?php if ($sortingTabs['tab_4']) : ?>
                    <button class="nav-link blue" id="nav-<?php echo clean($sortingTabs['tab_4']); ?>-tab" data-bs-toggle="tab" data-bs-target="#nav-<?php echo clean($sortingTabs['tab_4']); ?>" type="button" role="tab" aria-controls="nav-<?php echo clean($sortingTabs['tab_4']); ?>" aria-selected="false" tabindex="-1">
                        <strong><?php echo $sortingTabs['tab_4']; ?></strong>
                    </button>
                <?php endif; ?>

            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($sellingDateText) : ?>
    <h3 class="gold mb-5 text-center"><?php echo $sellingDateText; ?></h3>
<?php endif; ?>

<?php if ($sortingTabs) : ?>
    <div class="tab-content" id="nav-tabContent">

        <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">

            <?php display_upcoming_consignment($consignment_id, null); ?>

        </div>

        <?php if ($sortingTabs['tab_1']) : ?>
            <div class="tab-pane fade" id="nav-<?php echo clean($sortingTabs['tab_1']); ?>" role="tabpanel" aria-labelledby="nav-<?php echo clean($sortingTabs['tab_1']); ?>-tab">

                <?php display_upcoming_consignment($consignment_id, $sortingTabs['tab_1']); ?>

            </div>
        <?php endif; ?>

        <?php if ($sortingTabs['tab_2']) : ?>
            <div class="tab-pane fade" id="nav-<?php echo clean($sortingTabs['tab_2']); ?>" role="tabpanel" aria-labelledby="nav-<?php echo clean($sortingTabs['tab_2']); ?>-tab">

                <?php display_upcoming_consignment($consignment_id, $sortingTabs['tab_2']); ?>

            </div>
        <?php endif; ?>

        <?php if ($sortingTabs['tab_3']) : ?>
            <div class="tab-pane fade" id="nav-<?php echo clean($sortingTabs['tab_3']); ?>" role="tabpanel" aria-labelledby="nav-<?php echo clean($sortingTabs['tab_3']); ?>-tab">

                <?php display_upcoming_consignment($consignment_id, $sortingTabs['tab_3']); ?>

            </div>
        <?php endif; ?>

        <?php if ($sortingTabs['tab_4']) : ?>
            <div class="tab-pane fade" id="nav-<?php echo clean($sortingTabs['tab_4']); ?>" role="tabpanel" aria-labelledby="nav-<?php echo clean($sortingTabs['tab_4']); ?>-tab">

                <?php display_upcoming_consignment($consignment_id, $sortingTabs['tab_4']); ?>

            </div>
        <?php endif; ?>
    </div>
<?php else : ?>
    <?php if ($sellingDateText) : ?>
        <h3 class="gold mb-5 text-center"><?php echo $sellingDateText; ?></h3>
    <?php endif; ?>

    <?php display_upcoming_consignment($consignment_id, null); ?>
<?php endif; ?>