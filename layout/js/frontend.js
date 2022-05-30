/** @format */

$(function () {
	"use strict";
	//Switch between Login and Signup Forms
	$(".login-page h1 span").click(function () {
		$(this).addClass("active").siblings().removeClass("active");
		$(".login-page form").hide();
		$("." + $(this).data("class")).fadeIn(100);
	});

	// Trigger TagIt
	// $(document).ready(function () {
	// $("#myTags").tagit();
	// });

	// Trigger The selectBoxIt
	$("select").selectBoxIt({
		autoWidth: false,
		theme: "jqueryui",
		// theme: "bootstrap"
	});

	// hide placeholder on form focus
	$("[placeholder]")
		.focus(function () {
			$(this).attr("data-text", $(this).attr("placeholder"));
			$(this).attr("placeholder", "");
		})
		.blur(function () {
			$(this).attr("placeholder", $(this).attr("data-text"));
		});

	// Add Astreisk on Required Fields
	$("input").each(function () {
		if ($(this).attr("required") === "required") {
			$(this).after('<span class="asterisk">*</span>');
		}
	});
	//convert Password field to text field on HOVER

	//Delete confirm
	$(".confirm").click(function () {
		return confirm("Are you sure you want to delete??");
	});

	$(".live").keyup(function () {
		if ($(this).data("class") == ".live-price") {
			$($(this).data("class")).text($(this).val() + " SR");
		} else {
			$($(this).data("class")).text($(this).val());
		}
	});

	// $('.live').keyup(function () {
	// 	$('.live-preview .caption p').text($(this).val());
	// })
	// $(".live-price").keyup(function () {
	// 	$(".live-preview .price-tag").text($(this).val()+" SR");
	// });
});
