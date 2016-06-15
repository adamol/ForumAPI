<?php

interface Model
{
	public static function all();
	
	public static function find($id);

	public function save();

	public function update();

	public function delete();
}