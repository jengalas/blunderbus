<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Blunderbus
 */
?>
			</div><!-- close .*-inner (main-content or sidebar, depending if sidebar is used) -->
		</div><!-- close .row -->
	</div><!-- close .container -->
</div><!-- close .main-content -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="container">
		<div class="row">
			<div class="site-footer-inner col-sm-12">
				<div id="footer-sidebar" class="secondary">
					<div id="footer-sidebar1" class="col-md-4">
						<?php
						if(is_active_sidebar('footer-sidebar-1')){
						dynamic_sidebar('footer-sidebar-1');
						}
						?>
					</div>
					<div id="footer-sidebar2" class="col-md-4">
						<?php
						if(is_active_sidebar('footer-sidebar-2')){
						dynamic_sidebar('footer-sidebar-2');
						}
						?>
					</div>
					<div id="footer-sidebar3" class="col-md-4">
						<?php
						if(is_active_sidebar('footer-sidebar-3')){
						dynamic_sidebar('footer-sidebar-3');
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- close .container -->
</footer><!-- close #colophon -->

<?php wp_footer(); ?>

</body>
</html>