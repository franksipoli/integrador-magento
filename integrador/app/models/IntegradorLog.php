<?php

use Illuminate\Database\Eloquent\Model;

class IntegradorLog extends Model {
	private $id;
	protected $table = 'integrador_log';
	protected $primaryKey = "id";
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
}