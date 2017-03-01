<?php

namespace App\Model;

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

    	//Video not support
    	if(Globalval::getVal('video_support') == false) {
    		$pmenus = $pmenus->where('action', '!=', 'videoreal');
    	}

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

    	$reqars = explode('/', $request_path);
    	$allreqar = null;
    	$rel_requests = array();
    	foreach ($reqars as $reqar) {
    		$allreqar == null ? $allreqar = $reqar : $allreqar .= '/'.$reqar;
    		array_push($rel_requests, $allreqar);
    	}

    	foreach ($rel_requests as $rel_request) {
    		if ($pmenu->action == $rel_request) {
    			$pmenu->isactive = true;
    		}
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

    		if (strstr($request_path, $ele->action) !== false) {
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
