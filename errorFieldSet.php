<?php
	echo
		'<div class="middleParts">
			<div class="middlePart">
				<fieldset class="middleErrorMessage">
					<legend>ERROR!</legend>
					'.((isset ($txtError))?$txtError:'Undefined ERROR').'
				</fieldset>
			</div>
		</div>'
	;
?>
