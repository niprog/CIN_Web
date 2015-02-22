<p align="center"><?php echo (isset($this->_rootref['TOP_MESSAGE'])) ? $this->_rootref['TOP_MESSAGE'] : ''; ?></p>

<table width="100%" border="0" cellspacing="2" cellpadding="3" class="paymenttable">
<?php if ($this->_rootref['B_ENPAYPAL']) {  ?>
<tr>
    <td width="160" class="paytable1"><img src="images/paypal.gif"></td>
    <td class="paytable2"><?php echo ((isset($this->_rootref['L_767'])) ? $this->_rootref['L_767'] : ((isset($MSG['767'])) ? $MSG['767'] : '{ L_767 }')); ?></td>
    <td class="paytable3">
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="form_paypal">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="<?php echo (isset($this->_rootref['PP_PAYTOEMAIL'])) ? $this->_rootref['PP_PAYTOEMAIL'] : ''; ?>">
        <input type="hidden" name="receiver_email" value="<?php echo (isset($this->_rootref['PP_PAYTOEMAIL'])) ? $this->_rootref['PP_PAYTOEMAIL'] : ''; ?>">
        <input type="hidden" name="amount" value="<?php echo (isset($this->_rootref['PAY_VAL'])) ? $this->_rootref['PAY_VAL'] : ''; ?>">
        <input type="hidden" name="currency_code" value="<?php echo (isset($this->_rootref['CURRENCY'])) ? $this->_rootref['CURRENCY'] : ''; ?>">
        <input type="hidden" name="return" value="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>validate.php?completed">
        <input type="hidden" name="cancel_return" value="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>validate.php?fail">
        <input type="hidden" name="item_name" value="<?php echo (isset($this->_rootref['TITLE'])) ? $this->_rootref['TITLE'] : ''; ?>">
        <input type="hidden" name="undefined_quantity" value="0">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="no_note" value="1">
        <input type="hidden" name="custom" value="<?php echo (isset($this->_rootref['CUSTOM_CODE'])) ? $this->_rootref['CUSTOM_CODE'] : ''; ?>">
        <input type="hidden" name="notify_url" value="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>validate.php?paypal">
        <input name="submit" type="submit" value="<?php echo ((isset($this->_rootref['L_756'])) ? $this->_rootref['L_756'] : ((isset($MSG['756'])) ? $MSG['756'] : '{ L_756 }')); ?>" border="0">
    </form>
    </td>
</tr>
<?php } if ($this->_rootref['B_ENAUTHNET']) {  ?>
<tr>
    <td width="160" class="paytable1"><img src="images/authnet.gif"></td>
    <td class="paytable2">Authorize.Net</td>
    <td class="paytable3">
    <form action="https://secure.authorize.net/gateway/transact.dll" method="post" id="form_authnet">
        <input type="hidden" name="x_description" value="<?php echo (isset($this->_rootref['TITLE'])) ? $this->_rootref['TITLE'] : ''; ?>">
        <input type="hidden" name="x_login" value="<?php echo (isset($this->_rootref['AN_PAYTOID'])) ? $this->_rootref['AN_PAYTOID'] : ''; ?>">
        <input type="hidden" name="x_amount" value="<?php echo (isset($this->_rootref['PAY_VAL'])) ? $this->_rootref['PAY_VAL'] : ''; ?>">
        <input type="hidden" name="x_show_form" value="PAYMENT_FORM">
        <input type="hidden" name="x_relay_response" value="TRUE">
        <input type="hidden" name="x_relay_url" value="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>validate.php?authnet">
        <input type="hidden" name="x_fp_sequence" value="<?php echo (isset($this->_rootref['AN_SEQUENCE'])) ? $this->_rootref['AN_SEQUENCE'] : ''; ?>">
        <input type="hidden" name="x_fp_timestamp" value="<?php echo (isset($this->_rootref['TIMESTAMP'])) ? $this->_rootref['TIMESTAMP'] : ''; ?>">
        <input type="hidden" name="x_fp_hash" value="<?php echo (isset($this->_rootref['AN_KEY'])) ? $this->_rootref['AN_KEY'] : ''; ?>">
        <input type="hidden" name="custom" value="<?php echo (isset($this->_rootref['CUSTOM_CODE'])) ? $this->_rootref['CUSTOM_CODE'] : ''; ?>">
        <input name="submit" type="submit" value="<?php echo ((isset($this->_rootref['L_756'])) ? $this->_rootref['L_756'] : ((isset($MSG['756'])) ? $MSG['756'] : '{ L_756 }')); ?>" border="0">
    </form>
    </td>
</tr>
<?php } if ($this->_rootref['B_ENWORLDPAY']) {  ?>
<tr>
    <td width="160" class="paytable1"><img src="images/worldpay.gif"></td>
    <td class="paytable2">WorldPay</td>
    <td class="paytable3">
    <form action="https://select.worldpay.com/wcc/purchase" method="post" id="form_worldpay">
    	<input type="hidden" name="instId" value="<?php echo (isset($this->_rootref['WP_PAYTOID'])) ? $this->_rootref['WP_PAYTOID'] : ''; ?>">
        <input type="hidden" name="amount" value="<?php echo (isset($this->_rootref['PAY_VAL'])) ? $this->_rootref['PAY_VAL'] : ''; ?>">
        <input type="hidden" name="currency" value="<?php echo (isset($this->_rootref['CURRENCY'])) ? $this->_rootref['CURRENCY'] : ''; ?>">
        <input type="hidden" name="desc" value="<?php echo (isset($this->_rootref['TITLE'])) ? $this->_rootref['TITLE'] : ''; ?>">
        <input type="hidden" name="MC_callback" value="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>validate.php?worldpay">
        <input type="hidden" name="cartId" value="<?php echo (isset($this->_rootref['CUSTOM_CODE'])) ? $this->_rootref['CUSTOM_CODE'] : ''; ?>">
        <input name="submit" type="submit" value="<?php echo ((isset($this->_rootref['L_756'])) ? $this->_rootref['L_756'] : ((isset($MSG['756'])) ? $MSG['756'] : '{ L_756 }')); ?>" border="0">
    </form>
    </td>
</tr>
<?php } if ($this->_rootref['B_ENMONEYBOOKERS']) {  ?>
<tr>
    <td width="160" class="paytable1"><img src="images/moneybookers.gif"></td>
    <td class="paytable2">Moneybookers</td>
    <td class="paytable3">
    <form action="https://www.moneybookers.com/app/payment.pl" method="post" id="form_moneybookers">
    	<input type="hidden" name="pay_to_email" value="<?php echo (isset($this->_rootref['MB_PAYTOEMAIL'])) ? $this->_rootref['MB_PAYTOEMAIL'] : ''; ?>">
        <input type="hidden" name="amount" value="<?php echo (isset($this->_rootref['PAY_VAL'])) ? $this->_rootref['PAY_VAL'] : ''; ?>">
        <input type="hidden" name="language" value="EN">
        <input type="hidden" name="merchant_fields" value="trans_id">
        <input type="hidden" name="currency" value="<?php echo (isset($this->_rootref['CURRENCY'])) ? $this->_rootref['CURRENCY'] : ''; ?>">
        <input type="hidden" name="return_url" value="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>validate.php?completed">
        <input type="hidden" name="cancel_url" value="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>validate.php?fail">
        <input type="hidden" name="status_url" value="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>validate.php?moneybookers">
        <input type="hidden" name="trans_id" value="<?php echo (isset($this->_rootref['CUSTOM_CODE'])) ? $this->_rootref['CUSTOM_CODE'] : ''; ?>">
        <input name="submit" type="submit" value="<?php echo ((isset($this->_rootref['L_756'])) ? $this->_rootref['L_756'] : ((isset($MSG['756'])) ? $MSG['756'] : '{ L_756 }')); ?>" border="0">
    </form>
    </td>
</tr>
<?php } if ($this->_rootref['B_ENTOOCHECK']) {  ?>
<tr>
    <td width="160" class="paytable1"><img src="images/toocheckout.gif"></td>
    <td class="paytable2">2Checkout</td>
    <td class="paytable3">
    <form action="https://www2.2checkout.com/2co/buyer/purchase" method="post" id="form_toocheckout">
    	<input type="hidden" name="sid" value="<?php echo (isset($this->_rootref['TC_PAYTOID'])) ? $this->_rootref['TC_PAYTOID'] : ''; ?>">
        <input type="hidden" name="total" value="<?php echo (isset($this->_rootref['PAY_VAL'])) ? $this->_rootref['PAY_VAL'] : ''; ?>">
        <input type="hidden" name="cart_order_id" value="<?php echo (isset($this->_rootref['CUSTOM_CODE'])) ? $this->_rootref['CUSTOM_CODE'] : ''; ?>">
        <input name="submit" type="submit" value="<?php echo ((isset($this->_rootref['L_756'])) ? $this->_rootref['L_756'] : ((isset($MSG['756'])) ? $MSG['756'] : '{ L_756 }')); ?>" border="0">
    </form>
    </td>
</tr>
<?php } ?>
</table>

<?php if ($this->_rootref['B_TOUSER']) {  ?>
<div style="text-align:center;">
    <?php echo (isset($this->_rootref['TOUSER_STRING'])) ? $this->_rootref['TOUSER_STRING'] : ''; ?>
</div>
<?php } ?>