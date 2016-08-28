<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsoleMenu extends Model
{
	protected $menus;

	protected $fillable = [
			'name', 'action', 'pnode', 'inode', 'haschild', 'img'
	];

    public function getConsleMenuLists($request_path = null) {

    	$this->menus = array();

    	$pmenus = ConsoleMenu::where('pnode', 0)
    							->orderby('inode', 'asc')
    							->get();

    	foreach ($pmenus as $pmenu) {
    		$this->isChildPush($pmenu, $request_path);
    	}

    	return $this->menus;
    }

    protected function isChildPush($pmenu, $request_path = null) {

    	isset($this->menus[$pmenu->pnode])
    		|| $this->menus[$pmenu->pnode] = array();

    	array_push($this->menus[$pmenu->pnode], $pmenu);
    	//$pmenu = end($this->menus[$pmenu->pnode]);

    	isset($pmenu->pmenu)
    		&& $pmenu->action = $pmenu->pmenu->action.'/'.$pmenu->action;

    	if ($pmenu->action == $request_path) {
    		$tmenu = $pmenu;
    		do {
    			$tmenu->isactive = true;
    			$tmenu = $tmenu->pmenu;
    		} while (isset($tmenu));
    	}

    	$imenus = ConsoleMenu::where('pnode', $pmenu->inode)
					    		->orderby('inode', 'asc')
					    		->get();

    	if (count($imenus) > 0) {
    		$pmenu->haschild = 1;

	    	foreach ($imenus as $imenu) {
	    		$imenu->pmenu = $pmenu;
		    	$this->isChildPush($imenu, $request_path);
	    	}
    	}
    }
}
