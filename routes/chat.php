<?php


if (!isset($_SESSION['account'])) {
    header("Location: /login");
}



require_once "templates/header.php";
?>

<div id="createAccount">
	<h2>Chat</h2>

	<div id="chat"></div>
	<form id="messageForm">
		<input type="hidden" name="channel" value="chat">
		<input type="text" name="message" id="message">
		<button type="button" id="post">Post</button>
	</form>


</div>

<script type="text/javascript">


jQuery(document).ready(function () { 
	var chatArea = jQuery("#chat");
	var message = jQuery("#message");
	var messageForm = jQuery("#messageForm");


	function updateChat(data) {
		$.each(data, function (index, message) {
			chatArea.append(formatMessage(message));	
		});
		chatArea.scrollTop(chatArea.prop("scrollHeight"));

	}



	(function poll() {
		var chatArea = jQuery("#chat");
		jQuery.ajax({
			url: "/poll",
			data: messageForm.serialize(),
			type: "POST",
			dataType: "json",
			success: updateChat,
			complete: function () {setTimeout(poll, 1000)},
			timeout: 100000
		});

	})();

	function post() {
		jQuery.ajax({
			url: "/post",
			data: messageForm.serialize(),
			type: "POST",
			dataType: "json",
			success: function (data, textStatus, jqXHR) {
				message.val("");
				updateChat(data);
				
			}
		});
	}

	jQuery("#post").click(post);
	messageForm.submit(function(event) { 
		event.preventDefault();
		post();
	});

})

function formatMessage(message) {

	return "<div>" + message.name + ": " + message.message + "</div>";
}

</script>

<?php
require_once "templates/footer.php";
