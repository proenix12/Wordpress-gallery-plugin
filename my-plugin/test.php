<div class="wrap">
		<h1>GDPR field balloons</h1>
		<div id="welcome-panel" class="welcome-panel">
				
				<div class="welcome-panel-column">
						<h3><span class="dashicons dashicons-editor-help" aria-hidden="true"></span> Before you cry over spilt mail…</h3>
						<p>Contact Form 7 doesn’t store submitted messages anywhere. Therefore, you may lose important messages forever if your mail server has issues or you make a mistake in mail configuration.</p>
						<p>Install a message storage plugin before this happens to you. <a href="https://contactform7.com/save-submitted-messages-with-flamingo/">Flamingo</a> saves all messages through contact forms into the database. Flamingo is a free WordPress plugin created by the same author as Contact Form 7.</p>
				</div>
				<div class="welcome-panel-column">
						<h3><span class="dashicons dashicons-editor-help" aria-hidden="true"></span> Before you cry over spilt mail…</h3>
						<p>Contact Form 7 doesn’t store submitted messages anywhere. Therefore, you may lose important messages forever if your mail server has issues or you make a mistake in mail configuration.</p>
						<p>Install a message storage plugin before this happens to you. <a href="https://contactform7.com/save-submitted-messages-with-flamingo/">Flamingo</a> saves all messages through contact forms into the database. Flamingo is a free WordPress plugin created by the same author as Contact Form 7.</p>
				</div>
		</div>
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
				<?php settings_fields('gdpr_field_settings'); ?>
				<?php do_settings_sections('gdpr-fields-settings'); ?>
				<?php do_settings_sections('gdpr-policy-section'); ?>
				<?php submit_button(); ?>
		</form>
</div>