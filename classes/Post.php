<?php


require_once('Comment.php');
require_once('Model.php');
require_once('User.php');

class Post implements Model
{
	public $title;
	public $body;
	public $user_id;

	public $id;
	public $created_at;
	public $updated_at;

	public function __construct(array $input=[])
	{
		$this->title = $input['title'];
		$this->body = $input['body'];
		$this->user_id = $input['user_id'];

		$this->id = isset($input['id']) ? $input['id'] : NULL;
		$this->created_at = isset($input['created_at']) ? $input['created_at'] : CURRENT_TIMESTAMP;
		$this->updated_at = isset($input['updated_at']) ? $input['updated_at'] : CURRENT_TIMESTAMP;
	}

	public static function all()
	{
		global $conn;

		$query = "SELECT * FROM posts ORDER BY updated_at DESC";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			$posts = array();
			while ($post = mysqli_fetch_assoc($result)) {
				$posts[] = new Post([
					'id' => $post['id'],
					'user_id' => $post['user_id'],
					'title' => $post['title'],
					'body' => $post['body'],
					'created_at' => $post['created_at'],
					'updated_at' => $post['updated_at'],
				]);
			}
			return $posts;
		}
	}
	
	public static function find($id)
	{
		global $conn;

		$query = "SELECT * FROM posts WHERE id='$id'";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			$post = mysqli_fetch_assoc($result);

			return new Post([
				'id' => $post['id'],
				'user_id' => $post['user_id'],
				'title' => $post['title'],
				'body' => $post['body'],
				'created_at' => $post['created_at'],
				'updated_at' => $post['updated_at'],
			]);
		} 

		return "No Post found with that id";
	}

	public function save()
	{
		global $conn;

		$query = "INSERT INTO posts (id, title, body, user_id, created_at, updated_at) VALUES (NULL, '$this->title', '$this->body', '$this->user_id', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

		if (mysqli_query($conn, $query)) {
			echo "Post was saved to database";
		} else {
			echo "Error description: " . mysqli_error($conn);
		}
	}

	public function update()
	{
		global $conn;
		
		$query = "UPDATE posts SET title='$this->title', body='$this->body', user_id='$this->user_id' WHERE id='$this->id'" ;

		if (mysqli_query($conn, $query)) {
			echo "Post was successfully updated!";
		} else {
			echo "Error description: " . mysqli_error($conn);
		}
	}

	public function delete()
	{
		global $conn;
		$query = "DELETE FROM posts WHERE id='$this->id'";

		if (mysqli_query($conn, $query)) {
			echo "Post was successfully deleted!";
		} else {
			echo "Error description: " . mysqli_error($conn);
		}
	}

	public function user()
	{
		global $conn;

		$query = "SELECT * FROM users WHERE id='$this->user_id'";

		$result = mysqli_query($conn, $query);
		
		if (mysqli_num_rows($result) > 0) {
			$user = mysqli_fetch_assoc($result);

			return new User([
				'id' => $user['id'],
				'name' => $user['name'],
				'email' => $user['email'],
				'password' => $user['password'],
				'created_at' => $user['created_at']
			]);
		} 

		return "No User found with that id";
	}

	public function comments()
	{
		global $conn;

		$query = "SELECT * FROM comments WHERE post_id='$this->id'";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {

			$comments = array();
			while ($comment = mysqli_fetch_assoc($result)) {
				$comments[] = new Comment([
					'id' => $comment['id'],
					'user_id' => $comment['user_id'],
					'post_id' => $comment['post_id'],
					'body' => $comment['body'],
					'created_at' => $comment['created_at'],
					'updated_at' => $comment['updated_at'],
				]);
			}
			return $comments;
		}
	}
}