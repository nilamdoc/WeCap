<div class="text-align-center">
	<form method="post" enctype="multipart/form-data" action="/y/uploadvideo">
					<?php echo (!empty($errorMsg))?'<p class="err-msg">'.$errorMsg.'</p>':''; ?>
					<label for="title" class="list">Title:</label>
					<input type="text" name="title" class="list" value="" />
					<label for="description">Description:</label>
					<textarea name="description" cols="20" rows="2" ></textarea>
					<label for="tags">Tags:</label>
					<input type="text" name="tags" value="" />
					
					<label for="tags">Privacy:</label>
					<select name="privacy">
									<option value="public">Public</option>
									<option value="private">Private</option>
									<option value="unlisted" selected>Unlisted</option>
					</select>
					<label for="file">Choose Video File:</label> <input type="file" name="file" >
					<input name="videoSubmit" type="submit" value="Upload">
	</form>
</div>