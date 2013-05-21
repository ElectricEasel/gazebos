<?php defined('_JEXEC') or die;

$js = <<<JS
// <![CDATA[

jQuery(document).ready(function() {
	jQuery( "#accordion" ).accordion({
		heightStyle: "content"
	});

});

// ]]>
JS;

JFactory::getDocument()
	//->addScript('/templates/gazebos/js/jquery.collapsible.min.js')
	->addScriptDeclaration($js);

?>
<h2>Gazebo FAQ’s</h2>

<div id="accordion">
	<h3>What materials are used in your gazebos, and what are the advantages of each?</h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>

<h3>What can I do if I do not have a level spot in my yard or want to put my gazebo over a hillside?<span></span></h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>

<h3>I have an existing deck, concrete patio or paving bricks, do I need to purchase a floor package?<span></span></h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>

<h3>Should I wait before I apply a sealer or stain on a wood gazebo?<span></span></h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>

<h3>What should I use as a stain/sealer for the gazebos?<span></span></h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>

<h3>How long does it take, and what skills are required to assembly your gazebo kits?<span></span></h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>

<h3>Are your screens removable?<span></span></h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>

<h3>Is a building permit required?<span></span></h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>

<h3>Can I get the gazebo delivered already assembled?<span></span></h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>

<h3>Do I need a foundation?<span></span></h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>

<h3>The shingles that I want (to match my house) are not listed, can I get the gazebo with no shingles so I can install my own shingles?<span></span></h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>

<h3>How long does it take to receive my gazebo once I place an order?<span></span></h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>

<h3>Do you handle custom or special orders?<span></span></h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>

<h3>Do you offer discounts?<span></span></h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>

<h3>Other Questions or Comments?<span></span></h3>
	<div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu velit dolor. Vestibulum varius lorem sed mauris posuere non eleifend purus venenatis. Pellentesque ullamcorper cursus sagittis. Ut vel mauris sem. Aenean magna nisl, varius nec tristique vel, vestibulum quis mauris. Nullam ornare sagittis mattis. Aenean eleifend eleifend neque eget tincidunt. Sed est mi, dictum eu ultricies sed, hendrerit vitae mauris. Vestibulum id ipsum mauris, eu vulputate lectus. Sed elementum tincidunt aliquet. Proin fringilla viverra ligula quis imperdiet. Praesent eget sagittis urna. Integer sodales tristique tellus non pretium.</p>
	</div>
</div>