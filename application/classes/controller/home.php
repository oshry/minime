<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Home extends Controller_Template_Site {

	public function action_index()
	{


            	$groups = DB::select('*')->from('photographs')->limit('0')->offset('3')->execute();
		$content = '';
               $count = '' ;
		foreach ($groups as $group)
		{
                      $count++;
			$content .= $group['id'].' '.$group['filename'].'<br />';
		}


		//$pagination = Pagination::factory();
             $pagination = Pagination::factory(array('items_per_page' =>3 ));

  	$results = DB::select()->from('photographs')
  			->order_by('id','ASC')
  			->limit($pagination->items_per_page)
  			->offset($pagination->offset)->execute();
        foreach ($results as $group1)
		{
                      $count++;
			$content .= $group1['id'].' '.$group1['filename'].'<br />';
		}
                $content = $content.$pagination;
           //print_r($content);
		// Assign the content to the view
		//$this->template->content = $content;
//$this->template->content = new View('pages/home');
/*<?php echo $stam ?>
and inside the controller, do:*/
$this->template->content = View::factory('pages/home')->set('home',$content );

		//$this->template->content = new View('pages/home');

	}

} // End Home Controller
