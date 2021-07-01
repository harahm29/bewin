  <!-- head area -->
  @include('includes.admin-head')
		<!-- end  head area -->

		<body>

		<!--[if lt IE 8]>
			<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

        <div id="preloader"></div>
        <!-- header area -->
		@include('includes.admin-header')
		<!-- end  header area -->
        <!-- Start Slider Area -->
		@include('includes.slider-area')
        <!-- End Slider Area -->
        <!-- Start How to area -->
		@include('includes.how-to-area')
        <!-- End How to area -->
        <!-- Start About Area -->
		
        <!-- End About Area -->
        <!-- Start Lottery area -->
		@include('includes.lottery-area')
        <!-- End Lottery area -->
		<!-- Start Number area -->
        @include('includes.number-area')
        <!-- End Number area -->
        <!-- Start Choose area -->
		@include('includes.choose-area')
        <!-- End Choose area -->
        
        <!--Start payment-history area -->
        @include('includes.payment-history-area')
        <!-- End payment-history area -->
        <!-- Start Blog area -->
       
		@include('includes.admin-footer')
        <!-- End Start Footer Area -->
      
	</body>
</html>