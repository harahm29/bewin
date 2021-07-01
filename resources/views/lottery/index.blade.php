@extends('layouts.admin')
@section('title','Lottery 2')
@section('content')
 <!-- Start Bottom Header -->
 <div class="page-area">
            <div class="breadcumb-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb text-center">
                            <div class="section-headline text-center">
                                <h3>Lottery Two</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>Lottery Two</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Header -->
  <!-- Start Number area -->
  <div class="lottery-area area-padding-2">
            <div class="container">
                 <div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-headline text-center">
							<h3>Lottery Number</h3>
							<p>Dummy text is also used to demonstrate the appearance of different typefaces and layouts</p>
						</div>
					</div>
				</div>
                 <div class="row">
                    <div class="lottery-content">
                        <!-- Single Lottery area  -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-lottery">
                                <div class="lottery-top">
                                    <span class="ticket-rate">20CD</span>
                                    <h4>Mega Jackpot</h4>
                                    <span class="win-price">Win price</span>
                                    <span class="win-money">$200k</span>
                                    <div class="buy-ticket-btn">
                                        <a class="ticket-btn" href="#">Play Now</a>
                                    </div>
                                </div>
                                <div class="auto-number">
                                    <div class="number-top">
                                        <input type="radio" id="auto-num" name="auto-num">
                                        <label for="auto-num">
                                        Auto Number Generated
                                        <span class="genreted-text">Automatically Random Number will be Generated</span>
                                        </label>
                                    </div>
                                    <div class="number-all">
                                        <ul class="number-serial">
                                            <li><a href="#">11</a></li>
                                            <li><a href="#">12</a></li>
                                            <li><a href="#">13</a></li>
                                            <li class="active"><a href="#">14</a></li>
                                            <li><a href="#">15</a></li>
                                            <li><a href="#">16</a></li>
                                            <li class="active"><a href="#">17</a></li>
                                            <li><a href="#">18</a></li>
                                            <li><a href="#">19</a></li>
                                            <li class="active"><a href="#">20</a></li>
                                            <li><a href="#">21</a></li>
                                            <li><a href="#">22</a></li>
                                            <li><a href="#">23</a></li>
                                            <li><a href="#">24</a></li>
                                            <li><a href="#">25</a></li>
                                            <li><a href="#">26</a></li>
                                            <li><a href="#">27</a></li>
                                            <li class="active"><a href="#">28</a></li>
                                            <li><a href="#">29</a></li>
                                            <li><a href="#">30</a></li>
                                            <li><a href="#">31</a></li>
                                            <li class="active"><a href="#">32</a></li>
                                            <li><a href="#">33</a></li>
                                            <li><a href="#">34</a></li>
                                            <li><a href="#">35</a></li>
                                            <li><a href="#">36</a></li>
                                            <li><a href="#">37</a></li>
                                            <li><a href="#">38</a></li>
                                            <li><a href="#">39</a></li>
                                            <li><a href="#">40</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="manual-number">
                                    <div class="number-top">
                                        <input type="radio" id="manual-num" name="auto-num">
                                        <label for="manual-num">
                                        Manual Number Selected
                                        <span class="genreted-text">Type 5 Number Selected Manually</span>
                                        </label>
                                    </div>
                                    <div class="number-all">
                                        <ul class="number-serial">
                                            <li><a href="#">11</a></li>
                                            <li class="active"><a href="#">12</a></li>
                                            <li><a href="#">13</a></li>
                                            <li><a href="#">14</a></li>
                                            <li class="active"><a href="#">15</a></li>
                                            <li><a href="#">16</a></li>
                                            <li><a href="#">17</a></li>
                                            <li class="active"><a href="#">18</a></li>
                                            <li><a href="#">19</a></li>
                                            <li><a href="#">20</a></li>
                                            <li><a href="#">21</a></li>
                                            <li class="active"><a href="#">22</a></li>
                                            <li><a href="#">23</a></li>
                                            <li><a href="#">24</a></li>
                                            <li class="active"><a href="#">25</a></li>
                                            <li><a href="#">26</a></li>
                                            <li><a href="#">27</a></li>
                                            <li><a href="#">28</a></li>
                                            <li><a href="#">29</a></li>
                                            <li><a href="#">30</a></li>
                                            <li><a href="#">31</a></li>
                                            <li><a href="#">32</a></li>
                                            <li><a href="#">33</a></li>
                                            <li><a href="#">34</a></li>
                                            <li><a href="#">35</a></li>
                                            <li><a href="#">36</a></li>
                                            <li><a href="#">37</a></li>
                                            <li><a href="#">38</a></li>
                                            <li><a href="#">39</a></li>
                                            <li><a href="#">40</a></li>
                                        </ul>
                                    </div>
                                    <div class="self-number">
                                        <div class="self-ticket">
                                            <span>Your Ticket Number :</span>
                                            <ul class="self-number">
                                                <li><a href="#">12</a></li>
                                                <li><a href="#">23</a></li>
                                                <li><a href="#">24</a></li>
                                                <li><a href="#">26</a></li>
                                                <li><a href="#">31</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single Lottery area  -->
                        <!-- Single Lottery area  -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-lottery">
                                <div class="lottery-top">
                                    <span class="ticket-rate">20CD</span>
                                    <h4>Royal Jackpot</h4>
                                    <span class="win-price">Win price</span>
                                    <span class="win-money">$500k</span>
                                    <div class="buy-ticket-btn">
                                        <a class="ticket-btn" href="#">Play Now</a>
                                    </div>
                                </div>
                                <div class="auto-number">
                                    <div class="number-top">
                                        <input type="radio" id="auto-number" name="auto-number">
                                        <label for="auto-number">
                                        Auto Number Generated
                                        <span class="genreted-text">Automatically Random Number will be Generated</span>
                                        </label>
                                    </div>
                                    <div class="number-all">
                                        <ul class="number-serial">
                                            <li><a href="#">11</a></li>
                                            <li><a href="#">12</a></li>
                                            <li><a href="#">13</a></li>
                                            <li class="active"><a href="#">14</a></li>
                                            <li><a href="#">15</a></li>
                                            <li><a href="#">16</a></li>
                                            <li class="active"><a href="#">17</a></li>
                                            <li><a href="#">18</a></li>
                                            <li><a href="#">19</a></li>
                                            <li class="active"><a href="#">20</a></li>
                                            <li><a href="#">21</a></li>
                                            <li><a href="#">22</a></li>
                                            <li><a href="#">23</a></li>
                                            <li><a href="#">24</a></li>
                                            <li><a href="#">25</a></li>
                                            <li><a href="#">26</a></li>
                                            <li><a href="#">27</a></li>
                                            <li class="active"><a href="#">28</a></li>
                                            <li><a href="#">29</a></li>
                                            <li><a href="#">30</a></li>
                                            <li><a href="#">31</a></li>
                                            <li class="active"><a href="#">32</a></li>
                                            <li><a href="#">33</a></li>
                                            <li><a href="#">34</a></li>
                                            <li><a href="#">35</a></li>
                                            <li><a href="#">36</a></li>
                                            <li><a href="#">37</a></li>
                                            <li><a href="#">38</a></li>
                                            <li><a href="#">39</a></li>
                                            <li><a href="#">40</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="manual-number">
                                    <div class="number-top">
                                        <input type="radio" id="manuals-num" name="auto-number">
                                        <label for="manuals-num">
                                        Manual Number Selected
                                        <span class="genreted-text">Type 5 Number Selected Manually</span>
                                        </label>
                                    </div>
                                    <div class="number-all">
                                        <ul class="number-serial">
                                            <li><a href="#">11</a></li>
                                            <li class="active"><a href="#">12</a></li>
                                            <li><a href="#">13</a></li>
                                            <li><a href="#">14</a></li>
                                            <li class="active"><a href="#">15</a></li>
                                            <li><a href="#">16</a></li>
                                            <li><a href="#">17</a></li>
                                            <li class="active"><a href="#">18</a></li>
                                            <li><a href="#">19</a></li>
                                            <li><a href="#">20</a></li>
                                            <li><a href="#">21</a></li>
                                            <li class="active"><a href="#">22</a></li>
                                            <li><a href="#">23</a></li>
                                            <li><a href="#">24</a></li>
                                            <li class="active"><a href="#">25</a></li>
                                            <li><a href="#">26</a></li>
                                            <li><a href="#">27</a></li>
                                            <li><a href="#">28</a></li>
                                            <li><a href="#">29</a></li>
                                            <li><a href="#">30</a></li>
                                            <li><a href="#">31</a></li>
                                            <li><a href="#">32</a></li>
                                            <li><a href="#">33</a></li>
                                            <li><a href="#">34</a></li>
                                            <li><a href="#">35</a></li>
                                            <li><a href="#">36</a></li>
                                            <li><a href="#">37</a></li>
                                            <li><a href="#">38</a></li>
                                            <li><a href="#">39</a></li>
                                            <li><a href="#">40</a></li>
                                        </ul>
                                    </div>
                                    <div class="self-number">
                                        <div class="self-ticket">
                                            <span>Your Ticket Number :</span>
                                            <ul class="self-number">
                                                <li><a href="#">12</a></li>
                                                <li><a href="#">23</a></li>
                                                <li><a href="#">24</a></li>
                                                <li><a href="#">26</a></li>
                                                <li><a href="#">31</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single Lottery area  -->
                        <!-- Single Lottery area  -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-lottery">
                                <div class="lottery-top">
                                    <span class="ticket-rate">20CD</span>
                                    <h4>London Jackpot</h4>
                                    <span class="win-price">Win price</span>
                                    <span class="win-money">$1000k</span>
                                    <div class="buy-ticket-btn">
                                        <a class="ticket-btn" href="#">Play Now</a>
                                    </div>
                                </div>
                                <div class="auto-number">
                                    <div class="number-top">
                                        <input type="radio" id="auto-nums" name="auto-nums">
                                        <label for="auto-nums">
                                        Auto Number Generated
                                        <span class="genreted-text">Automatically Random Number will be Generated</span>
                                        </label>
                                    </div>
                                    <div class="number-all">
                                        <ul class="number-serial">
                                            <li><a href="#">11</a></li>
                                            <li><a href="#">12</a></li>
                                            <li><a href="#">13</a></li>
                                            <li class="active"><a href="#">14</a></li>
                                            <li><a href="#">15</a></li>
                                            <li><a href="#">16</a></li>
                                            <li class="active"><a href="#">17</a></li>
                                            <li><a href="#">18</a></li>
                                            <li><a href="#">19</a></li>
                                            <li class="active"><a href="#">20</a></li>
                                            <li><a href="#">21</a></li>
                                            <li><a href="#">22</a></li>
                                            <li><a href="#">23</a></li>
                                            <li><a href="#">24</a></li>
                                            <li><a href="#">25</a></li>
                                            <li><a href="#">26</a></li>
                                            <li><a href="#">27</a></li>
                                            <li class="active"><a href="#">28</a></li>
                                            <li><a href="#">29</a></li>
                                            <li><a href="#">30</a></li>
                                            <li><a href="#">31</a></li>
                                            <li class="active"><a href="#">32</a></li>
                                            <li><a href="#">33</a></li>
                                            <li><a href="#">34</a></li>
                                            <li><a href="#">35</a></li>
                                            <li><a href="#">36</a></li>
                                            <li><a href="#">37</a></li>
                                            <li><a href="#">38</a></li>
                                            <li><a href="#">39</a></li>
                                            <li><a href="#">40</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="manual-number">
                                    <div class="number-top">
                                        <input type="radio" id="manual-nums" name="auto-nums">
                                        <label for="manual-nums">
                                        Manual Number Selected
                                        <span class="genreted-text">Type 5 Number Selected Manually</span>
                                        </label>
                                    </div>
                                    <div class="number-all">
                                        <ul class="number-serial">
                                            <li><a href="#">11</a></li>
                                            <li class="active"><a href="#">12</a></li>
                                            <li><a href="#">13</a></li>
                                            <li><a href="#">14</a></li>
                                            <li class="active"><a href="#">15</a></li>
                                            <li><a href="#">16</a></li>
                                            <li><a href="#">17</a></li>
                                            <li class="active"><a href="#">18</a></li>
                                            <li><a href="#">19</a></li>
                                            <li><a href="#">20</a></li>
                                            <li><a href="#">21</a></li>
                                            <li class="active"><a href="#">22</a></li>
                                            <li><a href="#">23</a></li>
                                            <li><a href="#">24</a></li>
                                            <li class="active"><a href="#">25</a></li>
                                            <li><a href="#">26</a></li>
                                            <li><a href="#">27</a></li>
                                            <li><a href="#">28</a></li>
                                            <li><a href="#">29</a></li>
                                            <li><a href="#">30</a></li>
                                            <li><a href="#">31</a></li>
                                            <li><a href="#">32</a></li>
                                            <li><a href="#">33</a></li>
                                            <li><a href="#">34</a></li>
                                            <li><a href="#">35</a></li>
                                            <li><a href="#">36</a></li>
                                            <li><a href="#">37</a></li>
                                            <li><a href="#">38</a></li>
                                            <li><a href="#">39</a></li>
                                            <li><a href="#">40</a></li>
                                        </ul>
                                    </div>
                                    <div class="self-number">
                                        <div class="self-ticket">
                                            <span>Your Ticket Number :</span>
                                            <ul class="self-number">
                                                <li><a href="#">12</a></li>
                                                <li><a href="#">23</a></li>
                                                <li><a href="#">24</a></li>
                                                <li><a href="#">26</a></li>
                                                <li><a href="#">31</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single Lottery area  -->
                        <!-- Single Lottery area  -->
                        <div class="hidden-lg hidden-md col-sm-6 col-xs-12">
                            <div class="single-lottery">
                                <div class="lottery-top">
                                    <span class="ticket-rate">20CD</span>
                                    <h4>London Jackpot</h4>
                                    <span class="win-price">Win price</span>
                                    <span class="win-money">$1000k</span>
                                    <div class="buy-ticket-btn">
                                        <a class="ticket-btn" href="#">Play Now</a>
                                    </div>
                                </div>
                                <div class="auto-number">
                                    <div class="number-top">
                                        <input type="radio" id="auto-numb" name="auto-numbr">
                                        <label for="auto-numb">
                                        Auto Number Generated
                                        <span class="genreted-text">Automatically Random Number will be Generated</span>
                                        </label>
                                    </div>
                                    <div class="number-all">
                                        <ul class="number-serial">
                                            <li><a href="#">11</a></li>
                                            <li><a href="#">12</a></li>
                                            <li><a href="#">13</a></li>
                                            <li class="active"><a href="#">14</a></li>
                                            <li><a href="#">15</a></li>
                                            <li><a href="#">16</a></li>
                                            <li class="active"><a href="#">17</a></li>
                                            <li><a href="#">18</a></li>
                                            <li><a href="#">19</a></li>
                                            <li class="active"><a href="#">20</a></li>
                                            <li><a href="#">21</a></li>
                                            <li><a href="#">22</a></li>
                                            <li><a href="#">23</a></li>
                                            <li><a href="#">24</a></li>
                                            <li><a href="#">25</a></li>
                                            <li><a href="#">26</a></li>
                                            <li><a href="#">27</a></li>
                                            <li class="active"><a href="#">28</a></li>
                                            <li><a href="#">29</a></li>
                                            <li><a href="#">30</a></li>
                                            <li><a href="#">31</a></li>
                                            <li class="active"><a href="#">32</a></li>
                                            <li><a href="#">33</a></li>
                                            <li><a href="#">34</a></li>
                                            <li><a href="#">35</a></li>
                                            <li><a href="#">36</a></li>
                                            <li><a href="#">37</a></li>
                                            <li><a href="#">38</a></li>
                                            <li><a href="#">39</a></li>
                                            <li><a href="#">40</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="manual-number">
                                    <div class="number-top">
                                        <input type="radio" id="manual-numes" name="auto-numbr">
                                        <label for="manual-numes">
                                        Manual Number Selected
                                        <span class="genreted-text">Type 5 Number Selected Manually</span>
                                        </label>
                                    </div>
                                    <div class="number-all">
                                        <ul class="number-serial">
                                        @for($i=1;$i<=50;$i++)
                                            <li><a href="#">{{rand(10,100)}}}</a></li>
                                        @endfor
                                           
                                        </ul>
                                    </div>
                                    <div class="self-number">
                                        <div class="self-ticket">
                                            <span>Your Ticket Number :</span>
                                            <ul class="self-number">
                                                <li><a href="#">12</a></li>
                                                <li><a href="#">23</a></li>
                                                <li><a href="#">24</a></li>
                                                <li><a href="#">26</a></li>
                                                <li><a href="#">31</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single Lottery area  -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Number area -->	
		
@endsection	