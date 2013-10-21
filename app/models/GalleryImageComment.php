<?php

use Robbo\Presenter\PresentableInterface;

class GalleryImageComment extends Eloquent implements PresentableInterface{

	protected $softDelete = true;
	protected $table = "gallery_images_comments";
/**
	 * Deletes a blog post and all
	 * the associated comments.
	 *
	 * @return bool
	 */
	public function delete()
	{
		// Delete the post
		return parent::delete();
	}
	
	 /* 
	 *//**
	 * Get the comment's content.
	 *
	 * @return string
	 */
	public function content()
	{
		return nl2br($this->content);
	}
	/**
	 * Get the comment's author.
	 *
	 * @return User
	 */
	public function image()
	{
		return $this->belongsTo('GalleryImages', 'gallery_images_id');
	}

	/**
	 * Get the comment's author.
	 *
	 * @return User
	 */
	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}
    /**
     * Get the date the post was created.
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
        return new CommentPresenter($this);
    }
}
