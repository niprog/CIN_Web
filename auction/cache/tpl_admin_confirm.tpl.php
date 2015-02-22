<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>/themes/admin/style.css" />
</head>
<body style="margin:0;">
<div style="width:400px; padding:40px;" class="centre">
	<div class="plain-box" style="text-align:center; padding: 10px; font-size: 1.4em;">
<?php if ($this->_rootref['ERROR'] != ('')) {  ?>
	<div class="error-box"><b><?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?></b></div>
<?php } ?>
	<form action="" method="post">
    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
		<p><?php echo (isset($this->_rootref['MESSAGE'])) ? $this->_rootref['MESSAGE'] : ''; ?></p>
        <div class="break">&nbsp;</div>
<?php if ($this->_rootref['TYPE'] == (1)) {  ?>
        <input type="hidden" name="id" value="<?php echo (isset($this->_rootref['ID'])) ? $this->_rootref['ID'] : ''; ?>">
        <input type="submit" name="action" value="<?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?>">
        <input type="submit" name="action" value="<?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?>">
<?php } else if ($this->_rootref['TYPE'] == (2)) {  ?>
        <input type="hidden" name="id" value="<?php echo (isset($this->_rootref['ID'])) ? $this->_rootref['ID'] : ''; ?>">
        <input type="hidden" name="user" value="<?php echo (isset($this->_rootref['USERID'])) ? $this->_rootref['USERID'] : ''; ?>">
        <input type="submit" name="action" value="<?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?>">
        <input type="submit" name="action" value="<?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?>">
<?php } ?>
	</form>
    </div>
</div>
<div>

<?php $this->_tpl_include('footer.tpl'); ?>