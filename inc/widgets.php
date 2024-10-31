<?php
	require PARALLEL_EXTENSIONS_PATH . 'widgets/brands_widget.php';
	require PARALLEL_EXTENSIONS_PATH . 'widgets/feature_widget.php';
	require PARALLEL_EXTENSIONS_PATH . 'widgets/testimonials_widget.php';
	require PARALLEL_EXTENSIONS_PATH . 'widgets/service_widget.php';
	require PARALLEL_EXTENSIONS_PATH . 'widgets/our_team_widget.php';
	/*
	*	Check for Pro Version
	*/
	$theme = wp_get_theme(); // gets the current theme
	if ( 'Parallel Pro' == $theme->name || 'Parallel Pro' == $theme->parent_theme ) {
	    require PARALLEL_EXTENSIONS_PATH . 'widgets/our_clients_widget.php';
	    require PARALLEL_EXTENSIONS_PATH . 'widgets/pricing_tables_widget.php';
	    require PARALLEL_EXTENSIONS_PATH . 'widgets/project_grid_widget.php';
	    require PARALLEL_EXTENSIONS_PATH . 'widgets/projects_single_widget.php';
	    require PARALLEL_EXTENSIONS_PATH . 'widgets/stats_widget.php';
	}
	add_action( 'admin_enqueue_scripts', 'parallel_wcp_upload_script' );
	add_action( 'wp_head', 'parallel_wcp_image_styles' );
	/*
	*	Script for Media uploader
	*/
	function parallel_wcp_upload_script($hook){
	    if ( 'widgets.php' != $hook ) {
	        return;
	    }
	    wp_enqueue_media();
	    wp_enqueue_script('wcp_uploader', PARALLEL_EXTENSIONS_URL . 'js/admin.js', array('jquery') );
	    wp_enqueue_script('jquery-ui-datepicker');
	    wp_enqueue_script('jquery-ui-core');
	}
	function parallel_wcp_image_styles(){
		wp_register_style('wcp-caption-styles', PARALLEL_EXTENSIONS_URL . 'css/widgets.css' );
	}
?>