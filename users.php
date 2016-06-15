<!DOCTYPE html>
<html>
<head>
	<title>Users</title>
</head>
<body>
	<h3>All</h3>
	<?php
		require('includes/config.php');
		require('includes/connection.php');
		require('classes/User.php');
		
		$users = User::all();
		foreach ($users as $user) {
			echo json_encode(array(
			'id' => $user->id,
			'name' => $user->name,
			'email' => $user->email,
			'password' => $user->password,
			'created_at' => $user->created_at,
		));
			echo '<br>';
		}
	?>
	<h3>Find</h3>
	<?php
		$user = User::find(1);
		
		echo json_encode(array(
			'id' => $user->id,
			'name' => $user->name,
			'email' => $user->email,
			'password' => $user->password,
			'created_at' => $user->created_at,
		));
	?>
	<h3>Save</h3>
	<?php
		$user = new User([
			'name' => 'test',
			'email' => 'hurr@durr.com',
			'password' => 'password',
		]);

		$user->save();
	?>
	<h3>Update</h3>
	<?php
		$user = User::find(1);

		echo json_encode(array(
			'before' => array(
				'id' => $user->id,
				'name' => $user->name,
				'email' => $user->email,
				'password' => $user->password,
				'created_at' => $user->created_at,
			)
		));
		echo '<br>';

		$user->name .= 'foo';

		echo json_encode(array(
			'after' => array(
				'id' => $user->id,
				'name' => $user->name,
				'email' => $user->email,
				'password' => $user->password,
				'created_at' => $user->created_at,
			)
		));
		echo '<br>';

		$user->update();
	?>
	<h3>Delete</h3>
	<?php
		$user = User::find(10)->delete();
	?>
	<h3>Posts</h3>
	<?php
		$user = User::find(1);
		$posts = $user->posts();

		foreach ($posts as $post) {
			echo json_encode(array(
				$post->id => array(
					'user_id' => $post->user_id,
					'title' => $post->title,
					'body' => $post->body,
					'created_at' => $post->created_at,
					'updated_at' => $post->updated_at,
				)
			));
			echo '<br>';
		}
	?>
	<h3>Comments</h3>
	<?php
		$user = User::find(1);
		$comments = $user->comments();

		foreach ($comments as $comment) {
			echo json_encode(array(
				$comment->id => array(
					'user_id' => $comment->user_id,
					'post_id' => $comment->post_id,
					'body' => $comment->body,
					'created_at' => $comment->created_at,
					'updated_at' => $comment->updated_at,
				)
			));
			echo '<br>';
		}
	?>
	<h3>Login</h3>
	<?php
	$user = new User([
		'name' => 'adam',
		'email' => 'adamol1992@gmail.com',
		'password' => 'password',
	]);

	$user->login();
	?>
</body>
</html>