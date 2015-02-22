<html>
<head>
<title><?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="themes/<?php echo (isset($this->_rootref['THEME'])) ? $this->_rootref['THEME'] : ''; ?>/style.css">
<script type="text/javascript" src="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>js/google_converter.js"></script>
</head>
<body>
<div id="content">
	<div class="container">
		<div class="titTable2 rounded-top rounded-bottom">
			<?php echo ((isset($this->_rootref['L_085'])) ? $this->_rootref['L_085'] : ((isset($MSG['085'])) ? $MSG['085'] : '{ L_085 }')); ?>
		</div>
		<div class="table3">
			<form name="form1" method="post" action="">
            	<input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
				<table width="90%" border="0" cellspacing="0" cellpadding="5">
                    <tr class="row">
                        <td class="success-box" id="results" colspan="3" align="center"><?php echo (isset($this->_rootref['CONVERSION'])) ? $this->_rootref['CONVERSION'] : ''; ?></td>
                    </tr>
                    <tr>
                    	<td align="center"><?php echo ((isset($this->_rootref['L_082'])) ? $this->_rootref['L_082'] : ((isset($MSG['082'])) ? $MSG['082'] : '{ L_082 }')); ?></td>
                        <td width="39%"><?php echo ((isset($this->_rootref['L_083'])) ? $this->_rootref['L_083'] : ((isset($MSG['083'])) ? $MSG['083'] : '{ L_083 }')); ?></td>
                        <td width="39%"><?php echo ((isset($this->_rootref['L_088'])) ? $this->_rootref['L_088'] : ((isset($MSG['088'])) ? $MSG['088'] : '{ L_088 }')); ?></td>
                    </tr>
					<tr valign="top">
						<td align="center">
							<input type="text" name="amount" id="amount" size="5" value="<?php echo (isset($this->_rootref['AMOUNT'])) ? $this->_rootref['AMOUNT'] : ''; ?>">
						</td>
						<td>
							<select name="fromCurrency" id="fromCurrency">
<?php $_from_count = (isset($this->_tpldata['from'])) ? sizeof($this->_tpldata['from']) : 0;if ($_from_count) {for ($_from_i = 0; $_from_i < $_from_count; ++$_from_i){$_from_val = &$this->_tpldata['from'][$_from_i]; ?>
								<option value="<?php echo $_from_val['VALUE']; ?>"<?php if ($_from_val['B_SELECTED']) {  ?> selected="true"<?php } ?>><?php echo $_from_val['VALUE']; ?> <?php echo $_from_val['NAME']; ?></option>
<?php }} ?>
							</select>
						</td>
						<td>
							<select name="toCurrency" id="toCurrency">
<?php $_to_count = (isset($this->_tpldata['to'])) ? sizeof($this->_tpldata['to']) : 0;if ($_to_count) {for ($_to_i = 0; $_to_i < $_to_count; ++$_to_i){$_to_val = &$this->_tpldata['to'][$_to_i]; ?>
								<option value="<?php echo $_to_val['VALUE']; ?>"<?php if ($_to_val['B_SELECTED']) {  ?> selected="true"<?php } ?>><?php echo $_to_val['VALUE']; ?> <?php echo $_to_val['NAME']; ?></option>
<?php }} ?>
							</select>
						</td>
					</tr>
				</table>
				<div style="text-align:center">
                	<input type="button" name="convert" id="convert" value="<?php echo ((isset($this->_rootref['L_25_0176'])) ? $this->_rootref['L_25_0176'] : ((isset($MSG['25_0176'])) ? $MSG['25_0176'] : '{ L_25_0176 }')); ?>">
				</div>
			</form>
		</div>
		<div style="text-align:center">
			<input type="button" value="Close" onClick="javascript:window.close()">
		</div>
		<br>
	</div>
</div>
</body>
</html>