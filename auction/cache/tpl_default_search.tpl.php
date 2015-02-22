<div class="tableContent2">
	<div class="titTable2">
		<?php echo ((isset($this->_rootref['L_199'])) ? $this->_rootref['L_199'] : ((isset($MSG['199'])) ? $MSG['199'] : '{ L_199 }')); ?>
	</div>
	<div class="table2">
<?php if ($this->_rootref['ERROR'] != ('')) {  ?>
		<div class="error-box">
			<?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?>
		</div>
<?php } else { if ($this->_rootref['NUM_AUCTIONS'] > 0) {  $this->_tpl_include('browse.tpl'); } else { ?>
		<div class="padding" align="center">
			<?php echo ((isset($this->_rootref['L_198'])) ? $this->_rootref['L_198'] : ((isset($MSG['198'])) ? $MSG['198'] : '{ L_198 }')); ?>
		</div>
	<?php } } ?>
	</div>
</div>