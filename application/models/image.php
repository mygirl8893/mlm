<?php

class Image extends Eloquent {
	public static $timestamps = false;

	/* Relationships */
	public function maps() {
		$this->has_many_and_belongs_to("Map", "map_images");
	}


	/*
	 * Method to easily create new Image elements
	 *
	 * Arguemnts array must have:
	 * file - the uploaded file (from Input::file("name")) DOES NOT HANDLE MULTIPLE FILES
	 * filename - filename to be saved in database
	 * type - type, eg. upload for manually uploaded files
	 */
	public static function create($arguments) {
		$handle = new upload($arguments["file"]);
		if($handle->uploaded) {
			$extension = $handle->image_src_type ?: $handle->file_src_name_ext;
			$newobj = parent::create(array("filename" => $arguments["filename"], "type" => $arguments["type"], "ext" => $extension));
			$localname = md5($newobj->id);
			$newobj->file = "{$localname}";
			$newobj->save();

			// Original
			$handle->file_new_name_body = $localname;
			$handle->file_new_name_ext = $extension;
			$handle->file_max_size = 1572864; // IN BYTES, this is 1,5M
			$handle->process(path("public")."images/uploads/o/");
			if(!$handle->processed) {
				Log::warn($handle->log);
			}
			// Large (1280x?, cropped)
			$handle->file_new_name_body = $localname;
			$handle->image_resize = true;
			$handle->image_ratio_y = true;
			$handle->image_x = 1280;
			$handle->image_convert = 'jpg';
			$handle->process(path("public")."images/uploads/l/");
			if(!$handle->processed) {
				Log::warn($handle->log);
			}
			// Medium (854x480, cropped)
			$handle->file_new_name_body = $localname;
			$handle->image_resize = true;
			$handle->image_ratio_crop = true;
			$handle->image_x = 854;
			$handle->image_y = 480;
			$handle->image_convert = 'jpg';
			$handle->process(path("public")."images/uploads/m/");
			if(!$handle->processed) {
				Log::warn($handle->log);
			}
			// Small (424x240, upto)
			$handle->file_new_name_body = $localname;
			$handle->image_resize = true;
			$handle->image_ratio = true;
			$handle->image_x = 426;
			$handle->image_y = 240;
			$handle->image_convert = 'jpg';
			$handle->process(path("public")."images/uploads/s/");
			if(!$handle->processed) {
				Log::warn($handle->log);
			}

			return $newobj;
		} else {
			return null;
		}
	}
	/*
	 * Following are also accessible as $image->file_{size}, eg $image->file_original
	 */
	public function get_file_original() {
		return "/images/uploads/o/{$this->file}.{$this->ext}";
	}
	public function get_file_large() {
		return "/images/uploads/l/{$this->file}.jpg";
	}
	public function get_file_medium() {
		return "/images/uploads/m/{$this->file}.jpg";
	}
	public function get_file_small() {
		return "/images/uploads/s/{$this->file}.jpg";
	}

	public function to_array() {
		$array = parent::to_array();
		$array["file_small"] = $this->file_small;
		$array["file_medium"] = $this->file_medium;
		$array["file_large"] = $this->file_large;
		$array["file_original"] = $this->file_original;
		return $array;
	}
}