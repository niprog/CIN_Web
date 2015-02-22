<?php $this->_tpl_include('header.tpl'); ?>
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<div class="box">
                	<h4 class="rounded-top"><?php echo ((isset($this->_rootref['L_1061'])) ? $this->_rootref['L_1061'] : ((isset($MSG['1061'])) ? $MSG['1061'] : '{ L_1061 }')); ?></h4>
                    <div class="rounded-bottom">
                    	<form name="anotes" action="" method="post">
							<textarea rows="15" name="anotes" class="anotes"><?php echo (isset($this->_rootref['ADMIN_NOTES'])) ? $this->_rootref['ADMIN_NOTES'] : ''; ?></textarea>
							<input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
							<input type="submit" name="act" value="<?php echo ((isset($this->_rootref['L_007'])) ? $this->_rootref['L_007'] : ((isset($MSG['007'])) ? $MSG['007'] : '{ L_007 }')); ?>">
						</form>
					</div>
                </div>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<table width="98%" cellpadding="1" cellspacing="0">
					<tr>
						<th colspan="2"><?php echo ((isset($this->_rootref['L_1062'])) ? $this->_rootref['L_1062'] : ((isset($MSG['1062'])) ? $MSG['1062'] : '{ L_1062 }')); ?></th>
					</tr>
					<tr>
						<td width="172"><a href="http://www.webidsupport.com/forums/forumdisplay.php?29-WeBid-Support"><strong><?php echo ((isset($this->_rootref['L_1063'])) ? $this->_rootref['L_1063'] : ((isset($MSG['1063'])) ? $MSG['1063'] : '{ L_1063 }')); ?></strong><a/></td>
						<td><?php echo ((isset($this->_rootref['L_1064'])) ? $this->_rootref['L_1064'] : ((isset($MSG['1064'])) ? $MSG['1064'] : '{ L_1064 }')); ?></td>
					</tr>
					<tr class="bg">
						<td><a href="http://www.webidsupport.com/wiki/Category:Documentation"><strong><?php echo ((isset($this->_rootref['L_1065'])) ? $this->_rootref['L_1065'] : ((isset($MSG['1065'])) ? $MSG['1065'] : '{ L_1065 }')); ?></strong></a></td>
						<td><?php echo ((isset($this->_rootref['L_1066'])) ? $this->_rootref['L_1066'] : ((isset($MSG['1066'])) ? $MSG['1066'] : '{ L_1066 }')); ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><a href="http://www.webidsupport.com/forums/forumdisplay.php?41-Commonly-Asked-Questions-and-Their-Solutions"><strong><?php echo ((isset($this->_rootref['L_1067'])) ? $this->_rootref['L_1067'] : ((isset($MSG['1067'])) ? $MSG['1067'] : '{ L_1067 }')); ?></strong></a></td>
					</tr>
					<tr>
						<th colspan="2"><?php echo ((isset($this->_rootref['L_1068'])) ? $this->_rootref['L_1068'] : ((isset($MSG['1068'])) ? $MSG['1068'] : '{ L_1068 }')); ?></th>
					</tr>
					<tr class="bg">
						<td><a href="http://www.webidsupport.com/mods.php?do=themes"><strong><?php echo ((isset($this->_rootref['L_1069'])) ? $this->_rootref['L_1069'] : ((isset($MSG['1069'])) ? $MSG['1069'] : '{ L_1069 }')); ?></strong></a></td>
						<td><?php echo ((isset($this->_rootref['L_1070'])) ? $this->_rootref['L_1070'] : ((isset($MSG['1070'])) ? $MSG['1070'] : '{ L_1070 }')); ?></td>
					</tr>
					<tr>
						<td><a href="http://www.webidsupport.com/mods.php?do=mods"><strong><?php echo ((isset($this->_rootref['L_1071'])) ? $this->_rootref['L_1071'] : ((isset($MSG['1071'])) ? $MSG['1071'] : '{ L_1071 }')); ?></strong></a></td>
						<td><?php echo ((isset($this->_rootref['L_1072'])) ? $this->_rootref['L_1072'] : ((isset($MSG['1072'])) ? $MSG['1072'] : '{ L_1072 }')); ?></td>
					</tr>
					<tr class="bg">
						<td><a href="http://www.webidsupport.com/wiki/Translations"><strong><?php echo ((isset($this->_rootref['L_1073'])) ? $this->_rootref['L_1073'] : ((isset($MSG['1073'])) ? $MSG['1073'] : '{ L_1073 }')); ?></strong></a></td>
						<td><?php echo ((isset($this->_rootref['L_1074'])) ? $this->_rootref['L_1074'] : ((isset($MSG['1074'])) ? $MSG['1074'] : '{ L_1074 }')); ?></td>
					</tr>
					<tr>
						<th colspan="2"><?php echo ((isset($this->_rootref['L_1075'])) ? $this->_rootref['L_1075'] : ((isset($MSG['1075'])) ? $MSG['1075'] : '{ L_1075 }')); ?></th>
					</tr>
					<tr>
						<td><a href="http://www.webidsupport.com/forums/project.php?do=issuelist&projectid=1&issuetypeid=bug"><strong><?php echo ((isset($this->_rootref['L_1076'])) ? $this->_rootref['L_1076'] : ((isset($MSG['1076'])) ? $MSG['1076'] : '{ L_1076 }')); ?></strong></a></td>
						<td><?php echo ((isset($this->_rootref['L_1077'])) ? $this->_rootref['L_1077'] : ((isset($MSG['1077'])) ? $MSG['1077'] : '{ L_1077 }')); ?></td>
					</tr>
					<tr class="bg">
						<td><a href="http://www.webidsupport.com/forums/project.php?do=issuelist&projectid=1&issuetypeid=feature"><strong><?php echo ((isset($this->_rootref['L_1078'])) ? $this->_rootref['L_1078'] : ((isset($MSG['1078'])) ? $MSG['1078'] : '{ L_1078 }')); ?></strong></a></td>
						<td><?php echo ((isset($this->_rootref['L_1079'])) ? $this->_rootref['L_1079'] : ((isset($MSG['1079'])) ? $MSG['1079'] : '{ L_1079 }')); ?></td>
					</tr>
					<tr>
						<td><a href="http://www.webidsupport.com/forums/misc.php?do=donate"><strong><?php echo ((isset($this->_rootref['L_1080'])) ? $this->_rootref['L_1080'] : ((isset($MSG['1080'])) ? $MSG['1080'] : '{ L_1080 }')); ?></strong></a></td>
						<td><?php echo ((isset($this->_rootref['L_1081'])) ? $this->_rootref['L_1081'] : ((isset($MSG['1081'])) ? $MSG['1081'] : '{ L_1081 }')); ?></td>
					</tr>
				</table>
            </div>
        </div>
<?php $this->_tpl_include('footer.tpl'); ?>