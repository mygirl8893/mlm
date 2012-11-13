@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content" class="edit">
<div class="titlebar"><h2>Editing page <b>{{$page->title}}</b></h2></div>
{{ Form::open(null, 'POST', array('class' => 'form')) }}
	{{ Form::token()}}
	{{ Form::field("text", "title", "", array(Input::old("title", $page->title), array('class' => 'title', 'autocomplete' => 'off', 'placeholder' => 'Page Title')), array('error' => $errors->first('title'))) }}
	{{ Form::field("text", "slug", "Slug", array(Input::old("slug", $page->url_slug), array('class' => 'subtitle')), array("help" => "The page's URL. You don't need to put the whole URL just the slug, example: majorleaguemining.net/[Slug]", 'error' => $errors->first('slug'))) }}
	{{ Form::field("wysiwyg", "data", "Content", array(Input::old("data", $page->data), array('class' => 'input-xxlarge')), array('error' => $errors->first('data'))) }}
	{{ Form::actions(array(Form::submit("Save", array("class" => "btn btn-primary"))," ",HTML::link_to_action("admin@pages", "Cancel",array(), array("class" => "btn") ))) }}
{{ Form::close() }}
</div>
@endsection