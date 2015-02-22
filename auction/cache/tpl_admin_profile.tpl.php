<?php $this->_tpl_include('header.tpl'); ?>
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<?php $this->_tpl_include('sidebar-' . ((isset($this->_rootref['CURRENT_PAGE'])) ? $this->_rootref['CURRENT_PAGE'] : '') . '.tpl'); ?>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom"><?php echo ((isset($this->_rootref['L_25_0010'])) ? $this->_rootref['L_25_0010'] : ((isset($MSG['25_0010'])) ? $MSG['25_0010'] : '{ L_25_0010 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_25_0005'])) ? $this->_rootref['L_25_0005'] : ((isset($MSG['25_0005'])) ? $MSG['25_0005'] : '{ L_25_0005 }')); ?></h4>
				<form name="profile_feilds" action="" method="post">
<?php if ($this->_rootref['ERROR'] != ('')) {  ?>
					<div class="error-box"><b><?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?></b></div>
<?php } ?>
                    <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                    <tr valign="top">
                        <td width="50%"><?php echo ((isset($this->_rootref['L_781'])) ? $this->_rootref['L_781'] : ((isset($MSG['781'])) ? $MSG['781'] : '{ L_781 }')); ?></td>
                        <td>
                            <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?><input type="radio" name="birthdate" value="y" <?php if ($this->_rootref['REQUIRED_0']) {  ?>checked="checked"<?php } ?>>
                            <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><input type="radio" name="birthdate" value="n" <?php if (! $this->_rootref['REQUIRED_0']) {  ?>checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    <tr valign="top" class="bg">
                        <td><?php echo ((isset($this->_rootref['L_780'])) ? $this->_rootref['L_780'] : ((isset($MSG['780'])) ? $MSG['780'] : '{ L_780 }')); ?></td>
                        <td>
                            <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?><input type="radio" name="birthdate_regshow" value="y" <?php if ($this->_rootref['DISPLAYED_0']) {  ?>checked="checked"<?php } ?>>
                            <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><input type="radio" name="birthdate_regshow" value="n" <?php if (! $this->_rootref['DISPLAYED_0']) {  ?>checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?php echo ((isset($this->_rootref['L_782'])) ? $this->_rootref['L_782'] : ((isset($MSG['782'])) ? $MSG['782'] : '{ L_782 }')); ?></td>
                        <td>
                            <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?><input type="radio" name="address" value="y" <?php if ($this->_rootref['REQUIRED_1']) {  ?>checked="checked"<?php } ?>>
                            <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><input type="radio" name="address" value="n" <?php if (! $this->_rootref['REQUIRED_1']) {  ?>checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    <tr valign="top" class="bg">
                        <td><?php echo ((isset($this->_rootref['L_780'])) ? $this->_rootref['L_780'] : ((isset($MSG['780'])) ? $MSG['780'] : '{ L_780 }')); ?></td>
                        <td>
                            <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?><input type="radio" name="address_regshow" value="y" <?php if ($this->_rootref['DISPLAYED_1']) {  ?>checked="checked"<?php } ?>>
                            <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><input type="radio" name="address_regshow" value="n" <?php if (! $this->_rootref['DISPLAYED_1']) {  ?>checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?php echo ((isset($this->_rootref['L_783'])) ? $this->_rootref['L_783'] : ((isset($MSG['783'])) ? $MSG['783'] : '{ L_783 }')); ?></td>
                        <td>
                            <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?><input type="radio" name="city" value="y" <?php if ($this->_rootref['REQUIRED_2']) {  ?>checked="checked"<?php } ?>>
                            <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><input type="radio" name="city" value="n" <?php if (! $this->_rootref['REQUIRED_2']) {  ?>checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    <tr valign="top" class="bg">
                        <td><?php echo ((isset($this->_rootref['L_780'])) ? $this->_rootref['L_780'] : ((isset($MSG['780'])) ? $MSG['780'] : '{ L_780 }')); ?></td>
                        <td>
                            <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?><input type="radio" name="city_regshow" value="y" <?php if ($this->_rootref['DISPLAYED_2']) {  ?>checked="checked"<?php } ?>>
                            <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><input type="radio" name="city_regshow" value="n" <?php if (! $this->_rootref['DISPLAYED_2']) {  ?>checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?php echo ((isset($this->_rootref['L_784'])) ? $this->_rootref['L_784'] : ((isset($MSG['784'])) ? $MSG['784'] : '{ L_784 }')); ?></td>
                        <td>
                            <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?><input type="radio" name="prov" value="y" <?php if ($this->_rootref['REQUIRED_3']) {  ?>checked="checked"<?php } ?>>
                            <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><input type="radio" name="prov" value="n" <?php if (! $this->_rootref['REQUIRED_3']) {  ?>checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    <tr valign="top" class="bg">
                        <td><?php echo ((isset($this->_rootref['L_780'])) ? $this->_rootref['L_780'] : ((isset($MSG['780'])) ? $MSG['780'] : '{ L_780 }')); ?></td>
                        <td>
                            <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?><input type="radio" name="prov_regshow" value="y" <?php if ($this->_rootref['DISPLAYED_3']) {  ?>checked="checked"<?php } ?>>
                            <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><input type="radio" name="prov_regshow" value="n" <?php if (! $this->_rootref['DISPLAYED_3']) {  ?>checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?php echo ((isset($this->_rootref['L_785'])) ? $this->_rootref['L_785'] : ((isset($MSG['785'])) ? $MSG['785'] : '{ L_785 }')); ?></td>
                        <td>
                            <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?><input type="radio" name="country" value="y" <?php if ($this->_rootref['REQUIRED_4']) {  ?>checked="checked"<?php } ?>>
                            <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><input type="radio" name="country" value="n" <?php if (! $this->_rootref['REQUIRED_4']) {  ?>checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    <tr valign="top" class="bg">
                        <td><?php echo ((isset($this->_rootref['L_780'])) ? $this->_rootref['L_780'] : ((isset($MSG['780'])) ? $MSG['780'] : '{ L_780 }')); ?></td>
                        <td>
                            <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?><input type="radio" name="country_regshow" value="y" <?php if ($this->_rootref['DISPLAYED_4']) {  ?>checked="checked"<?php } ?>>
                            <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><input type="radio" name="country_regshow" value="n" <?php if (! $this->_rootref['DISPLAYED_4']) {  ?>checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?php echo ((isset($this->_rootref['L_786'])) ? $this->_rootref['L_786'] : ((isset($MSG['786'])) ? $MSG['786'] : '{ L_786 }')); ?></td>
                        <td>
                            <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?><input type="radio" name="zip" value="y" <?php if ($this->_rootref['REQUIRED_5']) {  ?>checked="checked"<?php } ?>>
                            <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><input type="radio" name="zip" value="n" <?php if (! $this->_rootref['REQUIRED_5']) {  ?>checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    <tr valign="top" class="bg">
                        <td><?php echo ((isset($this->_rootref['L_780'])) ? $this->_rootref['L_780'] : ((isset($MSG['780'])) ? $MSG['780'] : '{ L_780 }')); ?></td>
                        <td>
                            <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?><input type="radio" name="zip_regshow" value="y" <?php if ($this->_rootref['DISPLAYED_5']) {  ?>checked="checked"<?php } ?>>
                            <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><input type="radio" name="zip_regshow" value="n" <?php if (! $this->_rootref['DISPLAYED_5']) {  ?>checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?php echo ((isset($this->_rootref['L_787'])) ? $this->_rootref['L_787'] : ((isset($MSG['787'])) ? $MSG['787'] : '{ L_787 }')); ?></td>
                        <td>
                            <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?><input type="radio" name="tel" value="y" <?php if ($this->_rootref['REQUIRED_6']) {  ?>checked="checked"<?php } ?>>
                            <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><input type="radio" name="tel" value="n" <?php if (! $this->_rootref['REQUIRED_6']) {  ?>checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    <tr valign="top" class="bg">
                        <td><?php echo ((isset($this->_rootref['L_780'])) ? $this->_rootref['L_780'] : ((isset($MSG['780'])) ? $MSG['780'] : '{ L_780 }')); ?></td>
                        <td>
                            <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?><input type="radio" name="tel_regshow" value="y" <?php if ($this->_rootref['DISPLAYED_6']) {  ?>checked="checked"<?php } ?>>
                            <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><input type="radio" name="tel_regshow" value="n" <?php if (! $this->_rootref['DISPLAYED_6']) {  ?>checked="checked"<?php } ?>>
                        </td>
                    </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
                    <input type="submit" name="act" class="centre" value="<?php echo ((isset($this->_rootref['L_530'])) ? $this->_rootref['L_530'] : ((isset($MSG['530'])) ? $MSG['530'] : '{ L_530 }')); ?>">
				</form>
            </div>
        </div>
<?php $this->_tpl_include('footer.tpl'); ?>