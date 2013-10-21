<?php
use Robbo\Presenter\PresentableInterface;

class GalleryImageLike extends Eloquent implements PresentableInterface {

	 protected $softDelete = true;
	 protected $table = "gallery_images_likes";
	/**
	 * Get the blog's author.
	 *
	 * @return User
	 */
	public function image()
	{
		return $this->belongsTo('GalleryImages', 'gallery_images_id');
	}

    /**
     * Get the date the blog was created.
     *
     * @param \Carbon|null $date
     * @return string
     */
    public function date($date=null)
    {
        if(is_null($date)) {
            $date = $this->created_at;
        }

        return String::date($date);
    }

	/**
	 * Returns the date of the blog post creation,
	 * on a good and more readable format :)
	 *
	 * @return string
	 */
	public function created_at()
	{
		return $this->date($this->created_at);
	}

	/**
	 * Returns the date of the blog post last update,
	 * on a good and more readable format :)
	 *
	 * @return string
	 */
	public function updated_at()
	{
        return $this->date($this->updated_at);
	}

    public function getPresenter()
    {
        return new PostPresenter($this);
    }

}
