<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Relations;

class HomeController extends Controller
{
	//global variable of class which contains all the paths from src->dest
    public $paths = array();

    public function index()
    {
    	$relations_controller = new Relations;

		$nodes=$relations_controller->get();

    	return view("welcome",compact('nodes'));
    }

    //this function returns all the paths..
    public function check_paths(Request $request)
    {

    	$relations_controller = new Relations;
    	
    	//function returns the adjacency matrix from the db
    	$adj = $relations_controller->get_adj();

    	// this is the format of $adj variable..
    	// $adj=array('S' => array('T'=>7,'V'=>2,'X'=>4),
    	// 			'T'=> array('V'=>2,'X'=>1),
    	// 			'U'=>array('S'=>2,'T'=>6),
    	// 			'V'=>array(),
    	// 			'X'=>array('V'=>1),
    	// 			'W'=>array('S'=>3,'U'=>5) );

    	//source station as requested by the user
    	$src=$request->src;

    	//destination station as requested by the user
    	$dest=$request->dest;

    	// call to dfs for calculating all the paths..
    	$this->DFS($src,$dest,$adj);

    	//using ksort function to sort the paths based on the total distance..
    	ksort($this->paths);
    	
    	return json_encode(["paths"=>$this->paths,"adj"=>$adj]);
    }

    
    public function DFS($src,$dest,$adj)
    {
    	$relations_controller = new Relations;

		$nodes=$relations_controller->get();
 		
 		// declaring visited array and initializing it to 0 
 		// i.e all nodes are iniatialy set to non visited
 		$visited=array();
    	//$visited=array('S'=>0,'T'=>0,'U'=>0,'V'=>0,'W'=>0,'X'=>0);
    	foreach ($nodes as $node) {
    		$visited[$node->name]=0;
    	}

    	//create a temporary path
    	$path=array();

    	$pathindex=0;
    	
    	//$n contains the temporary sum of the distance travelled so far in $path variable..
    	$n=0;

    	//utility recursive function for calculating all paths
    	$this->calPaths($src,$dest,$visited,$path,$pathindex,$n,$adj);
    }

    //utility recursive function for calculating all paths
    public function calPaths($src,$dest,$visited,$path,$pathindex,$n,$adj)
    {
    	// Mark the current node and store it in $path[]
    	$visited[$src] = 1;
    	$path[$pathindex] = $src;
    	$pathindex++;
 
    // If current vertex is same as destination,
    // then store it in global $paths
    if ($src == $dest)
    {

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

