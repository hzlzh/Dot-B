				
				<form id="searchform" method="get" action="http://zlz.im/search/">
					<input type="text" value="<?php _e('type, hit enter', 'dot-b'); ?>" onfocus="if (this.value == '<?php _e('type, hit enter', 'dot-b'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('type, hit enter', 'dot-b'); ?>' ;}" size="35" maxlength="50" name="q" id="s" x-webkit-speech />
					<input type="submit" id="searchsubmit" value="<?php _e('SEARCH','dot-b'); ?>" />
				</form>