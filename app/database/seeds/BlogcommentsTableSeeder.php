<?php

class BlogcommentsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('blogcomments')->truncate();

		$user = User::where('username','=','user')->first()->id;
		$blog = Blog::find(1)->id;
		
		$blogcomments = array(
					array(
							    'blog_id' => $blog, 'user_id' => $user, 
								'body'=> 'Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. 
								Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare 
								quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula 
								quarta decima et quinta decima.',
								'created_at' => new DateTime,
							    'updated_at' => new DateTime,),
		);
		// Uncomment the below to run the seeder
		 DB::table('blog_comments')->insert($blogcomments);
	}

}
