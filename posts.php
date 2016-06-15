<!DOCTYPE html>
<html>
<head>
	<title>Posts</title>
</head>
<body>
	<h3>All</h3>
	<?php
		require('includes/config.php');
		require('includes/connection.php');
		require('classes/Post.php');

		$posts = Post::all();
		foreach ($posts as $post) {
			echo json_encode(array(
				'id' => $post->id,
				'user_id' => $post->user_id,
				'title' => $post->title,
				'body' => $post->body,
				'created_at' => $post->created_at,
				'updated_at' => $post->updated_at,
			));
			echo '<br>';
		}
	?>
	<h3>Find</h3>
	<?php
		$post = Post::find(1);
		echo json_encode(array(
				'id' => $post->id,
				'user_id' => $post->user_id,
				'title' => $post->title,
				'body' => $post->body,
				'created_at' => $post->created_at,
				'updated_at' => $post->updated_at,
			));
	?>
	<h3>Save</h3>
	<?php
		$post = new Post([
			'title' => 'Foobar',
			'body' => 'Lorem ipsum',
			'user_id' => 1
		]);

		$post->save();
	?>
	<h3>Update</h3>
	<?php
		$post = Post::find(8);

		echo json_encode(array(
			'before' => array(
				'id' => $post->id,
				'user_id' => $post->user_id,
				'title' => $post->title,
				'body' => $post->body,
				'created_at' => $post->created_at,
				'updated_at' => $post->updated_at,
			)
		));
		echo '<br>';

		$post->title = 'Flurp';
		$post->body = 'Flurparooni';
		$post->user_id = 1;

		echo json_encode(array(
			'after' => array(
				'id' => $post->id,
				'user_id' => $post->user_id,
				'title' => $post->title,
				'body' => $post->body,
				'created_at' => $post->created_at,
				'updated_at' => $post->updated_at,
			)
		));
		echo '<br>';
		
		$post->update();
	?>
	<h3>Delete</h3>
	<?php
		$post = Post::find(87);
		$post->delete();
	?>
	<h3>User</h3>
	<?php
		$post = Post::find(2);
		$user = $post->user();

		echo json_encode(array(
			$user->id => array(
				'name' => $user->name,
				'email' => $user->email,
				'password' => $user->password,
				'created_at' => $user->created_at,
			)
		));
	?>
	<h3>Comments</h3>
	<?php
		$post = Post::find(1);
		$comments = $post->comments(1);

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
</body>
</html>