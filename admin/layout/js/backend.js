/** @format */

$(function () {
	'use strict';
	
	$('.toggle-info').click(function(){
		$(this)
			.toggleClass('selected')
			.parent()
			.next('.panel-body')
			.fadeToggle(100);
		if($(this).hasClass('selected')){
			$(this).html('<i class="fa fa-minus fa-lg"></i>');
		}else{
			$(this).html('<i class="fa fa-plus fa-lg"></i>');
		}
	
	})
	
	// Trigger The selectBoxIt
	$("select").selectBoxIt({
		autoWidth: false,
		theme: "jqueryui",
		// theme: "bootstrap"
	});
	
	
	// hide placeholder on form focus
	$('[placeholder]').focus(function () {
			$(this).attr('data-text', $(this).attr('placeholder'));
			$(this).attr('placeholder', '');
		})
		.blur(function () {
		$(this).attr('placeholder',$(this).attr('data-text'));
		
		});
		// Add Astreisk on Required Fields
	$('input').each(function ()
	{
		if ($(this).attr("required") === "required")
		{
			$(this).after('<span class="asterisk">*</span>');
		}
	});
		//convert Password field to text field on HOVER
var passField=$('.password')		
	$('.show-pass').hover(function (){
		passField.attr('type', 'text');
	},function (){passField.attr('type', 'password');
	});
//Delete confirm		

$('.confirm').click(function(){
	return confirm('Are you sure you want to delete??');
})
		
		
// Category View Option
$('.cat h3').click(function ()
	{
	$(this).next('.full-view').fadeToggle(200);
	});
		
	$('.options span').click(function () {
		$(this).addClass('active').siblings().removeClass('active');
	
		if ($(this).data('view') == 'full') {
	
			$('.cat .full-view').fadeIn(200);
		
		} else {
	
			$('.cat .full-view').fadeOut(200);
	
		}
	});
		
	$('.show-hidden-li').hover(function () {
		$(this).find('.show-hidden').fadeIn(400);

	}, function () {
		$(this).find('.show-hidden').fadeOut(400);
	})		
		
		
		
});

