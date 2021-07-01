<?php
$current_month = date("M");
$current_day = date("d");
$current_year = date("Y");
$full_name = "Trilok";//session('full_name');

		$address = $user->flate_no." ".$user->apartment." ".$user->area." ".$user->mobile_no;
		

	
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" style="background-color:#CCCCCC; padding-top:20px; padding-bottom:20px;"><table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td style="background-color:#FFFFFF;"><table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="169" height="20">&nbsp;</td>
            <td width="501">&nbsp;</td>
          </tr>
          <tr>
            <td><a href="{{url('public/images/Shudh Milk-01.jpg')}}" target="_blank"><img src="{{url('public/images/Shudh Milk-01.jpg')}}" alt="" border="0" height="80" /></a></td>
            <td align="right" style="font-family:Arial, Helvetica, sans-serif;"><strong>Notification</strong><br /><?php echo $current_month.' '.$current_day.', '.$current_year;?></td>
          </tr>
          <tr>
            <td style="height:20px; border-bottom:1px solid #CCCCCC;">&nbsp;</td>
            <td style="border-bottom:1px solid #CCCCCC;">&nbsp;</td>
          </tr>
          <tr>
            <td style="height:20px;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
          <table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td style="font-family:Arial, Helvetica, sans-serif;"><p>Hi  <?php echo ucwords($user->name); ?> </p>
<!-----------------------------invoice start ------------------------------------------>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
		  <tr>
			<td width="348" height="30" style="border-bottom:1px solid #CCCCCC;">Order Number: <strong>{{$order_id}}</strong> </td>
			<td width="322" align="right" style="border-bottom:1px solid #CCCCCC;">Order Status: <b>{{$main_order->order_status}}</b> </td>
		  </tr>
		</table>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
		  <tr>
			<td width="335" valign="top" style="border-right:1px solid #CCCCCC; padding-top:12px; padding-bottom:12px;"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
        <td width="25%" valign="top"><strong>Bill To: </strong></td>
        <td width="75%" valign="top"><strong>{{ucwords($user->firm_name)}}</strong>
		  </td>
      </tr>
			  <tr>
        <td width="25%" valign="top">&nbsp;</td>
        <td width="75%" valign="top">{{ucwords($address)}}
		  </td>
      </tr>
	  
    </table></td>
    <td width="335" valign="top" style="padding-top:12px; padding-bottom:12px;"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
        <td width="25%" valign="top"><strong>Ship To: </strong></td>
        <td width="75%" valign="top"><strong>{{ucwords($user->firm_name)}}</strong>
		  </td>
      </tr>
      <tr>
        <td width="25%" valign="top">&nbsp;</td>
        <td width="75%" valign="top">{{ucwords($address)}}</td>
      </tr>
    </table></td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="6" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
  <tr>
    <td width="375" align="left" style="background-color:#000000; color:#FFFFFF;"><strong>Product Description</strong></td>
    <td width="80" align="center" style="background-color:#000000; color:#FFFFFF;"><strong>Qty.</strong></td>
    <td width="111" align="right" style="background-color:#000000; color:#FFFFFF;"><strong>Unit Price (INR) </strong></td>
    <td width="150" align="right" style="background-color:#000000; color:#FFFFFF;"><strong>Total Price (INR) </strong></td>
  </tr>


@foreach($order_details as $order)
	

<tr>
    <td align="left" style="border-bottom:1px solid #CCCCCC;">
	{{$order->product_name}} </td>
    <td align="center" style="border-bottom:1px solid #CCCCCC;">{{$order->qty}}</td>
    <td align="right" style="border-bottom:1px solid #CCCCCC;">{{$order->price}}</td>
    <td align="right" style="border-bottom:1px solid #CCCCCC;">{{$order->total_price}}</td>
  </tr>
	
@endforeach 



<tr>
    <td align="left" ></td>
    <td align="center">&nbsp;</td>
    <td align="right">Total</td>
    <td align="right">{{($main_order->price)}}</td>
  </tr>
 
  <tr>
    
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp; </td>
    <td align="right">&nbsp;</td>
  </tr>
  
  <tr>
    
    <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
    <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
    <td align="right" bgcolor="#CCCCCC"><strong>Grand Total</strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong>{{$main_order->price}}</strong></td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
  <tr>
    <td width="335" style="padding:12px; border-bottom:1px solid #CCCCCC;">
	<p style="font-weight:bold;">Frequently Asked Questions</p>
	<p style="font-weight:bold;">When will I get my items?</p>
	<p>You will receive an email in 1 - 8 hrs. with delivery time and tracking details once your order is confirmed.</p>
	</td>
    <td width="335" style="padding:12px; border-left:2px solid #CCCCCC; border-bottom:1px solid #CCCCCC;">
	<p style="font-weight:bold;">How do I get in touch with seller?</p>
	<p>You can get all the contact details of the seller mentioned at top on your invoice. If you still have any further queries you can raise your issue by sending us an email on <a href="mailto:info@shudhmilk.com?subject= Ref: Order Number # '.$order_id.'">info@shudhmilk.com</a>. Please ensure that you have the order number for better assistance.</p>
	</td>
  </tr>
</table>
			
			
			
			
			</td>
            </tr>
            <tr>
              <td style="font-family:Arial, Helvetica, sans-serif;"><br />
			  Thank you<br />
			  Shudhmilk <br/>
			  <a href="{{url('/')}}">{{url('/')}}</a>
			  <br/>
			  <br/>
			  </td>
            </tr>
            <tr>
              <td style="border-top:1px solid #CCCCCC; padding-top:15px;"><table border="0" cellspacing="0" cellpadding="0">
                <tr>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="20">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
    </table>
      <table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td style="text-align:center; padding-top:15px; font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            
            
          </td>
        </tr>
      </table></td>
  </tr>
</table>