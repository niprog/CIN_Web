<?php $this->_tpl_include('user_menu_header.tpl'); ?>

<table width="100%" border="0" cellspacing="1" cellpadding="4">
<?php $_items_count = (isset($this->_tpldata['items'])) ? sizeof($this->_tpldata['items']) : 0;if ($_items_count) {for ($_items_i = 0; $_items_i < $_items_count; ++$_items_i){$_items_val = &$this->_tpldata['items'][$_items_i]; ?>
	<tr valign="top">
		<td colspan="4">
			<?php echo ((isset($this->_rootref['L_458'])) ? $this->_rootref['L_458'] : ((isset($MSG['458'])) ? $MSG['458'] : '{ L_458 }')); ?>
			<b><a href="item.php?id=<?php echo $_items_val['AUC_ID']; ?>" target="_blank"><?php echo $_items_val['TITLE']; ?></a></b>
			(ID: <a href="item.php?id=<?php echo $_items_val['AUC_ID']; ?>" target="_blank"><?php echo $_items_val['AUC_ID']; ?></a> - <?php echo ((isset($this->_rootref['L_25_0121'])) ? $this->_rootref['L_25_0121'] : ((isset($MSG['25_0121'])) ? $MSG['25_0121'] : '{ L_25_0121 }')); ?> <?php echo $_items_val['ENDS']; ?>)
		</td>
	</tr>
	<tr>
		<th width="30%">
			<?php echo ((isset($this->_rootref['L_125'])) ? $this->_rootref['L_125'] : ((isset($MSG['125'])) ? $MSG['125'] : '{ L_125 }')); ?>
		</th>
		<th width="20%">
			<?php echo ((isset($this->_rootref['L_460'])) ? $this->_rootref['L_460'] : ((isset($MSG['460'])) ? $MSG['460'] : '{ L_460 }')); ?>
		</th>
		<th width="15%">
			<?php echo ((isset($this->_rootref['L_461'])) ? $this->_rootref['L_461'] : ((isset($MSG['461'])) ? $MSG['461'] : '{ L_461 }')); ?>
		</th>
		<th width="10%">
			<?php echo ((isset($this->_rootref['L_284'])) ? $this->_rootref['L_284'] : ((isset($MSG['284'])) ? $MSG['284'] : '{ L_284 }')); ?>
		</th>
		<th width="15%">
			<?php echo ((isset($this->_rootref['L_189'])) ? $this->_rootref['L_189'] : ((isset($MSG['189'])) ? $MSG['189'] : '{ L_189 }')); ?>
		</th>
		<th width="10%">
			<?php echo ((isset($this->_rootref['L_755'])) ? $this->_rootref['L_755'] : ((isset($MSG['755'])) ? $MSG['755'] : '{ L_755 }')); ?>
		</th>
	</tr>
	<tr valign="top">
		<td>
			<?php echo $_items_val['SELLNICK']; ?>&nbsp;&nbsp;<?php echo $_items_val['FB_LINK']; ?>
		</td>
		<td>
			<a href="mailto:<?php echo $_items_val['SELLEMAIL']; ?>"><?php echo $_items_val['SELLEMAIL']; ?></a>
		</td>
		<td align="right">
			<?php echo $_items_val['FBID']; ?>
		</td>
		<td align="center">
			<?php echo $_items_val['QTY']; ?>
		</td>
		<td align="right">
			<?php echo $_items_val['TOTAL']; ?>
		</td>
		<td>
	<?php if ($_items_val['B_PAID']) {  ?>
    		<?php echo ((isset($this->_rootref['L_755'])) ? $this->_rootref['L_755'] : ((isset($MSG['755'])) ? $MSG['755'] : '{ L_755 }')); ?>
    <?php } else { ?>
    		<form name="" method="post" action="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>pay.php?a=2" id="fees">
            <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
            <input type="hidden" name="pfval" value="<?php echo $_items_val['AUC_ID']; ?>">
            <input type="submit" name="Pay" value="<?php echo ((isset($this->_rootref['L_756'])) ? $this->_rootref['L_756'] : ((isset($MSG['756'])) ? $MSG['756'] : '{ L_756 }')); ?>" class="pay">
            </form>
    <?php } ?>
		</td>
	</tr>
<?php }} ?>
</table>

<?php $this->_tpl_include('user_menu_footer.tpl'); ?>