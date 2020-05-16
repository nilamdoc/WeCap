
<textarea id="message" name="message" style="border:1px solid gray;width:90vw"></textarea>

<a href="#" class="button-round button button-outline" onclick="SendSMS();" >Send SMS</a>
<?php
//print_r($names);
$i = 1; foreach ($names as $n){?>
<input type="checkbox" name="mobile[]" value="<?=$n['mobile']?>#<?=$n['name']?>"> <?=$n['mobile']?> - <?=$n['name']?><br>
<?php	$i++; } ?>


