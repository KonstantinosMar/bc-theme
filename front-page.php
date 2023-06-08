<?php
use Timber\Timber;
use BC\Controllers\Homepage;

$homepageLoader = new Homepage();

//if ( is_active_sidebar( 'custom-homepage-widget' ) ) {
//    ?>
<!--    <div id="header-widget-area" class="chw-widget-area widget-area" role="complementary">-->
<!--    --><?php //dynamic_sidebar( 'custom-homepage-widget' ); ?>
<!--    </div>-->
<?php
//}



Timber::render(array('front-page.twig'), $homepageLoader->getContext());