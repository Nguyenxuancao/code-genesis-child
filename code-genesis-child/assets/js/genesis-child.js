/*!
 * Theia Sticky Sidebar
 */
jQuery(document).ready(function() {
	jQuery('.content, .sidebar').theiaStickySidebar({
	  // Settings
	  additionalMarginTop: 30
	});
});
jQuery(function($){
jQuery('.button').click(function() {
jQuery('.popup-').css('display', 'block');
});
jQuery('.close').click(function() {
jQuery('.popup-').css('display', 'none');
});});
