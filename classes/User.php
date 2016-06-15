<?php

require_once('Model.php');
require_once('User.php');
require_once('Comment.php');

class User implements Model
{
	public $name;
	public $email;
	public $password;

	public $id;
	public $created_at;

	public function __construct(array $input=[])
	{
		$this->name = $input['name'];
		$this->email = $input['email'];
		$this->password = $input['password'];

		$this->id = isset($input['id']) ? $input['id'] : NULL;
		$this->created_at = isset($input['created_at']) ? $input['created_at'] : CURRENT_TIMESTAMP;
	}

	public static function all()
	{
		global $conn;

		$query = "SELECT * FROM users ORDER BY created_at DESC";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			$users = array();
			while ($user = mysqli_fetch_assoc($result)) {
				$users[] = new User([
					'id' => $user['id'],
					'name' => $user['name'],
					'email' => $user['email'],
					'password' => $user['password'],
					'created_at' => $user['created_at'],
				]);
			}
			return $users;
		}
	}
	
	public static function find($id)
	{
		global $conn;

		$query = "SELECT * FROM users WHERE id='$id'";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			$user = mysqli_fetch_assoc($result);

			return new User([
				'id' => $user['id'],
				'name' => $user['name'],
				'email' => $user['email'],
				'password' => $user['password'],
				'created_at' => $user['created_at'],
			]);
		} 

		return "No User found with that id";
	}

	public function save()
	{
		global $conn;
		$hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

		$query = "INSERT INTO users (id, name, email, password, created_at) VALUES (NULL, '$this->name', '$this->email', '$hashed_password', CURRENT_TIMESTAMP)";

		if (mysqli_query($conn, $query)) {
			echo "User was saved to database";
		} else {
			echo "Error description: " . mysqli_error($conn);
		}
	}

	public function update()
	{
		global $conn;
		$query = "UPDATE users SET password='$this->password' WHERE id='$id'" ;

		if (mysqli_query($conn, $query)) {
			echo "User was successfully updated!";
		} else {
			echo "Error description: " . mysqli_error($conn);
		}
	}

	public function delete()
	{
		global $conn;
		$query = "DELETE FROM users WHERE id='$this->id'";

		if (mysqli_query($conn, $query)) {
			echo "User was successfully deleted!";
		} else {
			echo "Error description: " . mysqli_error($conn);
		}
	}

	public function posts()
	{
		global $conn;

		$query = "SELECT * FROM posts WHERE user_id='$this->id'";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			$posts = array();
			while ($post = mysqli_fetch_assoc($result)) {
				echo 'found post, creating object';
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

	public function login()
	{
		global $conn;

		$query = "SELECT * FROM users WHERE name='$this->name'";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				if (password_verify($this->password, $row['password'])) {
					echo "Password match, welcome " . $this->name;
					session_start();
					$_SESSION['name'] = $row['name'];
					$_SESSION['id'] = $row['id'];
				} else {
					echo "Password does not match";
				}
			}
		} else {
			echo "No user by that name exists in database";
		}

	}
}