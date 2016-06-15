<!DOCTYPE html>
<html>
<head>
	<title>Comments</title>
</head>
<body>
	<h3>All</h3>
	<?php
		require('includes/config.php');
		require('includes/connection.php');
		require('classes/Comment.php');
		
		$comments = Comment::all();
		foreach ($comments as $comment) {
			echo json_encode(array(
				'id' => $comment->id,
				'post_id' => $comment->post_id,
				'user_id' => $comment->user_id,
				'body' => $comment->body,
				'created_at' => $comment->created_at,
				'updated_at' => $comment->updated_at,
			));
			echo '<br>';
		}
	?>
	<h3>Find</h3>
	<?php
		$comment = Comment::find(1);
		
		echo json_encode(array(
			'id' => $comment->id,
			'post_id' => $comment->post_id,
			'user_id' => $comment->user_id,
			'body' => $comment->body,
			'created_at' => $comment->created_at,
			'updated_at' => $comment->updated_at,
		));
	?>
	<h3>Save</h3>
	<?php
		$comment = new Comment([
			'body' => 'Lorem ipsum',
			'user_id' => 1,
			'post_id' => 1,
		]);

		$comment->save();
	?>
	<h3>Update</h3>
	<?php
		$comment = Comment::find(1);

		echo json_encode(array(
			'before' => array(
				'id' => $comment->id,
				'post_id' => $comment->post_id,
				'user_id' => $comment->user_id,
				'body' => $comment->body,
				'created_at' => $comment->created_at,
				'updated_at' => $comment->updated_at,
			)
		));

		$comment->title .= 'Flurp';
		$comment->body .= 'Flurparooni';

		echo json_encode(array(
			'after' => array(
				'id' => $comment->id,
				'post_id' => $comment->post_id,
				'user_id' => $comment->user_id,
				'body' => $comment->body,
				'created_at' => $comment->created_at,
				'updated_at' => $comment->updated_at,
			)
		));

		$comment->update();
	?>
	<h3>Delete</h3>
	<?php
		Comment::find(18)->delete();
	?>
	<h3>Post</h3>
	<?php
		$post = Comment::find(1)->post();

		echo json_encode(array(
			'id' => $post->id,
			'user_id' => $post->user_id,
			'title' => $post->title,
			'body' => $post->body,
			'created_at' => $post->created_at,
			'updated_at' => $post->updated_at,
		));
	?>
	<h3>User</h3>
	<?php
		$user = Comment::find(1)->user();

		echo json_encode(array(
			'id' => $user->id,
			'name' => $user->name,
			'email' => $user->email,
			'password' => $user->password,
			'created_at' => $user->created_at,
		));
	?>
</body>
</html>