<div class="block elevation-10 padding">
<h1 class="Bebas sz3">The Inner Circle</h1>
<h2 class="Bebas sz1">The UnStoppable You - In Network Marketing</h2>
<?php foreach($users as $u) { ?>
<div class="row">
	<div class="col-10"><input type="checkbox" name="email[]" value="<?=$u['Email']?>" /></div>
	<div class="col-30"><?=$u['Email']?></div>
	<div class="col-30"><?=$u['Mobile']?></div>
	<div class="col-30"><?=$u['Name']?></div>
</div>
<?php } ?>
Message
	<div class="text-editor text-add-outline text-editor-init text-editor-resizable" data-placeholder="Enter text..." data-buttons='[["bold", "italic", "underline", "strikeThrough"], ["h1","h2","h3"], ["alignLeft","alignRight","alignCenter","alignJustify"], ["subscript", "superscript"], ["indent", "outdent"], ["orderedList", "unorderedList"]]'>
							<div class="text-editor-content" contenteditable></div>
	</div>
	<a href="">Send Email
	
</div>