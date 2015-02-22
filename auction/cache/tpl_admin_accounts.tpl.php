<?php $this->_tpl_include('header.tpl'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>inc/calendar.css">
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<?php $this->_tpl_include('sidebar-' . ((isset($this->_rootref['CURRENT_PAGE'])) ? $this->_rootref['CURRENT_PAGE'] : '') . '.tpl'); ?>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom"><?php echo ((isset($this->_rootref['L_854'])) ? $this->_rootref['L_854'] : ((isset($MSG['854'])) ? $MSG['854'] : '{ L_854 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_854'])) ? $this->_rootref['L_854'] : ((isset($MSG['854'])) ? $MSG['854'] : '{ L_854 }')); ?></h4>
				<div class="plain-box">
                	<form action="" method="post">
                    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
                	<table cellpadding="0" cellspacing="0" width="100%" class="blank">
                    <tr>
                    	<td><?php echo ((isset($this->_rootref['L_855'])) ? $this->_rootref['L_855'] : ((isset($MSG['855'])) ? $MSG['855'] : '{ L_855 }')); ?></td>
                    	<td>
                        	<?php echo ((isset($this->_rootref['L_5281'])) ? $this->_rootref['L_5281'] : ((isset($MSG['5281'])) ? $MSG['5281'] : '{ L_5281 }')); ?> <input type="radio" name="type" value="m"<?php if ($this->_rootref['TYPE'] == ('m')) {  ?> checked="checked"<?php } ?>>
                        	<?php echo ((isset($this->_rootref['L_827'])) ? $this->_rootref['L_827'] : ((isset($MSG['827'])) ? $MSG['827'] : '{ L_827 }')); ?> <input type="radio" name="type" value="w"<?php if ($this->_rootref['TYPE'] == ('w')) {  ?> checked="checked"<?php } ?>>
                        	<?php echo ((isset($this->_rootref['L_5285'])) ? $this->_rootref['L_5285'] : ((isset($MSG['5285'])) ? $MSG['5285'] : '{ L_5285 }')); ?> <input type="radio" name="type" value="d"<?php if ($this->_rootref['TYPE'] == ('d')) {  ?> checked="checked"<?php } ?>>
                        	<?php echo ((isset($this->_rootref['L_2__0027'])) ? $this->_rootref['L_2__0027'] : ((isset($MSG['2__0027'])) ? $MSG['2__0027'] : '{ L_2__0027 }')); ?> <input type="radio" name="type" value="a"<?php if ($this->_rootref['TYPE'] == ('a')) {  ?> checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo ((isset($this->_rootref['L_856'])) ? $this->_rootref['L_856'] : ((isset($MSG['856'])) ? $MSG['856'] : '{ L_856 }')); ?></td>
                    	<td>
                        <input type="text" name="from_date" id="from_date" value="<?php echo (isset($this->_rootref['FROM_DATE'])) ? $this->_rootref['FROM_DATE'] : ''; ?>" size="20" maxlength="19">
                        <script type="text/javascript">
							new tcal ({'id': 'from_date','controlname': 'from_date'});
						</script>
                        -
                        <input type="text" name="to_date" id="to_date" value="<?php echo (isset($this->_rootref['TO_DATE'])) ? $this->_rootref['TO_DATE'] : ''; ?>" size="20" maxlength="19">
                        <script type="text/javascript">
							new tcal ({'id': 'to_date','controlname': 'to_date'});
						</script>
                        </td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                    	<td>
                        	<input type="submit" name="act" value="<?php echo ((isset($this->_rootref['L_275'])) ? $this->_rootref['L_275'] : ((isset($MSG['275'])) ? $MSG['275'] : '{ L_275 }')); ?>">
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
                <table width="98%" cellpadding="0" cellspacing="0">
<?php if ($this->_rootref['PAGNATION']) {  ?>
                <tr>
                    <th><b><?php echo ((isset($this->_rootref['L_313'])) ? $this->_rootref['L_313'] : ((isset($MSG['313'])) ? $MSG['313'] : '{ L_313 }')); ?></b></th>
                    <th><b><?php echo ((isset($this->_rootref['L_766'])) ? $this->_rootref['L_766'] : ((isset($MSG['766'])) ? $MSG['766'] : '{ L_766 }')); ?></b></th>
                    <th align="center"><b><?php echo ((isset($this->_rootref['L_314'])) ? $this->_rootref['L_314'] : ((isset($MSG['314'])) ? $MSG['314'] : '{ L_314 }')); ?></b></th>
                    <th align="center"><b><?php echo ((isset($this->_rootref['L_391'])) ? $this->_rootref['L_391'] : ((isset($MSG['391'])) ? $MSG['391'] : '{ L_391 }')); ?></b></th>
                <tr>
<?php } else { ?>
                <tr>
                    <th><b><?php echo ((isset($this->_rootref['L_314'])) ? $this->_rootref['L_314'] : ((isset($MSG['314'])) ? $MSG['314'] : '{ L_314 }')); ?></b></th>
                    <th align="center"><b><?php echo ((isset($this->_rootref['L_857'])) ? $this->_rootref['L_857'] : ((isset($MSG['857'])) ? $MSG['857'] : '{ L_857 }')); ?></b></th>
                <tr>
<?php } $_accounts_count = (isset($this->_tpldata['accounts'])) ? sizeof($this->_tpldata['accounts']) : 0;if ($_accounts_count) {for ($_accounts_i = 0; $_accounts_i < $_accounts_count; ++$_accounts_i){$_accounts_val = &$this->_tpldata['accounts'][$_accounts_i]; if ($this->_rootref['PAGNATION']) {  ?>
                <tr <?php echo $_accounts_val['BG']; ?>>
                    <td><?php echo $_accounts_val['RNAME']; ?> (<?php echo $_accounts_val['NICK']; ?>)</td>
                    <td><?php echo $_accounts_val['TEXT']; ?></td>
                    <td align="center"><?php echo $_accounts_val['DATE']; ?></td>
                    <td align="center"><?php echo $_accounts_val['AMOUNT']; ?></td>
                </tr>
    <?php } else { ?>
                <tr <?php echo $_accounts_val['BG']; ?>>
                    <td><?php echo $_accounts_val['DATE']; ?></td>
                    <td align="center"><?php echo $_accounts_val['AMOUNT']; ?></td>
                </tr>
    <?php } }} ?>
                </table>
<?php if ($this->_rootref['PAGNATION']) {  ?>
                <table width="98%" cellpadding="0" cellspacing="0" class="blank">
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
<?php } ?>
            </div>
        </div>
<?php $this->_tpl_include('footer.tpl'); ?>