<?php defined('_JEXEC') or die;


/*
Array
(
    [0] => 
    [1] => gazebos
    [2] => wood
    [3] => oblong
    [4] => stratford
)
*/

$app = JFactory::getApplication();
$parts = explode('/', JUri::getInstance()->getPath());

switch ($parts[1])
{
	case 'gazebos':
		$parentName = 'Gazebos';
		$tagline = 'Simple, quiet comfort can be yours with<br/>your own handcrafted gazebo';
		break;
	case 'pergolas':
		$parentName = 'Pergolas';
		$tagline = 'A show stopping centerpiece that will enhance<br/>your home and landscape';
		break;
	case 'pavilions':
		$parentName = 'Pavilions';
		$tagline = 'The perfect backdrop to enjoy the sounds of<br/>summer, nature and the great outdoors';
		break;
	case 'three-season-gazebos':
		$parentName = 'Three Season Gazebos';
		$tagline = 'Watch the seasons unfold in the comfort,<br/>peace and serenity of your own backyard';
		break;
	case 'resources':
		$parentName = 'Resources';
		$tagline = 'Not just a piece of stunning architecture - but a<br/>place to build memories that will last a future';
		break;
	case 'about-us':
	default:
		$parentName = 'Gazebos.com';
		$tagline = 'Building the finest quality<br/>structures in the Industry since 1982';
		break;
}
/*
$view = $app->input->get('view');
$option = $app->input->get('option');

if ($option === 'com_gazebos' && $view === 'product')
{
	$tmp = array();

	$tmp[] = str_replace('-', ' ', $parts[1]);

	$title = implode(' ', array_map('ucwords', $tmp));
}
*/
?>

<div id="page-banner">
	<div class="wrap">
	<h1><?php echo isset($title) ? $title : $parentName;?></h1>
	<?php if (!isset($title)) : ?>
	<span class="tagline"><?php echo $tagline;?></span>
	<?php endif; ?>
	</div>
</div>