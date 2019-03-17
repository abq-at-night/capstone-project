<?php
namespace FamConn\FamilyConnect;
require_once("autoload.php");

/**
 * JsonObjectStorage Class
 * This class adds JsonSerializable to SplObjectStorage, allowing for the stored data to be json serialized.
 *@author Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class JsonObjectStorage extends \SplObjectStorage implements \JsonSerializable {
	public function jsonSerialize() {
		$fields = [];
		foreach($this as $object) {
			$fields[] = $object;
			$object->comments = $this[$object];
		}
		return ($fields);
	}
}