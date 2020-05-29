<?php 
setlocale(LC_MONETARY, 'hi_IN');
?>
<?php 
$thismonth = date('Y-m',time());
if($selfline['YYYYMM'][$months][$thismonth]['TGBV']===0){
	$thismonth = date('Y-m',strtotime("-1 month", strtotime(date("F") . "1")));
	$months = (int)$months - 1;
}
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Number');
        data.addColumn('string', 'Name');
        data.addColumn('string', 'ToolTip');
	data.addRows([
<?php 
$i = 1; $j = 0;
$k = count($networks);
foreach($networks as $n) {
$who = split("-",$n['Name']);
//<?=($k-$i+1)*100; // . to be included in f:

?>
		[{v:'<?=$n['MCA']?>', f:'<b style="color:red"><a href="#" class="popup-open" data-popup=".popup-add" onclick="referName(\'<?=$n['_id']?>\',\'<?=$who[0];?>\')"><?=$who[0];?></b>- <?=$who[1];?></a> (<?=$n["Month"];?>)'}, '<?=$n['Refer']?>',''],
<?php
$i++;
} ?>
     ]);   
	// For each orgchart box, provide the name, manager, and tooltip to show.
	/*
	data.addRows([
			[{v:'Mike', f:'Mike<div style="color:red; font-style:italic">President</div>'},
				'', 'The President'],
			[{v:'Jim', f:'Jim<div style="color:red; font-style:italic">Vice President</div>'},
				'Mike', 'VP'],
			['Alice', 'Mike', ''],
			['Bob', 'Jim', 'Bob Sponge'],
			['Carol', 'Bob', '']
	]);
	*/
        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        chart.draw(data, {allowHtml:true});
      }
   </script>
		<a class="popup-open" href="#" data-popup=".popup-about"><i class="icon f7-icons">plus</i></a>

  <div id="chart_div" style="font-size:12px"></div>
		<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<div class="popup popup-add">
    <div class="block">
      <p>Add <a class="link popup-close right" href="#"><i class="icon f7-icons color-red">xmark</i></a></p>
      <!-- Close Popup -->
						<div class="list no-hairlines-md">
						<ul>
							<li class="item-content item-input">
										<div class="item-inner">
											<div class="item-input-wrap">
													<input type="text" placeholder="Name " name="userName" id="userName">
													<span class="input-clear-button"></span>
											</div>
									</div>
							</li>
							<li> Select Month:
							<select id="monthJoinRefer" name="monthJoinRefer">
							<?php for($i = 0; $i<=12;$i++){?>
								<option value="<?=$i?>"><?=$i?></option>
							<?php } ?>
							</select>
							</li>
							<li class="item-content item-input">
										<div class="item-inner">
											<div class="item-input-wrap">
													<input type="hidden" placeholder="Refer " name="ReferName" id="ReferName">
													<span class="input-clear-button"></span>
											</div>
									</div>
							</li>
				</ul>
					<a href="#" class="link external button button-round button-outline" onclick="return AddUserUnder();">Add</a>
						</div>
</div>		
<div class="popup popup-about">
    <div class="block">
      <p>Add <a class="link popup-close right" href="#"><i class="icon f7-icons color-red">xmark</i></a></p>
      <!-- Close Popup -->
						<div class="list no-hairlines-md">
  <ul>
    <li class="item-content item-input">
       <div class="item-inner">
        <div class="item-input-wrap">
          <input type="text" placeholder="Name " name="userName" id="userName">
          <span class="input-clear-button"></span>
        </div>
      </div>
    </li>
				<li> Select Upline:
				<select id="referName" name="referName">
				<?php foreach($networks as $n){?>
					<option value="<?=$n['_id']?>"><?=$n['Name']?></option>
				<?php } ?>
				</select>
				</li>
				<li> Select Month:
				<select id="monthJoin" name="monthJoin">
				<?php for($i = 0; $i<=12;$i++){?>
					<option value="<?=$i?>"><?=$i?></option>
				<?php } ?>
				</select>
				</li>
 </ul>
	<a href="#" class="link external button button-round button-outline" onclick="return AddUser();">Add</a>
	</div>
    </div>
  </div>
		<p>&nbsp;</p>
		<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>