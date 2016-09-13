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
    							->where('inode', '!=', 0)
    							->orderby('inode', 'asc')
    							->get();

    	foreach ($pmenus as $pmenu) {
    		$this->isChildPush($pmenu, $request_path);
    	}

    	//dd($this->menus);
    	return $this->menus;
    }

    protected function isChildPush($pmenu, $request_path = null) {

    	isset($this->menus[$pmenu->pnode])
    		|| $this->menus[$pmenu->pnode] = array();

    	array_push($this->menus[$pmenu->pnode], $pmenu);
    	//$pmenu = end($this->menus[$pmenu->pnode]);

    	isset($pmenu->pmenu)
    		&& isset($pmenu->action)
    		&& $pmenu->action = $pmenu->pmenu->action.'/'.$pmenu->action;
    	
    	$pmenu->action == 'areactrl'
    		&& $this->getAreactrlMenus($pmenu, $request_path);

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
   
    //Add areas to menu
    private function getAreactrlMenus($pmenu, $request_path) {

    	isset($this->menus[$pmenu->inode])
	    	|| $this->menus[$pmenu->inode] = array();

    	foreach (Area::all() as $area) {
    		$ele = new \stdClass();
    		$ele->name = $area->name;
    		$ele->action = $pmenu->action.'/'.$area->sn;
    		$ele->pnode = $pmenu->inode;
    		$ele->inode = $area->sn;
    		$ele->img = ConsoleMenu::where('name', $area->type)->get()[0]->img;

    		if ($ele->action == $request_path) {
    			$ele->pmenu = $pmenu;
    			$ele->isactive = true;
    			$ele->pmenu->isactive = true;
    		}

    		array_push($this->menus[$pmenu->inode], $ele);
    	}

        if ( $pmenu->action == $request_path ) {
            $this->menus[$pmenu->inode][0]->isactive = true;
        }
    }
}
