@layout("layout.main")
<?php $maptypes = Config::get("maps.types") ?>

@section("content")
@if($map->published == 0)
	<div class="alert">
		<p>This map is awaiting moderation and is not yet viewable by everyone.</p>
	</div>
@endif
@include("maps.menu")

<ul class="nav nav-pills">
@if(Auth::check() && Auth::user()->admin)
<li class="disabled"><a href="#">Actions:</a></li>
<li>
{{ HTML::link_to_action("maps@edit", "Edit Map", array($map->id)) }}
</li>
<li>
{{ $map->featured ? HTML::link_to_action("admin@maps", "Revoke Map", array("unpublish", $map->id)) : HTML::link_to_action("admin@maps", "Approve Map", array("publish", $map->id)) }}
</li>
<li>
{{ $map->featured ? HTML::link_to_action("admin@maps", "Unfeature Map", array("unfeature", $map->id)) : HTML::link_to_action("admin@maps", "Feature Map", array("feature", $map->id)) }}
</li>
<li>
{{ $map->official ? HTML::link_to_action("admin@maps", "Make Map Unofficial", array("unofficial", $map->id)) : HTML::link_to_action("admin@maps", "Make Map Official", array("official", $map->id))}}
</li>
@elseif($is_owner)
<li class="disabled"><a href="#">Actions:</a></li>
<li>
{{ HTML::link_to_action("maps@edit", "Edit Map", array($map->id)) }}
</li>
@else
@endif
</ul>

<div id="content" class="maps">
<div class="titlebar clearfix">
	<h1>{{ e($map->title) }} {{ e($map->version) }}</h1>
</div>
	@if($is_owner === 0)
	<div class="alert">
		You have been invited to be an author of this map.
		{{ Form::open("maps/author_invite/".$map->id) }}
			{{ Form::token() }}
			{{ Form::hidden("action", "accept") }}
			<button type="submit" class="btn btn-success btn-mini"><i class="icon-ok icon-white"></i> Accept</button>
		{{ Form::close() }}
		{{ Form::open("maps/author_invite/".$map->id) }}
			{{ Form::token() }}
			{{ Form::hidden("action", "deny") }}
			<button type="submit" class="btn btn-danger btn-mini"><i class="icon-remove icon-white"></i> Deny</button>
		{{ Form::close() }}
	</div>
	@endif
	<h2>{{ e($map->title) }}</h2>
	<p>{{ e($map->summary) }}</p>
	{{ $map->description }}
	@if($map->version)
	Version: {{ e($map->version) }}<br />
	@endif
	@if($map->maptype)
	Map type: {{ array_get($maptypes, $map->maptype) }}<br />
	@endif
	@if($map->teamcount)
	Team count: {{ $map->teamcount }}<br />
	@endif
	@if($map->teamsize)
	Team size: {{ $map->teamsize }}<br />
	@endif
	<h3>Authors</h3>
	<ul>
	@foreach($authors as $author)
		{{-- These are all user objects, so feel free to do whatever --}}
		<li>{{ HTML::link("user/{$author->username}", $author->username) }}</li>
	@endforeach
	</ul>
	<h3>Downloads</h3>
	<ul>
	@foreach($map->links as $link)
		<li>{{ HTML::image($link->favicon, "favicon")." ".HTML::link($link->url, $link->url) }}</li>
	@endforeach
	</ul>
	<h2>Images</h2>
	<ul class="thumbnails">
		@forelse($map->images as $image)
			<li class="span2">
				<a href="{{ e($image->file_original) }}" class="thumbnail">{{ HTML::image($image->file_small) }}</a>
			</li>
		@empty
			<li>
				No images found!
			</li>
		@endforelse
	</ul>
	Rating: {{ $map->avg_rating }}/5
	@if(Auth::check() && !$is_owner)
	{{ Form::open("maps/rate/".$map->id) }}
		<label>{{ Form::radio("rating", 1, $rating == 1) }} 1</label>
		<label>{{ Form::radio("rating", 2, $rating == 2) }} 2</label>
		<label>{{ Form::radio("rating", 3, $rating == 3) }} 3</label>
		<label>{{ Form::radio("rating", 4, $rating == 4) }} 4</label>
		<label>{{ Form::radio("rating", 5, $rating == 5) }} 5</label>
		{{ Form::submit("Rate") }}
		{{ Form::token() }}
	{{ Form::close() }}
	@endunless
</div>
@endsection