@layout('layout.main')

@section('content')

<div id="home" class="clearfix">

<div class="slider-wrapper theme-bar">
	<div id="slider" class="nivoSlider">
		<img src="{{ URL::to_asset("images/slides/1.jpg") }}" data-thumb="{{ URL::to_asset("images/slides/1.jpg") }}" alt="" />
		<a href="/news">
			<img src="{{ URL::to_asset("images/slides/2.jpg") }}" data-thumb="{{ URL::to_asset("images/slides/2.jpg") }}" alt="" title="This is an example of a caption" />
		</a>
		<img src="{{ URL::to_asset("images/slides/3.jpg") }}" data-thumb="{{ URL::to_asset("images/slides/3.jpg") }}" alt=""/>
		<img src="{{ URL::to_asset("images/slides/4.jpg") }}" data-thumb="{{ URL::to_asset("images/slides/4.jpg") }}" alt="" title="#htmlcaption" />
	</div>
	<div id="htmlcaption" class="nivo-html-caption">
		<strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>. 
	</div>
</div>


<div id="content" class="homecontent clearfix">
	<div id="page" class="bigger">
		<div id="feed-item">
			<div class="item-image"></div>
			<div class="item-content"></div>
		</div>
	</div>
	<div id="sidebar" class="smaller"></div>
</div>

</div>
@endsection