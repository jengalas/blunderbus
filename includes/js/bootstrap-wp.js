jQuery( document ).ready( function( $ ) {

    fakewaffle.responsiveTabs(['xs', 'sm']);

    $( 'input.search-field' ).addClass( 'form-control' );

    // here for each comment reply link of wordpress
    $( '.comment-reply-link' ).addClass( 'btn btn-primary' );

    // here for the submit button of the comment reply form and contact form
    $( '#commentsubmit, div.frm_submit input' ).addClass( 'btn btn-primary' );

    // some more styles for comment form and Formidable contact form. See main styles in wp-content/plugins/formidable/css/frm_display.css

    $( 'div.frm_form_field input, div.frm_form_field textarea, form.wpv-filter-form input, form.wpv-filter-form select, #commentform input[type="text"]' ).addClass( 'form-control' );

    // The WordPress Default Widgets
    // Now we'll add some classes for the wordpress default widgets - let's go

    // the search widget
    $( 'input.search-field' ).addClass( 'form-control' );
    $( 'input.search-submit' ).addClass( 'btn btn-default' );

    $( '.widget_rss ul' ).addClass( 'media-list' );

    $( '.widget_meta ul, .widget_recent_entries ul, .widget_archive ul, .widget_categories ul, .widget_nav_menu ul, .widget_pages ul' ).addClass( 'nav' );

    $( '.widget_recent_comments ul#recentcomments' ).css( 'list-style', 'none').css( 'padding-left', '0' );
    $( '.widget_recent_comments ul#recentcomments li' ).css( 'padding', '5px 15px');

    $( 'table#wp-calendar' ).addClass( 'table table-striped');
} );
