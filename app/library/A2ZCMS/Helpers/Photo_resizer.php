<?php
	
/**
 * Provides a very simple way to resize an image.
 *
 *
 * @example
 * 		Resizer::open( mixed $file )
 *			->resize( int $width , int $height , string 'exact, portrait, landscape, auto or crop' )
 *			->save( string 'path/to/file.jpg' , int $quality );
 *
 *		// Resize and save an image.
 * 		Resizer::open( Input::file('field_name') )
 *			->resize( 800 , 600 , 'crop' )
 *			->save( 'path/to/file.jpg' , 100 );
 *
 *		// Recompress an image.
 *		Resizer::open( 'path/to/image.jpg' )
 *			->save( 'path/to/new_image.jpg' , 60 );
 */
class Resizer {
	
	/**
	 * Store the image resource which we'll modify
	 * @var Resource
	 */
	private $image;
	
	/**
	 * Original width of the image we're modifying
	 * @var int
	 */
	private $width;
	
	/**
	 * Original height of the image we're modifying
	 * @var int
	 */
	private $height;
	
	/**
	 * Store the resource of the resized image
	 * @var Resource
	 */
	private $image_resized;
	
	/*
	*	Crop type
	*	@var string
	*/
	private $option;
	
	/*
	*	If using upload(), this is the name of the file html element
	*	@var string
	*/
	private $input;
	
	/*
	*	String of laravel validation rules
	*	@var string
	*/	
	private $rules;
	
	/*
	*	The path relative to public to where the images will be uploaded 
	*	@var string
	*/
	private $path;
	
	/*
	*	Array of image save information
	*	@var array
	*
	*/
	private $images;
	
	/*
	*	Whether or not to randomize the name -> if random will create 32 character alphanum string
	* 	Should add a custom randomize/filename callback function ..
	*	@var bool
	*/
	private $random;
	
	/*
	*	Function to be called after each image is done uploading
	*	@var function
	*/
	private $upload_callback;
	
	/*
	*	Additional arguments to be passed into the callback
	*	@var array
	*/
	private $upload_callback_args;
	
	/**
	* Whether or not this is a single file resize or an upload and resize
	*
	**/
	private $single = false;
	
	/**
	 * Instantiates the Resizer and receives the path to an image we're working with
	 * @param mixed $file The file array provided by Laravel's Input::file('field_name') or a path to a file
	 */
	function __construct( $file )
	{
		if(!empty($file)){
			$this->single = true;
			$this->image = $file;
		}
	}
	
	/**
	 * Static call, Laravel style.
	 * Returns a new Resizer object, allowing for chainable calls
	 * @param  mixed $file The file array provided by Laravel's Input::file('field_name') or a path to a file
	 * @return Resizer
	 */
	public static function open( $file = '' )
	{
		return new Resizer( $file );
	}
	
	
	/*	
	*	Uploading function 
	* @param  string $input name of the file to upload
	* @param  string $rules laravel style validation rules string
	* @param  string $path relative to /public/ to move the images if valid
	* @param  bool $random Whether or not to randomize the filename, the filename will be set to a 32 character string if true
	* @return Multup
	*/
	public function upload( $input, $rules, $path, $random = true)
	{
		/* set some properties to be used in other functions */
		$this->input  = $input;
		$this->rules  = $rules;
		$this->path = $path;
		$this->random = $random;
		
		$images = Input::file($this->input);
		
		if(!is_array($images['name'])){ 
		
			$this->image = array($this->input => $images);
			/* upload the image and pass the result to the post_upload_process function*/
			$this->post_upload_proccess($this->upload_image());
			
		} else {
			$size = $count($images['name']);
			
			for($i = 0; $i < $size; $i++){
				
				$this->image = array(
					$this->input => array(
						'name'      => $images['name'][$i],
						'type'      => $images['type'][$i],
						'tmp_name'  => $images['tmp_name'][$i],
						'error'     => $images['error'][$i],
						'size'      => $images['size'][$i]
					)
				);
				
				$this->post_upload_proccess($this->upload_image());
			}
		}
		
		return $this;
	
	}
	
	/*
	*	Upload the image
	*/
	private function upload_image(){
		
		/* validate the image */
		$validation = Validator::make( $this->image, array($this->input => $this->rules) );
		$errors = array();	
		$filename = $this->image[$this->input]['name'];
		$path = '';
		
		if($validation->fails()){
			/* use the messages object for the erros */
			$errors = $validation->errors;
		} else {
			/* get the file extension and upload the imgae */
			$ext = File::extension($filename);
			if($this->random){
				$filename = Str::random(32).'.'.$ext;
			}
			
			/* Path assumes the images are saved in the public folder... this may need to change */
			$path= 'public/'.$this->path;
			
			/* upload the file */
			$save = Input::upload($this->input, $path, $filename);

			if($save){
				/* set the path to the full public URL where the image can be accessed */
				$path = URL::to($this->path.$filename);
			} else {
				$errors = 'Could not save image';
			}
		}
		
		return compact('errors', 'path', 'filename');
	}
	
	/*
		Called after an image is successfully uploaded
		The function will append the vars to the images property
		If an after_upload function has been defined it will also append a variable to the array 
			named callback_result
			
		@var array 
			path
			resize ->this will be empty as the resize has not yet occurred
			filename -> the name of the successfully uploaded file
		@return void
	*/
	private function post_upload_proccess( $save )
	{
		
		if(empty($save['errors'])){
			/* add the saved image to the images array thing */
			$args =  array('path' => $this->path.$save['filename'], 'filename' => $save['filename'], 'resized' => '');
			
			if(is_callable($this->upload_callback)){
				if(!empty($this->upload_callback_args) && is_array($this->upload_callback_args)){
					$args = array_merge($this->upload_callback_args,$args);
				}
			
				$args['callback_result']  = call_user_func( $this->upload_callback, $args);
			}
			$this->images[] = $args;
			
		} else{
			$this->errors[] = $save;
		}
	}
	
	/*
		Set the callback function to be called after each image is done uploading
		@var mixed anonymous function or string name of function
	*/
	public function after_upload( $cb, $args = '')
	{
		if(is_callable($cb)){
			$this->upload_callback = $cb;
			$this->upload_callback_args = $args;
		} else {
			/* some sort of error... */
		}
		return $this;
	}
	
	/*
		Return any errors that occured
		@return array
	*/
	public function errors()
	{
		return $this->errors;
	}
	
	/**
	 * Resizes and/or crops an image
	 * @param  int    $new_width  The width of the image
	 * @param  int    $new_height The height of the image
	 * @param  string $option     Either exact, portrait, landscape, auto or crop.
	 * @return [type]
	 */
	//public function resize( $new_width , $new_height , $option = 'auto' )
	public function resize( $sizes )
	{
		if(is_array($sizes)){
			//width, height, option, path, quality
			$resized = array();
			
			$j = 0;
			foreach($sizes as $size){
			
				$this->new_width = $size[0]; //$new_width;
				$this->new_height = $size[1]; //$new_height;
				$this->option = $size[2];
				
				if($this->single){
					$this->resize_single( $this->image );
					
					$resized[$j] = $this->write( $size[3], $size[4], $this->image_resized );
					
				} else{
					if(!empty($this->images)){
						//loop through each filepath for the uploaded images
						$count = count($this->images);
						for($i = 0; $i <  $count; $i++){
							$this->resize_single( 'public/'.$this->images[$i]['path']);
							$this->images[$i]['resized'][$j] = $this->write( $size[3].$this->images[$i]['filename'], $size[4], $this->image_resized );
						}
						/* clear out the resized image and change it to a string to let the save function know to look for multiple resized resources */
					}
				}
				
				$j++;
			}
		}
		if($this->single){
			return $resized;
		} else {
			return $this->images;
		}
	}
	
	/*
		This was the bulk of the old resize function, moved here to allow for it to be called in a loop
		@var mixed resource/ path to image
	*/
	private function resize_single( $image )
	{
		
		$this->image = $this->open_image( $image );
		
		$this->width  = imagesx( $this->image );
		$this->height = imagesy( $this->image );
	
		// Get optimal width and height - based on $option.
		$option_array = $this->get_dimensions( $this->new_width , $this->new_height , $this->option );
		
		$optimal_width	= $option_array['optimal_width'];
		$optimal_height	= $option_array['optimal_height'];
		
		// Resample - create image canvas of x, y size.
		$this->image_resized = imagecreatetruecolor( $optimal_width , $optimal_height );
		
		// Retain transparency for PNG and GIF files.
		imagecolortransparent( $this->image_resized , imagecolorallocatealpha( $this->image_resized , 255 , 255 , 255 , 127 ) );
		imagealphablending( $this->image_resized , false );
		imagesavealpha( $this->image_resized , true );
		
		// Create the new image.
		imagecopyresampled( $this->image_resized , $this->image , 0 , 0 , 0 , 0 , $optimal_width , $optimal_height , $this->width , $this->height );
		
		// if option is 'crop' or 'fit', then crop too
		if ( $this->option == 'crop' || $this->option == 'fit' ) {
			$this->crop( $optimal_width , $optimal_height , $this->new_width , $this->new_height );
		}
		
		// Return $this to allow calls to be chained
		return $this;
	}
	
	/*
		
	*/
	private function write( $save_path, $image_quality, $image )
	{
		// Get extension of the output file
		$extension = strtolower( File::extension($save_path) );
		
		// Create and save an image based on it's extension
		switch( $extension )
		{
			case 'jpg':
			case 'jpeg':
				if ( imagetypes() & IMG_JPG ) {
					imagejpeg( $image , $save_path , $image_quality );
				}
				break;
				
			case 'gif':
				if ( imagetypes() & IMG_GIF ) {
					imagegif( $image , $save_path );
				}
				break;
				
			case 'png':
				// Scale quality from 0-100 to 0-9
				$scale_quality = round( ($image_quality/100) * 9 );
				
				// Invert quality setting as 0 is best, not 9
				$invert_scale_quality = 9 - $scale_quality;
				
				if ( imagetypes() & IMG_PNG ) {
					imagepng( $image , $save_path , $invert_scale_quality );
				}
				break;
				
			default:
				return false;
				break;
		}
		
		// Remove the resource for the resized image
		imagedestroy( $image );
		
		return true;
	}
	
	/**
	 * Open a file, detect its mime-type and create an image resrource from it.
	 * @param  array $file Attributes of file from the $_FILES array
	 * @return mixed
	 */
	private function open_image( $file )
	{
		
		// If $file isn't an array, we'll turn it into one
		if ( !is_array($file) ) {
			$file = array(
				'type'		=> File::mime( strtolower(File::extension($file)) ),
				'tmp_name'	=> $file
			);
		}
		
		$mime = $file['type'];
		$file_path = $file['tmp_name'];
		
		switch ( $mime )
		{
			case 'image/pjpeg': // IE6
			case File::mime('jpg'):	$img = @imagecreatefromjpeg( $file_path );	break;
			case File::mime('gif'):	$img = @imagecreatefromgif( $file_path );	break;
			case File::mime('png'):	$img = @imagecreatefrompng( $file_path );	break;
			default:				$img = false;								break;
		}
		
		return $img;
	}
	
	/**
	 * Return the image dimentions based on the option that was chosen.
	 * @param  int    $new_width  The width of the image
	 * @param  int    $new_height The height of the image
	 * @param  string $option     Either exact, portrait, landscape, auto or crop.
	 * @return array
	 */
	private function get_dimensions( $new_width , $new_height , $option )
	{
		switch ( $option )
		{
			case 'exact':
				$optimal_width	= $new_width;
				$optimal_height	= $new_height;
				break;
			case 'portrait':
				$optimal_width	= $this->get_size_by_fixed_height( $new_height );
				$optimal_height	= $new_height;
				break;
			case 'landscape':
				$optimal_width	= $new_width;
				$optimal_height	= $this->get_size_by_fixed_width( $new_width );
				break;
			case 'auto':
				$option_array	= $this->get_size_by_auto( $new_width , $new_height );
				$optimal_width	= $option_array['optimal_width'];
				$optimal_height	= $option_array['optimal_height'];
				break;
			case 'fit':
				$option_array	= $this->get_size_by_fit( $new_width , $new_height );
				$optimal_width	= $option_array['optimal_width'];
				$optimal_height	= $option_array['optimal_height'];
				break;
			case 'crop':
				$option_array	= $this->get_optimal_crop( $new_width , $new_height );
				$optimal_width	= $option_array['optimal_width'];
				$optimal_height	= $option_array['optimal_height'];
				break;
		}
		
		return array(
			'optimal_width'		=> $optimal_width,
			'optimal_height'	=> $optimal_height
		);
	}
	
	/**
	 * Returns the width based on the image height
	 * @param  int    $new_height The height of the image
	 * @return int
	 */
	private function get_size_by_fixed_height( $new_height )
	{
		$ratio		= $this->width / $this->height;
		$new_width	= $new_height * $ratio;
		
		return $new_width;
	}
	
	/**
	 * Returns the height based on the image width
	 * @param  int    $new_width The width of the image
	 * @return int
	 */
	private function get_size_by_fixed_width( $new_width )
	{
		$ratio		= $this->height / $this->width;
		$new_height	= $new_width * $ratio;
		
		return $new_height;
	}
	
	/**
	 * Checks to see if an image is portrait or landscape and resizes accordingly.
	 * @param  int    $new_width  The width of the image
	 * @param  int    $new_height The height of the image
	 * @return array
	 */
	private function get_size_by_auto( $new_width , $new_height )
	{
		// Image to be resized is wider (landscape)
		if ( $this->height < $this->width )
		{
			$optimal_width	= $new_width;
			$optimal_height	= $this->get_size_by_fixed_width( $new_width );
		}
		// Image to be resized is taller (portrait)
		else if ( $this->height > $this->width )
		{
			$optimal_width	= $this->get_size_by_fixed_height( $new_height );
			$optimal_height	= $new_height;
		}
		// Image to be resizerd is a square
		else
		{
			if ( $new_height < $new_width )
			{
				$optimal_width	= $new_width;
				$optimal_height	= $this->get_size_by_fixed_width( $new_width );
			}
			else if ( $new_height > $new_width )
			{
				$optimal_width	= $this->get_size_by_fixed_height( $new_height );
				$optimal_height	= $new_height;
			}
			else
			{
				// Sqaure being resized to a square
				$optimal_width	= $new_width;
				$optimal_height	= $new_height;
			}
		}
		
		return array(
			'optimal_width'		=> $optimal_width,
			'optimal_height'	=> $optimal_height
		);
	}
	
	/**
	 * Resizes an image so it fits entirely inside the given dimensions.
	 * @param  int    $new_width  The width of the image
	 * @param  int    $new_height The height of the image
	 * @return array
	 */
	private function get_size_by_fit( $new_width , $new_height )
	{
		
		$height_ratio	= $this->height / $new_height;
		$width_ratio	= $this->width /  $new_width;
		
		$max = max( $height_ratio , $width_ratio );
		
		return array(
			'optimal_width'		=> $this->width / $max,
			'optimal_height'	=> $this->height / $max,
		);
	}
	
	/**
	 * Attempts to find the best way to crop. Whether crop is based on the
	 * image being portrait or landscape.
	 * @param  int    $new_width  The width of the image
	 * @param  int    $new_height The height of the image
	 * @return array
	 */
	private function get_optimal_crop( $new_width , $new_height )
	{
		$height_ratio	= $this->height / $new_height;
		$width_ratio	= $this->width /  $new_width;
		
		if ( $height_ratio < $width_ratio ) {
			$optimal_ratio = $height_ratio;
		} else {
			$optimal_ratio = $width_ratio;
		}
		
		$optimal_height	= $this->height / $optimal_ratio;
		$optimal_width	= $this->width  / $optimal_ratio;
		
		return array(
			'optimal_width'		=> $optimal_width,
			'optimal_height'	=> $optimal_height
		);
	}
	
	/**
	 * Crops an image from its center
	 * @param  int    $optimal_width  The width of the image
	 * @param  int    $optimal_height The height of the image
	 * @param  int    $new_width      The new width
	 * @param  int    $new_height     The new height
	 * @return true
	 */
	private function crop( $optimal_width , $optimal_height , $new_width , $new_height )
	{
		// Find center - this will be used for the crop
		$crop_start_x = ( $optimal_width  / 2 ) - ( $new_width  / 2 );
		$crop_start_y = ( $optimal_height / 2 ) - ( $new_height / 2 );
		
		$crop = $this->image_resized;
		
		$dest_offset_x	= max( 0, -$crop_start_x );
		$dest_offset_y	= max( 0, -$crop_start_y );
		$crop_start_x	= max( 0, $crop_start_x );
		$crop_start_y	= max( 0, $crop_start_y );
		$dest_width		= min( $optimal_width, $new_width );
		$dest_height	= min( $optimal_height, $new_height );
		
		// Now crop from center to exact requested size
		$this->image_resized = imagecreatetruecolor( $new_width , $new_height );
		
		imagealphablending( $crop , true );
		imagealphablending( $this->image_resized , false );
		imagesavealpha( $this->image_resized , true );
		
		imagefilledrectangle( $this->image_resized , 0 , 0 , $new_width , $new_height,
			imagecolorallocatealpha( $this->image_resized , 255 , 255 , 255 , 127 )
		);
		
		imagecopyresampled( $this->image_resized , $crop , $dest_offset_x , $dest_offset_y , $crop_start_x , $crop_start_y , $dest_width , $dest_height , $dest_width , $dest_height );
		
		return true;
	}

}