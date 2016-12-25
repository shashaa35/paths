<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{

    public function index()
    {
		$nodes=array("S","T","U","V","W","X");

    	return view("welcome",compact('nodes'));
    }
    public function check_paths(Request $request)
    {
    	$adj=array('S' => array('T'=>7,'V'=>2,'X'=>4),
    				'T'=> array('V'=>2,'X'=>1),
    				'U'=>array('S'=>2,'T'=>6),
    				'V'=>array(),
    				'X'=>array('V'=>1),
    				'W'=>array('S'=>3,'U'=>5) );
    	$src=$request->src;
    	$dest=$request->dest;
    	$this->DFS($src,$dest,$adj);
    	ksort($this->paths);
    	return json_encode(["paths"=>$this->paths,"adj"=>$adj]);
    }

    public $paths = array();
    public $total=0;
    public function DFS($src,$dest,$adj)
    {
    	$visited=array('S'=>0,'T'=>0,'U'=>0,'V'=>0,'W'=>0,'X'=>0);
    	$path=array();
    	$pathindex=0;
    	$n=0;
    	$this->calPaths($src,$dest,$visited,$path,$pathindex,$n,$adj);
    }
    public function calPaths($src,$dest,$visited,$path,$pathindex,$n,$adj)
    {
    	// Mark the current node and store it in path[]
    	$visited[$src] = 1;
    	$path[$pathindex] = $src;
    	$pathindex++;
 
    // If current vertex is same as destination, then print
    // current path[]
    if ($src == $dest)
    {
    	$this->total++;
        if(!array_key_exists($n,$this->paths))
    		$this->paths[$n]=array();
    	array_push($this->paths[$n], $path);
    }
    else // If current vertex is not destination
    {
        // Recur for all the vertices adjacent to current vertex
        foreach ($adj[$src] as $node => $value) {
        
            if (!$visited[$node])
                $this->calPaths($node,$dest, $visited, $path, $pathindex,$n+$value,$adj);
    }
 
    // Remove current vertex from path[] and mark it as unvisited
    $pathindex--;
    $visited[$src] = 0;
    }
}
}

