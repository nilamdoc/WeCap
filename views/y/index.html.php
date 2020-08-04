<?php
// Destroy previous session data
if(session_id() != '') session_destroy();

// Get file upload status
if(isset($_GET['err'])){
    if($_GET['err'] == 'bf'){
        $errorMsg = 'Please select a video file to upload.';
    }elseif($_GET['err'] == 'ue'){
        $errorMsg = 'Sorry, there was an error on uploading your file.';
    }elseif($_GET['err'] == 'fe'){
        $errorMsg = 'Sorry, only MP4, AVI, MPEG, MPG, MOV and WMV files are allowed.';
    }else{
        $errorMsg = 'Some problems occurred, please try again.';
    }
}
?>
<div class="text-align-center">
<h3>Upload a new video File</h3>
<form method="post" enctype="multipart/form-data" action="/y/upload">
    <?php echo (!empty($errorMsg))?'<p class="err-msg text-color-red">'.$errorMsg.'</p>':''; ?>
				
				<div class="list inline-labels no-hairlines-md">
					<ul>
						<li class="item-content item-input">
      <div class="item-inner">
        <div class="item-title item-label">Title</div>
        <div class="item-input-wrap">
          <input type="text" name="title" placeholder="Video Title">
          <span class="input-clear-button"></span>
        </div>
      </div>
						</li>
						<li class="item-content item-input">
      <div class="item-inner">
        <div class="item-title item-label">Description</div>
        <div class="item-input-wrap">
          <textarea name="description" placeholder="Description" class="resizeable	"></textarea>
        </div>
      </div>
						</li>
						<li class="item-content item-input">
      <div class="item-inner">
        <div class="item-title item-label">Tags</div>
        <div class="item-input-wrap">
          <input type="text" name="tags" placeholder="tags, video, motivation">
          <span class="input-clear-button"></span>
        </div>
      </div>
						</li>
						<li class="item-content item-input">
      <div class="item-inner">
        <div class="item-title item-label">Privacy</div>
        <div class="item-input-wrap input-dropdown-wrap">
          <select name="privacy">
											<option value="public">Public</option>
											<option value="private">Private</option>
											<option value="unlisted" selected>Unlisted</option>
										</select>
        </div>
      </div>
    </li>
						<li class="item-content item-input">
      <div class="item-inner">
        <div class="item-title item-label">Choose Video File:</div>
        <div class="item-input-wrap">
										<input type="file" name="file" >
          <span class="input-clear-button"></span>
        </div>
      </div>
						</li>
					</ul>	
					<input name="videoSubmit" type="submit" value="Upload" class="button button-round button-fill">
				</div>
				
    
    
</form>
</div>