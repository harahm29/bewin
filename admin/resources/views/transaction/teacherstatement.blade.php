<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>User Transaction</title>
<link rel="shortcut icon" type="image/png" href="{{url('/public/images/drcr.png')}}" class="img-circle" alt="User Image" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>

<style>
body{
font-family:arial;
font-size:14px;
color:#000;	
}


.statement1_tble{
border:1px solid #000;	
}

.statement1_tble thead tr th{
	-webkit-print-color-adjust: exact;
	background:#797979;
border-bottom:1px solid #000;
border-right:1px solid #000;
padding:5px;
font-weight:bold;	
}

.statement1_tble tbody tr td{
border-right:1px solid #000;
border-bottom:1px solid #000;
padding:5px;
    font-size: 13px;
    font-weight:400;
	
}


.statement1_tble tbody tr td.last_td_all{
border-right:0px;	
}

.statement1_tble thead tr th.last_td_all{
border-right:0px;	
}

.statement1_tble tbody tr td.last_td_btm{
	border-bottom:0px;	
	}
</style>


<body>



<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
  <tbody>
    <tr>
      <td align="center" valign="top" width="33%">&nbsp;</td>
	  @if(Auth::user()->type=='admin')
      <td  align="center" valign="top"  width="33%"><h2>User</h2><h3>{{$teachername->name}}</h3></td>
      @else
		<td  align="center" valign="top"  width="33%"><h2>User</h2><h3>{{Auth::user()->name}}</h3></td>  
	  @endif
      <td  align="center" valign="middle"  width="33%"><span style="font-weight:600;">{{$from}} to {{$to}}</span></td>
    </tr>
  </tbody>
</table>





<table width="100%" border="0" cellspacing="0" cellpadding="0" class="statement1_tble">
  <thead style="color:#fff;" class="text-success">
    <tr>
      <th align="center" valign="top">Sr. No.</th>
      <th align="left" valign="top">Date</th>
      <th align="left" valign="top">Description</th>
      <th align="left" valign="top">Vch/Type</th>
      <th align="left" valign="top">Vch/No.</th>
      <th align="left" valign="top">Debit</th>
      <th align="left" valign="top" class="last_td_all">Credit</th>
    </tr>
  </thead>
  
 <tbody>
 
				@if($old_date_data > 0)
				
				@php
				$outstanding_dr =str_replace("-","",number_format($old_date_data,2));
						    $outstanding_cr = "";
							$outstadingdr = $old_date_data; 
							$outstadingcr = 0;
							@endphp
					@else
							@php	$outstanding_dr = "";
						    $outstanding_cr = $old_date_data; 
							$outstadingcr = $old_date_data;
							$outstadingdr = 0;
							@endphp
				@endif		
				 
				@if($outstanding_dr!='' || $outstanding_cr!='' && $outstanding_dr>0)
					
    <tr>
		<th colspan="5" style="text-align: right;">Opening Balance</th>
		<th style="color:green">{{ $outstanding_dr }}</th>
		<th style="color:red">{{ $outstanding_cr  }}</th>
    </tr>
	@endif
               @php $i=1; 
			   $total_dr=$outstadingdr;
			   $total_cr=$outstadingcr;
			   @endphp
               @foreach($transactions as $data)
			   @if($data->dr!=0.00)
				   @php $dr = number_format($data->dr,2); @endphp
			   @else
				   @php $dr = ''; @endphp
			   @endif
			   @if($data->cr!=0.00)
				   @php $cr = number_format($data->cr,2); @endphp
			   @else
				   @php $cr = ''; @endphp
			   @endif
			   @if($data->description == "Opening Balance")
			   
		      @php  $data->rel_id = ""; @endphp
		        @endif 
	
	
	
    <tr>
		        <td align="center" valign="top">{{$i}}</td>
				<td align="left" valign="top">{{$data->transaction_date}}</td>
				<td align="left" valign="top">{{$data->description}}</td>
				<td align="left" valign="top">{{ucwords(str_replace("_"," ",$data->form_name))}}</td>
				<td align="left" valign="top">{{$data->order_id}}</td>
				<td align="left" valign="top">{{$data->dr}}</td>
				<td align="left" valign="top"  class="last_td_all">{{$data->cr}}</td>		   
    </tr>
   
	@php $i++; 
	$total_dr += $data->dr;
	$total_cr += $data->cr;
	@endphp
             @endforeach
    
    @php $diff =  ($total_dr - $total_cr); @endphp
				@if(($diff) < 0)
					 @php  
						  $closing_dr_view = str_replace("-"," ",number_format($diff,2));
						  $closing_dr = str_replace("-"," ",$diff);
						  $closing_cr_view = '';
						  $closing_cr =0;
						 
				 @endphp
					 @else 
					 @php  
				     $closing_dr_view = '';
				     $closing_cr_view = str_replace("-"," ",number_format($diff,2));
				     $closing_cr = str_replace("-"," ",$diff);
					 $closing_dr=0;
				 @endphp
				@endif
				 
    
    
     <tr>
      <td align="center" valign="top"></td>
      <td align="left" valign="top"></td>
      <td align="left" valign="top"></td>
      <td align="left" valign="top"></td>
      <td align="right" valign="top"><b>Difference</b></td>
      <td align="left" valign="top" style="border-bottom:2px solid #000;color:green;font-size:18px;">@if($closing_dr_view)$ @endif {{ $closing_dr_view }}</td>
      <td align="left" valign="top" class="last_td_all" style="border-bottom:2px solid #000;color:red;font-size:18px;"><b style="color:#FF0004;">@if($closing_cr_view)$ @endif {{ $closing_cr_view }}</b></td>
    </tr>
    
    <tr>
      <td align="center" valign="top"></td>
      <td align="left" valign="top"></td>
      <td align="left" valign="top"></td>
      <td align="left" valign="top"></td>
      <td align="right" valign="top"><b>Total</b></td>
      <td align="left" valign="top"><b>${{str_replace("-","",number_format(($total_dr+$closing_dr),2))  }}</b></td>
      <td align="left" valign="top" class="last_td_all"><b>$ {{str_replace("-","",number_format(($total_cr+$closing_cr),2))  }}</b></td>
    </tr>
    
    <tr>
      <td align="center" valign="top" class="last_td_btm"></td>
      <td align="left" valign="top" class="last_td_btm"></td>
      <td align="right" valign="top" class="last_td_btm"></td>
      <td align="left" valign="top" class="last_td_btm"></td>
      <td align="right" valign="top" class="last_td_btm"><b>Closing</b></td>
      <td align="left" valign="top" class="last_td_btm" style="color:#089217;font-size:18px;">@if($closing_cr_view)$@endif {{ $closing_cr_view  }}</td>
      <td align="left" valign="top" class="last_td_all last_td_btm" style="color:red;font-size:18px;">@if($closing_dr_view)$ @endif {{$closing_dr_view }}</td>
    </tr>
    
    
    
  </tbody> 
  
  
  
</table>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	window.print();

})
</script>
</body>
</html>