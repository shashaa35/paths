<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Relations extends Model
{
    protected $fillable = [
    	'id', 'name',
    ];
    protected $primaryKey = 'id';
    
    public $timestamps = true;
    
    public function get()
    {
    	return DB::table('nodes')->select('name')->get();
    }

    public function get_adj()
    {
    	//creating the adjacency matrix
    	$adj = array();

    	//retreiving all the data about nodes
    	$nodes = DB::table('nodes')->get();

    	foreach ($nodes as $node) {
    		//$arr contains the adjacent nodes of $node
    		$arr= DB::table('relations')
            ->join('nodes', 'nodes.id', '=', 'relations.to')
            ->select('nodes.name', 'relations.weight')
            ->where('relations.from','=',$node->id)
            ->get();
			
			//converting the structure of data in the required form
			$arr1 = array();
			foreach ($arr as $ar) {
				$arr1[$ar->name]=$ar->weight;
			}
			$adj[$node->name]=$arr1 ;

    	}
    	return($adj);
    	// this is the format of $adj variable now..
    	// $adj=array('S' => array('T'=>7,'V'=>2,'X'=>4),
    	// 			'T'=> array('V'=>2,'X'=>1),
    	// 			'U'=>array('S'=>2,'T'=>6),
    	// 			'V'=>array(),
    	// 			'X'=>array('V'=>1),
    	// 			'W'=>array('S'=>3,'U'=>5) );

    }
}
