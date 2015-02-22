<div class="content">
	<div class="titTable2 rounded-top rounded-bottom">
		<?php echo ((isset($this->_rootref['L_464'])) ? $this->_rootref['L_464'] : ((isset($MSG['464'])) ? $MSG['464'] : '{ L_464 }')); ?>
	</div>
<?php if ($this->_rootref['ERROR'] != ('')) {  ?>
	<div class="error-box">
		<?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?>
	</div>
<?php } ?>
	<div class="table2">
		<form name="adsearch" method="post" action="">
        	<input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
			<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
				<tr>
					<td width="45%" align="right"><?php echo ((isset($this->_rootref['L_1000'])) ? $this->_rootref['L_1000'] : ((isset($MSG['1000'])) ? $MSG['1000'] : '{ L_1000 }')); ?></td>
					<td width="55%">
						<input type="search" size="45" name="title">
					</td>
				</tr>
				<tr>
					<td align="right"><?php echo ((isset($this->_rootref['L_1001'])) ? $this->_rootref['L_1001'] : ((isset($MSG['1001'])) ? $MSG['1001'] : '{ L_1001 }')); ?></td>
					<td>
						<input name="desc" type="checkbox" value="y">
					</td>
				</tr>
				<tr>
					<td align="right"><?php echo ((isset($this->_rootref['L_25_0214'])) ? $this->_rootref['L_25_0214'] : ((isset($MSG['25_0214'])) ? $MSG['25_0214'] : '{ L_25_0214 }')); ?></td>
					<td>
						<input name="closed" type="checkbox" id="closed" value="y">
					</td>
				</tr>
				<tr>
					<td align="right"><?php echo ((isset($this->_rootref['L_1002'])) ? $this->_rootref['L_1002'] : ((isset($MSG['1002'])) ? $MSG['1002'] : '{ L_1002 }')); ?></td>
					<td><?php echo (isset($this->_rootref['CATEGORY_LIST'])) ? $this->_rootref['CATEGORY_LIST'] : ''; ?></td>
				</tr>
				<tr>
					<td align="right"><?php echo ((isset($this->_rootref['L_1003'])) ? $this->_rootref['L_1003'] : ((isset($MSG['1003'])) ? $MSG['1003'] : '{ L_1003 }')); ?></td>
					<td><?php echo ((isset($this->_rootref['L_1004'])) ? $this->_rootref['L_1004'] : ((isset($MSG['1004'])) ? $MSG['1004'] : '{ L_1004 }')); ?>
						<input maxlength="12" name="minprice" size="5"> <?php echo (isset($this->_rootref['CURRENCY'])) ? $this->_rootref['CURRENCY'] : ''; echo ((isset($this->_rootref['L_1005'])) ? $this->_rootref['L_1005'] : ((isset($MSG['1005'])) ? $MSG['1005'] : '{ L_1005 }')); ?> <input maxlength="12" name="maxprice" size="5"> <?php echo (isset($this->_rootref['CURRENCY'])) ? $this->_rootref['CURRENCY'] : ''; ?>
					</td>
				</tr>
				<tr valign=top>
					<td align="right"><?php echo ((isset($this->_rootref['L_2__0025'])) ? $this->_rootref['L_2__0025'] : ((isset($MSG['2__0025'])) ? $MSG['2__0025'] : '{ L_2__0025 }')); ?></td>
					<td>
						<INPUT TYPE="checkbox" name="buyitnow" value="y"> <?php echo ((isset($this->_rootref['L_30_0100'])) ? $this->_rootref['L_30_0100'] : ((isset($MSG['30_0100'])) ? $MSG['30_0100'] : '{ L_30_0100 }')); ?>
						<INPUT TYPE="checkbox" name="buyitnowonly" value="y"> <?php echo ((isset($this->_rootref['L_30_0101'])) ? $this->_rootref['L_30_0101'] : ((isset($MSG['30_0101'])) ? $MSG['30_0101'] : '{ L_30_0101 }')); ?>
					</td>
				</tr>
				<tr valign=top>
					<td align="right"><?php echo ((isset($this->_rootref['L_1006'])) ? $this->_rootref['L_1006'] : ((isset($MSG['1006'])) ? $MSG['1006'] : '{ L_1006 }')); ?></td>
					<td><?php echo (isset($this->_rootref['PAYMENTS_LIST'])) ? $this->_rootref['PAYMENTS_LIST'] : ''; ?></td>
				</tr>
				<tr>
					<td align="right"><?php echo ((isset($this->_rootref['L_125'])) ? $this->_rootref['L_125'] : ((isset($MSG['125'])) ? $MSG['125'] : '{ L_125 }')); ?></td>
					<td>
						<input type="text" name="seller">
					</td>
				</tr>
				<tr>
					<td align="right"><?php echo ((isset($this->_rootref['L_1008'])) ? $this->_rootref['L_1008'] : ((isset($MSG['1008'])) ? $MSG['1008'] : '{ L_1008 }')); ?></td>
					<td><?php echo (isset($this->_rootref['COUNTRY_LIST'])) ? $this->_rootref['COUNTRY_LIST'] : ''; ?></td>
				</tr>
				<tr>
					<td align="right"><?php echo ((isset($this->_rootref['L_012'])) ? $this->_rootref['L_012'] : ((isset($MSG['012'])) ? $MSG['012'] : '{ L_012 }')); ?></td>
					<td><input type="text" name="zipcode" size="12"></td>
				</tr>
				<tr>
					<td align="right"><?php echo ((isset($this->_rootref['L_1009'])) ? $this->_rootref['L_1009'] : ((isset($MSG['1009'])) ? $MSG['1009'] : '{ L_1009 }')); ?></td>
					<td>
						<select name="ending" size="1">
							<option></option>
							<option value="1"><?php echo ((isset($this->_rootref['L_1010'])) ? $this->_rootref['L_1010'] : ((isset($MSG['1010'])) ? $MSG['1010'] : '{ L_1010 }')); ?></option>
							<option value="2"><?php echo ((isset($this->_rootref['L_1011'])) ? $this->_rootref['L_1011'] : ((isset($MSG['1011'])) ? $MSG['1011'] : '{ L_1011 }')); ?></option>
							<option value="4"><?php echo ((isset($this->_rootref['L_1012'])) ? $this->_rootref['L_1012'] : ((isset($MSG['1012'])) ? $MSG['1012'] : '{ L_1012 }')); ?></option>
							<option value="6"><?php echo ((isset($this->_rootref['L_1013'])) ? $this->_rootref['L_1013'] : ((isset($MSG['1013'])) ? $MSG['1013'] : '{ L_1013 }')); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right"><?php echo ((isset($this->_rootref['L_1014'])) ? $this->_rootref['L_1014'] : ((isset($MSG['1014'])) ? $MSG['1014'] : '{ L_1014 }')); ?></td>
					<td>
						<select name="SortProperty" size="1">
							<option></option>
							<option value="ends"><?php echo ((isset($this->_rootref['L_1015'])) ? $this->_rootref['L_1015'] : ((isset($MSG['1015'])) ? $MSG['1015'] : '{ L_1015 }')); ?></option>
							<option value="starts"><?php echo ((isset($this->_rootref['L_1016'])) ? $this->_rootref['L_1016'] : ((isset($MSG['1016'])) ? $MSG['1016'] : '{ L_1016 }')); ?></option>
							<option value="min_bid"><?php echo ((isset($this->_rootref['L_1017'])) ? $this->_rootref['L_1017'] : ((isset($MSG['1017'])) ? $MSG['1017'] : '{ L_1017 }')); ?></option>
							<option value="max_bid"><?php echo ((isset($this->_rootref['L_1018'])) ? $this->_rootref['L_1018'] : ((isset($MSG['1018'])) ? $MSG['1018'] : '{ L_1018 }')); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right"><?php echo ((isset($this->_rootref['L_718'])) ? $this->_rootref['L_718'] : ((isset($MSG['718'])) ? $MSG['718'] : '{ L_718 }')); ?></td>
					<td>
						<select name="type" size="1">
							<option></option>
							<option value="2"><?php echo ((isset($this->_rootref['L_1020'])) ? $this->_rootref['L_1020'] : ((isset($MSG['1020'])) ? $MSG['1020'] : '{ L_1020 }')); ?></option>
							<option value="1"><?php echo ((isset($this->_rootref['L_1021'])) ? $this->_rootref['L_1021'] : ((isset($MSG['1021'])) ? $MSG['1021'] : '{ L_1021 }')); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="center" colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td colspan=2 align="center">
						<input name="action" type="hidden" value="search">
						<input type="submit" name="go" value="<?php echo ((isset($this->_rootref['L_5029'])) ? $this->_rootref['L_5029'] : ((isset($MSG['5029'])) ? $MSG['5029'] : '{ L_5029 }')); ?>" class="button">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>