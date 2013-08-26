<?php
ignore_user_abort(true);

$payload = json_decode(stripslashes($_POST['payload']));

if ($payload->repository->name === 'gazebos' && $payload->ref === 'refs/heads/master')
{
	$dir = '/home/gaze/public_html/';
	$result = shell_exec("cd {$dir}; /usr/local/bin/git pull origin master");

	mail('don@electriceasel.com', "Github Webhooks: {$payload->repository->name}@{$payload->ref}", $result);
}
