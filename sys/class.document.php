<?php

/**
 * Canae Adoc Light document functions file
 *
 * @package canae-adoc-light
 */

class Document {
	/**
	 * Document id
	 */
	private $document_id;

	/**
	 * Document title
	 */
	private $document_title;
	
	/**
	 * Document description
	 */
	private $document_description;

	/**
	 * Document mime
	 */
	private $document_mime;

	/**
	 * Document file path
	 */
	private $document_file_path;
	
	/**
	 * Document file name
	 */
	private $document_file_name;

	function __construct($document_id, $document_title, $document_description, $document_mime, $document_file_path, $document_file_name) {
		$this->document_id = $document_id;
		$this->document_title = $document_title;
		$this->document_description = $document_description;
		$this->document_mime = $document_mime;
		$this->document_file_path = $document_file_path;
		$this->document_file_name = $document_file_name;
	}

	public function getId() {
		return $this->document_id;
	}

	public function getTitle() {
		return $this->document_title;
	}
	
	public function getDescription() {
		return $this->document_description;
	}

	public function getMime() {
		return $this->document_mime;
	}

	public function getFilePath() {
		global $adoc_app_path, $adoc_dir_separator, $adoc_app_upload_dir;
		return $adoc_app_path . $adoc_dir_separator . $adoc_app_upload_dir . $adoc_dir_separator . $this->document_file_path;
	}
	
	public function getFileName() {
		return $this->document_file_name;
	}

	/**
	 * Generates file view url
	 */
	public function getViewUrl() {
		return App::getUrl() . "/document_view.php?id=" . $this->document_id;
	}

	/**
	 * Generates file download url
	 */
	public function getDownloadUrl() {
		return App::getUrl() . "/document_download.php?id=" . $this->document_id;
	}

	/**
	 * Generates document delete url
	 */
	public function getDeleteUrl() {
		return App::getUrl() . "/document_delete.php?id=" . $this->document_id;
	}

	/**
	 * Inserts a document to the database and returns inserted document's id
	 *
	 * @param $user_name
	 * @param $user_email
	 * @param $user_password
	 *
	 * @return Inserted user's id
	 */
	public static function create($document_title, $document_description, $document_mime, $document_file_path, $document_file_name) {
		global $adoc_db, $adoc_db_prefix;
		$document_title = ($document_title);
		$document_description = ($document_description);
		$document_file_path = ($document_file_path);
		$document_file_name = ($document_file_name);
		$statement = $adoc_db->prepare("INSERT INTO " . $adoc_db_prefix . "documents (document_title, document_description, document_mime, document_file_path, document_file_name) VALUES (?, ?, ?, ?, ?)");
		$statement->bind_param("sssss", $document_title, $document_description, $document_mime, $document_file_path, $document_file_name);
		$statement->execute();
		$result_id = $adoc_db->insert_id;
		$statement->close();
		return $result_id;
	}

	/**
	 * Deletes a document from the database
	 *
	 * @requires Specified document id exists in the database
	 *
	 * @param integer $document_id Id of the user to document
	 *
	 * @return Statement execution result
	 */
	public static function _delete($document_id) {
		global $adoc_db, $adoc_db_prefix;

		$statement = $adoc_db->prepare("DELETE FROM " . $adoc_db_prefix . "documents WHERE document_id = ?");
		$statement->bind_param("i", $document_id);
		$statement->execute();
		$statement->close();

		return true;
	}

	/**
	 * Deletes a document file and calls Document::_delete
	 *
	 * @requires Specified document id exists in the database
	 *
	 * @param integer $document_id Id of the user to document
	 *
	 * @return Statement execution result
	 */
	public static function delete($document_id) {
		$d = self::retrieve($document_id);
		if (file_exists($d->getFilePath())) {
	        unlink($d->getFilePath());
	        return self::_delete($document_id);
	    } else {
	        return false;
	    }
	}

	/**
	 * Checks if there is a document with a specific id
	 *
	 * @param integer $document_id Document id to check
	 *
	 * @return boolean True if there is a document with the specified id, else false
	 */
	public static function idExists($document_id) {
		global $adoc_db, $adoc_db_prefix;
		$statement = $adoc_db->prepare("SELECT document_id FROM " . $adoc_db_prefix . "documents WHERE document_id = ? LIMIT 1");
		$statement->bind_param("i", $document_id);
		$statement->execute();
		$statement->store_result();
		if($statement->num_rows > 0) {
			return true;
		} else {
			return false;
		}
		$statement->free_result();
		$statement->close();
	}

	/**
	 * Checks if there are any uploaded files in the database
	 *
	 * @return boolean True if there are any uploaded files in the database, else false
	 */
	public static function atLeastOneExists() {
		global $adoc_db, $adoc_db_prefix;
		$statement = $adoc_db->prepare("SELECT document_id FROM " . $adoc_db_prefix . "documents");
		$statement->execute();
		$statement->store_result();
		if($statement->num_rows > 0) {
			$result = true;
		} else {
			$result = false;
		}
		$statement->close();
		return $result;
	}

	/**
	 * Retrieves all uploaded files' information from the database
	 *
	 * @requires At least one uploaded file exists in the table
	 *
	 * @return array() Array containing arrays containing uploaded file fields retrieved
	 */
	public static function getAll() {
		global $adoc_db, $adoc_db_prefix;
		$statement = $adoc_db->prepare("SELECT document_id, document_title, document_description, document_mime, document_file_path, document_file_name FROM " . $adoc_db_prefix . "documents");
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($result_file_id, $result_file_title, $result_file_description, $result_file_mime, $result_file_path, $result_file_name);
		while($statement->fetch()) {
			$rows[$result_file_id] = new Document($result_file_id, ($result_file_title), ($result_file_description), $result_file_mime, ($result_file_path), ($result_file_name));
		}
		$statement->close();
		return $rows;
	}

	/**
	 * Retrieves information of an specified document by its id
	 *
	 * @requires There is one document with the specified id in the database
	 *
	 * @param integer $id Id of the document to retrieve the information of
	 *
	 * @return Document Document with the specified id
	 */
	public static function retrieve($document_id) {
		global $adoc_db, $adoc_db_prefix;
		$statement = $adoc_db->prepare("SELECT document_id, document_title, document_description, document_mime, document_file_path, document_file_name FROM " . $adoc_db_prefix . "documents WHERE document_id = ? LIMIT 1");
		$statement->bind_param("i", $document_id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($result_file_id, $result_file_title, $result_file_description, $result_file_mime, $result_file_path, $result_file_name);
		while($statement->fetch()) {
			$row = new Document($result_file_id, ($result_file_title), ($result_file_description), $result_file_mime, ($result_file_path), ($result_file_name));
		}
		$statement->close();
		return $row;
	}
}

?>
