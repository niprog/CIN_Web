<?php $this->_tpl_include('user_menu_header.tpl'); ?>

<script type="text/javascript">
$(document).ready(function() {
	var relist_fee = <?php echo (isset($this->_rootref['RELIST_FEE_NO'])) ? $this->_rootref['RELIST_FEE_NO'] : ''; ?>;
	$("#sellall").click(function() {
		var checked_status = this.checked;
		$("input[name='sell[]']").each(function() {
			this.checked = checked_status;
		});
	});
	$("#deleteall").click(function() {
		var checked_status = this.checked;
		$("input[name='delete[]']").each(function() {
			this.checked = checked_status;
		});
	});
	$("#processdel").submit(function() {
		if (confirm('<?php echo ((isset($this->_rootref['L_30_0087'])) ? $this->_rootref['L_30_0087'] : ((isset($MSG['30_0087'])) ? $MSG['30_0087'] : '{ L_30_0087 }')); ?>')){
			return true;
		} else {
			return false;
		}
	});
	$(".relistid").click(function(){
		var n = $(".relistid:checked").length;
		$("#to_pay").text(parseFloat(n * relist_fee));
	});
});
</script>
<form name="closed" method="post" action="" id="processdel">
<input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td align="right">
			<dl class="tabs">
				<dd><a href="yourauctions_p.php"><?php echo ((isset($this->_rootref['L_25_0115'])) ? $this->_rootref['L_25_0115'] : ((isset($MSG['25_0115'])) ? $MSG['25_0115'] : '{ L_25_0115 }')); ?></a></dd>
				<dd><a href="yourauctions.php"><?php echo ((isset($this->_rootref['L_619'])) ? $this->_rootref['L_619'] : ((isset($MSG['619'])) ? $MSG['619'] : '{ L_619 }')); ?></a></dd>
				<dd><a href="yourauctions_s.php"><?php echo ((isset($this->_rootref['L_2__0056'])) ? $this->_rootref['L_2__0056'] : ((isset($MSG['2__0056'])) ? $MSG['2__0056'] : '{ L_2__0056 }')); ?></a></dd>
				<dd><a href="yourauctions_sold.php"><?php echo ((isset($this->_rootref['L_25_0119'])) ? $this->_rootref['L_25_0119'] : ((isset($MSG['25_0119'])) ? $MSG['25_0119'] : '{ L_25_0119 }')); ?></a></dd>
			</dl>
		</td>
        <td>
<?php if ($this->_rootref['B_RELIST_FEE']) {  ?>
            <?php echo ((isset($this->_rootref['L_437'])) ? $this->_rootref['L_437'] : ((isset($MSG['437'])) ? $MSG['437'] : '{ L_437 }')); ?>: <?php echo (isset($this->_rootref['RELIST_FEE'])) ? $this->_rootref['RELIST_FEE'] : ''; ?> - <?php echo ((isset($this->_rootref['L_189'])) ? $this->_rootref['L_189'] : ((isset($MSG['189'])) ? $MSG['189'] : '{ L_189 }')); ?>: <span id="to_pay">0.00</span>
<?php } ?>
        </td>
	</tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="4" align="center">
	<tr>
		<td class="titTable1" width="40%">
			<a href="yourauctions_c.php?ca_ord=title&ca_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo ((isset($this->_rootref['L_624'])) ? $this->_rootref['L_624'] : ((isset($MSG['624'])) ? $MSG['624'] : '{ L_624 }')); ?></a>
<?php if ($this->_rootref['ORDERCOL'] == ('title')) {  ?>
			<a href="yourauctions_c.php?ca_ord=title&ca_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo (isset($this->_rootref['ORDERTYPEIMG'])) ? $this->_rootref['ORDERTYPEIMG'] : ''; ?></a>
<?php } ?>
		</td>
		<td class="titTable1" width="10%">
			<a href="yourauctions_c.php?ca_ord=starts&ca_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo ((isset($this->_rootref['L_625'])) ? $this->_rootref['L_625'] : ((isset($MSG['625'])) ? $MSG['625'] : '{ L_625 }')); ?></a>
<?php if ($this->_rootref['ORDERCOL'] == ('starts')) {  ?>
			<a href="yourauctions_c.php?ca_ord=starts&ca_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo (isset($this->_rootref['ORDERTYPEIMG'])) ? $this->_rootref['ORDERTYPEIMG'] : ''; ?></a>
<?php } ?>
		</td>
		<td class="titTable1" width="10%">
			<a href="yourauctions_c.php?ca_ord=ends&ca_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo ((isset($this->_rootref['L_626'])) ? $this->_rootref['L_626'] : ((isset($MSG['626'])) ? $MSG['626'] : '{ L_626 }')); ?></a>
<?php if ($this->_rootref['ORDERCOL'] == ('ends')) {  ?>
			<a href="yourauctions_c.php?ca_ord=ends&ca_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo (isset($this->_rootref['ORDERTYPEIMG'])) ? $this->_rootref['ORDERTYPEIMG'] : ''; ?></a>
<?php } ?>
		</td>
		<td class="titTable1" width="10%" align="center">
			<a href="yourauctions_c.php?ca_ord=num_bids&ca_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo ((isset($this->_rootref['L_627'])) ? $this->_rootref['L_627'] : ((isset($MSG['627'])) ? $MSG['627'] : '{ L_627 }')); ?></a>
<?php if ($this->_rootref['ORDERCOL'] == ('num_bids')) {  ?>
			<a href="yourauctions_c.php?ca_ord=num_bids&ca_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo (isset($this->_rootref['ORDERTYPEIMG'])) ? $this->_rootref['ORDERTYPEIMG'] : ''; ?></a>
<?php } ?>
		</td>
		<td class="titTable1" width="11%" align="center">
			<a href="yourauctions_c.php?ca_ord=current_bid&ca_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo ((isset($this->_rootref['L_628'])) ? $this->_rootref['L_628'] : ((isset($MSG['628'])) ? $MSG['628'] : '{ L_628 }')); ?></a>
<?php if ($this->_rootref['ORDERCOL'] == ('current_bid')) {  ?>
			<a href="yourauctions_c.php?ca_ord=current_bid&ca_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo (isset($this->_rootref['ORDERTYPEIMG'])) ? $this->_rootref['ORDERTYPEIMG'] : ''; ?></a>
<?php } ?>
		</td>
		<td class="titTable1" width="10%" align="center">
			<?php echo ((isset($this->_rootref['L_630'])) ? $this->_rootref['L_630'] : ((isset($MSG['630'])) ? $MSG['630'] : '{ L_630 }')); ?>
		</td>
		<td class="titTable1" width="10%" align="center">
			<?php echo ((isset($this->_rootref['L_25_0209'])) ? $this->_rootref['L_25_0209'] : ((isset($MSG['25_0209'])) ? $MSG['25_0209'] : '{ L_25_0209 }')); ?>
		</td>
		<td class="titTable1" width="9%" align="center" bgcolor=>
			<?php echo ((isset($this->_rootref['L_008'])) ? $this->_rootref['L_008'] : ((isset($MSG['008'])) ? $MSG['008'] : '{ L_008 }')); ?>
		</td>
	</tr>
<?php if ($this->_rootref['B_AREITEMS']) {  $_items_count = (isset($this->_tpldata['items'])) ? sizeof($this->_tpldata['items']) : 0;if ($_items_count) {for ($_items_i = 0; $_items_i < $_items_count; ++$_items_i){$_items_val = &$this->_tpldata['items'][$_items_i]; ?>
	<tr <?php echo $_items_val['BGCOLOUR']; ?>>
		<td width="40%">
			<a href="item.php?id=<?php echo $_items_val['ID']; ?>"><?php echo $_items_val['TITLE']; ?></a>
		</td>
		<td width="10%">
			<?php echo $_items_val['STARTS']; ?>
		</td>
		<td width="10%">
			<?php echo $_items_val['ENDS']; ?>
		</td>
		<td width="10%"  align="center">
			<?php echo $_items_val['BIDS']; ?>
		</td>
		<td width="11%"  align="center">
			<?php echo $_items_val['BID']; ?>
		</td>
		<td width="10%"  align="center">
		<?php if ($_items_val['B_CANRELIST'] && $this->_rootref['B_AUTORELIST']) {  ?>
			<input type="checkbox" name="relist[]" value="<?php echo $_items_val['ID']; ?>" class="relistid">
		<?php } else { if ($_items_val['B_CANRELIST']) {  ?>
            <a href="sellsimilar.php?id=<?php echo $_items_val['ID']; ?>&relist=1"><?php echo ((isset($this->_rootref['L_2__0051'])) ? $this->_rootref['L_2__0051'] : ((isset($MSG['2__0051'])) ? $MSG['2__0051'] : '{ L_2__0051 }')); ?></a>
            <?php } else { ?>
            <a href="sellsimilar.php?id=<?php echo $_items_val['ID']; ?>"><?php echo ((isset($this->_rootref['L_2__0050'])) ? $this->_rootref['L_2__0050'] : ((isset($MSG['2__0050'])) ? $MSG['2__0050'] : '{ L_2__0050 }')); ?></a>
            <?php } } ?>
		</td>
		<td width="10%"  align="center">
		<?php if ($_items_val['B_CANSSELL']) {  ?>
			<input type="checkbox" name="sell[]" value="<?php echo $_items_val['ID']; ?>">
		<?php } ?>
		</td>
		<td width="9%"  align="center">
		<?php if ($_items_val['B_HASNOBIDS']) {  ?>
			<input type="checkbox" name="delete[]" value="<?php echo $_items_val['ID']; ?>">
		<?php } ?>
		</td>
	</tr>
	<?php }} } ?>
	<tr <?php echo (isset($this->_rootref['BGCOLOUR'])) ? $this->_rootref['BGCOLOUR'] : ''; ?>>
	  <td colspan="6" align="right"><?php echo ((isset($this->_rootref['L_30_0102'])) ? $this->_rootref['L_30_0102'] : ((isset($MSG['30_0102'])) ? $MSG['30_0102'] : '{ L_30_0102 }')); ?></td>
	  <td align="center"><input type="checkbox" id="sellall"></td>
	  <td align="center"><input type="checkbox" id="deleteall"></td>
	</tr>
		<tr>
			<td colspan="10" align="center">
				<input type="hidden" name="action" value="update">
				<input type="submit" name="Submit" value="<?php echo ((isset($this->_rootref['L_631'])) ? $this->_rootref['L_631'] : ((isset($MSG['631'])) ? $MSG['631'] : '{ L_631 }')); ?>" class="button">
			</td>
		</tr>
	</table>
</form>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="center">
			<?php echo ((isset($this->_rootref['L_5117'])) ? $this->_rootref['L_5117'] : ((isset($MSG['5117'])) ? $MSG['5117'] : '{ L_5117 }')); ?>&nbsp;<?php echo (isset($this->_rootref['PAGE'])) ? $this->_rootref['PAGE'] : ''; ?>&nbsp;<?php echo ((isset($this->_rootref['L_5118'])) ? $this->_rootref['L_5118'] : ((isset($MSG['5118'])) ? $MSG['5118'] : '{ L_5118 }')); ?>&nbsp;<?php echo (isset($this->_rootref['PAGES'])) ? $this->_rootref['PAGES'] : ''; ?>
			<br>
			<?php echo (isset($this->_rootref['PREV'])) ? $this->_rootref['PREV'] : ''; ?>
<?php $_pages_count = (isset($this->_tpldata['pages'])) ? sizeof($this->_tpldata['pages']) : 0;if ($_pages_count) {for ($_pages_i = 0; $_pages_i < $_pages_count; ++$_pages_i){$_pages_val = &$this->_tpldata['pages'][$_pages_i]; ?>
			<?php echo $_pages_val['PAGE']; ?>&nbsp;&nbsp;
<?php }} ?>
			<?php echo (isset($this->_rootref['NEXT'])) ? $this->_rootref['NEXT'] : ''; ?>
		</td>
	</tr>
</table>

<?php $this->_tpl_include('user_menu_footer.tpl'); ?>