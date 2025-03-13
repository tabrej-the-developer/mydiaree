<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ObservationModel extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function createObservation($data){

		$id=mt_rand();
		$this->db->query("INSERT INTO observation (`id`, `userId`, `title`,`child_voice`,`future_plan`, `notes`, `reflection`, `status`, `approver`, `centerid`, `date_added`, `date_modified`) VALUES (NULL, '".$data->userid."', '".$this->db->escape($data->title)."', '".$this->db->escape($data->child_voice)."', '".$this->db->escape($data->future_plan)."', '".$this->db->escape($data->notes)."', '".$this->db->escape($data->reflection)."', '".$data->status."', '".$data->approver."', '".$data->centerid."', current_timestamp(), current_timestamp())");
		if(!empty($data->childrens))
		{
			foreach($data->childrens as $key=>$child)
			{
				$this->db->query("INSERT INTO observationchild SET observationId = " . $id . ",childId = " . $child . "");
			}
		}

		foreach($data->images as $key=>$child)
		{
			$explode=explode("/",$child->type);
			$type=ucfirst(strtolower($explode[0]));
			$this->db->query("INSERT INTO observationmedia SET observationId = " . $id . ",mediaUrl = '" . $child->file_name . "',mediaType='".$type."'");
		}
		return $id;
	}

	public function editObservation($data){
		$id=$data->observationId;
		$this->db->query("UPDATE observation SET 
		title = " . addslashes($data->title) . ", 
		userId = " . $data->userid . ",
		notes = " . $this->db->escape($data->notes) . ", 
		reflection = " . $this->db->escape($data->reflection) . ",
		child_voice = " . $this->db->escape($data->child_voice) . ",
		future_plan = " . $this->db->escape($data->future_plan) . ",
		date_modified = NOW() 
		WHERE id = " . $id
	);
		if(!empty($data->childrens))
		{
			$this->db->query("DELETE FROM observationchild where observationId = " . $id . "");
		foreach($data->childrens as $key=>$child){
			$this->db->query("INSERT INTO observationchild SET observationId = " . $id . ",childId = " . $child . "");
			}
		}
		$this->db->query("DELETE FROM observationmedia where  observationId = " . $id . "");
		foreach($data->images as $key=>$child)
		{
			$explode=explode("/",$child->type);
			$type=ucfirst(strtolower($explode[0]));
			$this->db->query("INSERT INTO observationmedia SET observationId = " . $id . ",mediaUrl = '" . $child->file_name . "',mediaType='".$type."'");
		}
		return $id;
	}

	public function createMontessori($data='')
	{
		$array = [
			"observationId"=>$data->observationId,
			"idSubActivity"=>$data->idSubActivity,
			"assesment"=>$data->assessment
		];
		$this->db->insert("observationmontessori",$array);
		$insertId = $this->db->insert_id();
		return  $insertId;
	}

	public function montessoriExists($data='')
	{
		$array = array("observationId"=>$data->observationId,"idSubActivity"=>$data->idSubActivity);
		$this->db->where($array);
		$this->db->from("observationmontessori");
		$q = $this->db->count_all_results();
		return $q;
	}

	public function montessoriExtraExists($data='')
	{
		$array = array("observationmontessoriid"=>$data->monId,"idextra"=>$data->extra);
		$this->db->where($array);
		$this->db->from("observationmontessoriextras");
		$q = $this->db->count_all_results();
		return $q;
	}

	public function createMontessoriExtra($data='')
	{
		$array = array("observationmontessoriid"=>$data['monId'],"idextra"=>$data['idextra']);
		$this->db->insert("observationmontessoriextras",$array);
	}


	public function updateMontessori($data='')
	{
		$array = [
			"observationId"=>$data->observationId,
			"idSubActivity"=>$data->idSubActivity,
			"assesment"=>$data->assessment
		];
		$condition = [
			"observationId"=>$data->observationId,
			"idSubActivity"=>$data->idSubActivity
		];
		$this->db->where($condition);
		$this->db->update("observationmontessori",$array);
	}

	public function getMontId($data='')
	{
		$condition = [
			"observationId"=>$data->observationId,
			"idSubActivity"=>$data->idSubActivity
		];

		$q = $this->db->get_where("observationmontessori",$condition);
		$obj = $q->row();
		return $obj->id;
	}

	public function deleteMontessoriExtra($data='')
	{
		$array = array("observationmontessoriid"=>$data->monId,"idextra"=>$data->idextra);
		$this->db->delete("observationmontessoriextras",$array);
	}

	// public function createMontessori($data){
	// 	
	// 	foreach($data->montessori as $key)
	// 	{
	// 		$query = $this->db->query("SELECT * FROM observationmontessori where observationId = " . $data->observationId . " and idSubActivity=".$key->idSubActivity."");
 //      $query=$query->row();
 //        foreach($key->extras as $extra){
 //        	if($extra == null || $extra == ""){
	//         	$extra = 0;
	//         }
	// 				if(!empty($query))
	// 				{
	// 					// $this->db->query("UPDATE observationmontessori SET idExtra=$extra , assesment= '$key->assessment' where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
	// 					$this->db->query("UPDATE observationmontessori SET assesment= '$key->assessment' where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
	// 					$getId = $this->db->query("SELECT * FROM observationmontessori where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
	// 					if($getId->row() != null){
	// 						$getId = ($getId->row())->id ;
	// 						$this->db->query("UPDATE observationmontessoriextras SET idextra = $extra WHERE observationmontessoriid	 = $getId ");
	// 					}
	// 				}else{
	// 				// $this->db->query("INSERT INTO observationmontessori SET observationId = " . $data->observationId . ",idSubActivity = " . $key->idSubActivity . ",idExtra=".$extra.",assesment='$key->assessment'");
	// 					$qu = $this->db->query("SELECT * FROM observationmontessori where observationId = " . $data->observationId . " and idSubActivity=".$key->idSubActivity."");
	// 		      $qu = $qu->row();
	// 		      if($qu == null){
	// 						$this->db->query("INSERT INTO observationmontessori SET observationId = " . $data->observationId . ",idSubActivity = " . $key->idSubActivity . ",assesment='$key->assessment'");
	// 					}
	// 						$getId = $this->db->query("SELECT * FROM observationmontessori where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
	// 						if($getId->row() != null){
	// 							$getId = ($getId->row())->id ;
	// 							$this->db->query("INSERT INTO observationmontessoriextras (observationmontessoriid,idextra) VALUES ($getId,$extra)");
	// 						}
	// 				}
	// 			}
	// 			// if(count($key->extras) == 0){
	// 			// 	if(!empty($query))
	// 			// 	{
	// 			// 		// $this->db->query("UPDATE observationmontessori SET idExtra= 0  , assesment= '$key->assessment' where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
	// 			// 		$this->db->query("UPDATE observationmontessori SET assesment= '$key->assessment' where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
	// 			// 		$getId = $this->db->query("SELECT * FROM observationmontessori where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
	// 			// 		if($getId->row() != null){
	// 			// 			$getId = ($getId->row())->id ;
	// 			// 			$this->db->query("UPDATE observationmontessoriextras SET idextra = $extra WHERE observationmontessoriid	 = $getId ");
	// 			// 		}
	// 			// 	}else{
	// 			// 	// $this->db->query("INSERT INTO observationmontessori SET observationId = " . $data->observationId . ",idSubActivity = " . $key->idSubActivity . ",idExtra=0,assesment='$key->assessment'");
	// 			// 	$this->db->query("INSERT INTO observationmontessori SET observationId = " . $data->observationId . ",idSubActivity = " . $key->idSubActivity . ",assesment='$key->assessment'");
	// 			// 		$getId = $this->db->query("SELECT * FROM observationmontessori where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
	// 			// 		if($getId->row() != null){
	// 			// 			$getId = ($getId->row())->id ;
	// 			// 			$this->db->query("INSERT INTO observationmontessoriextras (observationmontessoriid,idextra) VALUES ($getId,0)");
	// 			// 		}
	// 			// 	}
	// 			// }
	// 	}
	// }

	public function editMontessori($data){
		foreach($data->montessori as $key)
		{
			$query = $this->db->query("DELETE FROM observationmontessori where observationId = " . $data->observationId . " and idSubActivity=".$key->idSubActivity."");

			$query = $this->db->query("SELECT * FROM observationmontessori where observationId = " . $data->observationId . " and idSubActivity=".$key->idSubActivity."");
      $query=$query->row();
        foreach($key->extras as $extra){
        	if($extra == null || $extra == ""){
	        	$extra = 0;
	        }
					if(!empty($query))
					{
						// $this->db->query("UPDATE observationmontessori SET idExtra=$extra , assesment= '$key->assessment' where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
						$this->db->query("UPDATE observationmontessori SET assesment= '$key->assessment' where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
						$getId = $this->db->query("SELECT * FROM observationmontessori where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
						if($getId->row() != null){
							$getId = ($getId->row())->id ;
							$this->db->query("UPDATE observationmontessoriextras SET idextra = $extra WHERE observationmontessoriid	 = $getId ");
						}
					}else{
					// $this->db->query("INSERT INTO observationmontessori SET observationId = " . $data->observationId . ",idSubActivity = " . $key->idSubActivity . ",idExtra=".$extra.",assesment='$key->assessment'");
						$qu = $this->db->query("SELECT * FROM observationmontessori where observationId = " . $data->observationId . " and idSubActivity=".$key->idSubActivity."");
			      $qu = $qu->row();
			      if($qu == null){
							$this->db->query("INSERT INTO observationmontessori SET observationId = " . $data->observationId . ",idSubActivity = " . $key->idSubActivity . ",assesment='$key->assessment'");
						}
							$getId = $this->db->query("SELECT * FROM observationmontessori where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
							if($getId->row() != null){
								$getId = ($getId->row())->id ;
								$this->db->query("INSERT INTO observationmontessoriextras (observationmontessoriid,idextra) VALUES ($getId,$extra)");
							}
					}
				}
				// if(count($key->extras) == 0){
				// 	if(!empty($query))
				// 	{
				// 		// $this->db->query("UPDATE observationmontessori SET idExtra= 0  , assesment= '$key->assessment' where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
				// 		$this->db->query("UPDATE observationmontessori SET assesment= '$key->assessment' where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
				// 		$getId = $this->db->query("SELECT * FROM observationmontessori where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
				// 		if($getId->row() != null){
				// 			$getId = ($getId->row())->id ;
				// 			$this->db->query("UPDATE observationmontessoriextras SET idextra = $extra WHERE observationmontessoriid	 = $getId ");
				// 		}
				// 	}else{
				// 	// $this->db->query("INSERT INTO observationmontessori SET observationId = " . $data->observationId . ",idSubActivity = " . $key->idSubActivity . ",idExtra=0,assesment='$key->assessment'");
				// 	$this->db->query("INSERT INTO observationmontessori SET observationId = " . $data->observationId . ",idSubActivity = " . $key->idSubActivity . ",assesment='$key->assessment'");
				// 		$getId = $this->db->query("SELECT * FROM observationmontessori where observationId = $data->observationId and idSubActivity= $key->idSubActivity");
				// 		if($getId->row() != null){
				// 			$getId = ($getId->row())->id ;
				// 			$this->db->query("INSERT INTO observationmontessoriextras (observationmontessoriid,idextra) VALUES ($getId,0)");
				// 		}
				// 	}
				// }
		}
	}

	public function getObservationmontessoriextras($obsid){
		$query = $this->db->query("SELECT * FROM observationmontessoriextras ome INNER JOIN montessoriextras me ON ome.idextra = me.idExtra WHERE ome.observationmontessoriid = ".$obsid);
		return $query->result();
	}

	public function getObservationMilestoneExtras($obsid){
		$query = $this->db->query("SELECT idExtra FROM observationmilestoneextras where milestoneid = $obsid");
		return $query->result();
	}

	public function createMilstones($data){
		
		foreach($data->milestones as $key)
		{
			$query = $this->db->query("SELECT * FROM observationdevmilestonesub where observationId = " . $data->observationId . " and devMilestoneId=".$key->devMilestoneId."");
    	
    	$query=$query->row();
        
      foreach($key->extras as $extra){
        	if($extra == null || $extra == ""){
	        	$extra = 0;
	        }
					
					if(!empty($query))
					{
						// $this->db->query("UPDATE observationdevmilestonesub SET idExtra=$extra,assessment= '$key->assessment' WHERE observationId = " . $data->observationId . " and devMilestoneId=".$key->devMilestoneId."");
						$this->db->query("UPDATE observationdevmilestonesub SET assessment= '$key->assessment' WHERE observationId = " . $data->observationId . " and devMilestoneId=".$key->devMilestoneId."");
						$getId = $this->db->query("SELECT * FROM observationdevmilestonesub where observationId = $data->observationId and devMilestoneId=".$key->devMilestoneId."");
						if($getId->row() != null){
							$getId = ($getId->row())->id ;
							$this->db->query("UPDATE observationmilestoneextras SET idExtra = $extra WHERE milestoneid = $getId ");
						}
					}else{
						// $this->db->query("INSERT INTO observationdevmilestonesub SET observationId = " . $data->observationId . ", devMilestoneId = " . $key->devMilestoneId . ",idExtra=".$extra.",assessment='$key->assessment'");

						$qu = $this->db->query("SELECT * FROM observationdevmilestonesub where observationId = $data->observationId and devMilestoneId=".$key->devMilestoneId."");
			      $qu = $qu->row();
			      if($qu == null){
							$this->db->query("INSERT INTO observationdevmilestonesub SET observationId = " . $data->observationId . ", devMilestoneId = " . $key->devMilestoneId . ",assessment='$key->assessment'");
						}
							$getId = $this->db->query("SELECT * FROM observationdevmilestonesub where observationId = $data->observationId and devMilestoneId=".$key->devMilestoneId."");
							if($getId->row() != null){
								$getId = ($getId->row())->id ;
								$this->db->query("INSERT INTO observationmilestoneextras (milestoneid,idExtra) VALUES ($getId,$extra)");
							}
					}
				}
			// if(count($key->extras) == 0){
			// 		if(!empty($query))
			// 		{
			// 			// $this->db->query("UPDATE observationdevmilestonesub SET idExtra=0 ,assessment='$key->assessment' where observationId = " . $data->observationId . " and devMilestoneId=".$key->devMilestoneId."");

			// 			$this->db->query("UPDATE observationdevmilestonesub SET assessment= '$key->assessment' where observationId = $data->observationId and devMilestoneId=".$key->devMilestoneId."");
			// 			$getId = $this->db->query("SELECT * FROM observationdevmilestonesub where observationId = $data->observationId and devMilestoneId=".$key->devMilestoneId."");
			// 			if($getId->row() != null){
			// 				$getId = ($getId->row())->id ;
			// 				$this->db->query("UPDATE observationmilestoneextras SET idExtra = 0 WHERE milestoneid	 = $getId");
			// 			}
			// 		}else{
			// 			// $this->db->query("INSERT INTO observationdevmilestonesub SET observationId = " . $data->observationId . ", devMilestoneId = " . $key->devMilestoneId . ",idExtra=0,assessment='$key->assessment'");

			// 			$this->db->query("INSERT INTO observationdevmilestonesub SET observationId = " . $data->observationId . ",devMilestoneId = $key->devMilestoneId,assessment='$key->assessment'");
			// 			$getId = $this->db->query("SELECT * FROM observationdevmilestonesub where observationId = $data->observationId and devMilestoneId= $key->devMilestoneId");
			// 			if($getId->row() != null){
			// 				$getId = ($getId->row())->id ;
			// 					$this->db->query("INSERT INTO observationmilestoneextras (milestoneid,idExtra) VALUES ($getId,0)");
			// 					}
			// 			}
			// 		}
				}
			}

	public function editMilstones($data){
		
		foreach($data->milestones as $key)
		{
		$query = $this->db->query("DELETE FROM observationdevmilestonesub where observationId = " . $data->observationId . " and devMilestoneId=".$key->devMilestoneId."");
		$query = $this->db->query("SELECT * FROM observationdevmilestonesub where observationId = " . $data->observationId . " and devMilestoneId=".$key->devMilestoneId."");
    $query=$query->row();
        foreach($key->extras as $extra){
		        	if($extra == null || $extra == ""){
			        	$extra = 0;
			        }
					if(!empty($query))
					{
						// $this->db->query("UPDATE observationdevmilestonesub SET idExtra=$extra,assessment= '$key->assessment' WHERE observationId = " . $data->observationId . " and devMilestoneId=".$key->devMilestoneId."");
						$this->db->query("UPDATE observationdevmilestonesub SET assessment= '$key->assessment' WHERE observationId = " . $data->observationId . " and devMilestoneId=".$key->devMilestoneId."");
						$getId = $this->db->query("SELECT * FROM observationdevmilestonesub where observationId = $data->observationId and devMilestoneId=".$key->devMilestoneId."");
						if($getId->row() != null){
							$getId = ($getId->row())->id ;
							$this->db->query("UPDATE observationmilestoneextras SET idExtra = $extra WHERE milestoneid	 = $getId ");
						}
					}else{
						// $this->db->query("INSERT INTO observationdevmilestonesub SET observationId = " . $data->observationId . ", devMilestoneId = " . $key->devMilestoneId . ",idExtra=".$extra.",assessment='$key->assessment'");

						$qu = $this->db->query("SELECT * FROM observationdevmilestonesub where observationId = $data->observationId and devMilestoneId=".$key->devMilestoneId."");
			      $qu = $qu->row();
			      if($qu == null){
							$this->db->query("INSERT INTO observationdevmilestonesub SET observationId = " . $data->observationId . ", devMilestoneId = " . $key->devMilestoneId . ",assessment='$key->assessment'");
						}
							$getId = $this->db->query("SELECT * FROM observationdevmilestonesub where observationId = $data->observationId and devMilestoneId=".$key->devMilestoneId."");
							if($getId->row() != null){
								$getId = ($getId->row())->id ;
								$this->db->query("INSERT INTO observationmilestoneextras (milestoneid,idExtra) VALUES ($getId,$extra)");
							}
					}
				}
			// if(count($key->extras) == 0){
			// 		if(!empty($query))
			// 		{
			// 			// $this->db->query("UPDATE observationdevmilestonesub SET idExtra=0 ,assessment='$key->assessment' where observationId = " . $data->observationId . " and devMilestoneId=".$key->devMilestoneId."");

			// 			$this->db->query("UPDATE observationdevmilestonesub SET assessment= '$key->assessment' where observationId = $data->observationId and devMilestoneId=".$key->devMilestoneId."");
			// 			$getId = $this->db->query("SELECT * FROM observationdevmilestonesub where observationId = $data->observationId and devMilestoneId=".$key->devMilestoneId."");
			// 			if($getId->row() != null){
			// 				$getId = ($getId->row())->id ;
			// 				$this->db->query("UPDATE observationmilestoneextras SET idExtra = 0 WHERE milestoneid	 = $getId");
			// 			}
			// 		}else{
			// 			// $this->db->query("INSERT INTO observationdevmilestonesub SET observationId = " . $data->observationId . ", devMilestoneId = " . $key->devMilestoneId . ",idExtra=0,assessment='$key->assessment'");

			// 			$this->db->query("INSERT INTO observationdevmilestonesub SET observationId = " . $data->observationId . ",devMilestoneId = $key->devMilestoneId,assessment='$key->assessment'");
			// 			$getId = $this->db->query("SELECT * FROM observationdevmilestonesub where observationId = $data->observationId and devMilestoneId= $key->devMilestoneId");
			// 			if($getId->row() != null){
			// 				$getId = ($getId->row())->id ;
			// 					$this->db->query("INSERT INTO observationmilestoneextras (milestoneid,idExtra) VALUES ($getId,0)");
			// 					}
			// 			}
			// 		}
				}
			}


	public function createComment($data){
		$insArr = ["observationId"=>$data->id,"userId"=>$data->userid,"comments"=>$data->comment,"date_added"=>date('Y-m-d H:i:s')];
		$this->db->insert("observationcomments",$insArr);
		// $this->db->query("INSERT INTO observationcomments SET observationId = " . $data->id . ", userId = " . $data->userid . ", comments='".$data->comment."',date_added='" . date('Y-m-d H:i:s') ."'");
	}
	public function createLinks($data){
		$this->db->query("DELETE FROM observationlinks where observationId = '".$data->observationId."' AND linktype = '".$data->linkType."'");
		foreach($data->obsLinks as $key=>$val)
		{
			$this->db->query("INSERT INTO observationlinks SET observationId = ".$data->observationId.", linkid = ".$val.",linktype='".$data->linkType."'");
		}

	}
	public function createEylf($data){
		
		foreach($data->eylf as $key=>$values){
			$this->db->query("DELETE FROM observationeylf where observationId = " . $data->observationId . " and eylfActivityId=".$key."");
			foreach($values as $val){
				if($val){
					$this->db->query("INSERT INTO observationeylf SET observationId = " . $data->observationId . ", eylfActivityId = " . $key . ",eylfSubactivityId=".$val."");
			    }
			}
		}
	}

	public function getEylfSubActsInfo($subActId='')
	{
		$q = $this->db->get_where("eylfsubactivity",array("id"=>$subActId));
		return $q->row();
	}

	public function insertObservationEYLF($data='')
	{
		$insdata = ['observationId'=>$data->obsid,'eylfActivityId'=>$data->eylfActId,'eylfSubactivityId'=>$data->eylfSubActId];
		$this->db->insert('observationeylf', $insdata);
		return $this->db->insert_id();
	}

	public function removeObservationEYLF($data='')
	{
		$insdata = ['observationId'=>$data->obsid, 'eylfActivityId'=>$data->eylfActId];
		$this->db->delete('observationeylf', $insdata);
		return $this->db->affected_rows();
	}


	public function getListFilterObservations($data=array())
	{
		
		$sql="SELECT o.id,o.date_added FROM observation o left join observationchild oc on (oc.observationId=o.id) left join users u on
		      (u.userid=o.userId) left join users a on (u.userid=o.approver) left join child c on (c.id=oc.childId) left join observationmedia om on
			  (om.observationId=o.id) left join observationmontessori omo on (omo.observationId=o.id) left join observationeylf oe on (oe.observationId=o.id)
			  left join observationdevmilestonesub od on (od.observationId=o.id) left join observationcomments co on (co.observationId=o.id)
			  left join users cu on (cu.userid=co.userId) left join observationlinks ol on (ol.linkid=o.id) where o.status is not null";




		if(!empty($data['filter_children']))
		{
			$sql.=" and  oc.childId  IN (".implode(',',$data['filter_children']).") ";
		}

		if(!empty($data['filter_observationss']))
		{
		   foreach($data['filter_observationss'] as $observation){
				$sql.=" and  o.status='".$observation."' ";
		   }
		}

		if(!empty($data['filter_media']))
		{
		   foreach($data['filter_media'] as $media)
		   {
			$sql.=" and  om.mediaType='".$media."' ";
		   }
		}

		if(!empty($data['filter_links']))
		{
		   foreach($data['filter_links'] as $link)
		   {
			if($link=='Linked to anything')
			{
				$sql.=" and  ol.linkid is not  null ";
			}else if($link=='Not Linked to anything')
			{
				$sql.=" and  ol.linkid is   null ";
			}
			else if($link=='Linked to observations')
			{
				$sql.=" and  ol.linktype='OBSERVATION'";
			}
			else if($link=='Not Linked to observations')
			{
				$sql.=" and  ol.linktype <> 'OBSERVATION'";
			}
			else if($link=='Not Linked to reflections')
			{
				$sql.=" and  ol.linktype <> 'REFLECTIONS'";
			}
			else if($link=='Linked to reflections')
			{
				$sql.=" and  ol.linktype ='REFLECTIONS'";
			}
		   }
		}

		if(!empty($data['filter_comments']))
		{
		   foreach($data['filter_comments'] as $comment)
		   {
			if($comment=='With Comments')
			{
				$sql.=" and  co.comments is not  null ";
			}
			else if($comment=='With Staff Comments')
			{
				$sql.=" and  cu.userType='Staff' ";
			}
			else if($comment=='With Relative Comments')
			{
				$sql.=" and  cu.userType='Relative' ";
			}
			else if($comment=='No Comments')
			{
				$sql.=" and  co.comments is   null ";
			}
			else if($comment=='No Staff Comments')
			{
				$sql.=" and  cu.userType <> 'Staff' ";
			}
			else if($comment=='No Relative Comments')
			{
				$sql.=" and  cu.userType <> 'Relative' ";
			}

		   }
		}

		if(!empty($data['filter_added']))
		{
	  	foreach($data['filter_added'] as $added)
	    {
				if($added=='Today')
				{
					$date=date('Y-m-d');
					$sql.=" and  DATE_FORMAT(o.date_added,'%Y-%m-%d') BETWEEN '".$date."' and '".$date."' ";
				}else if($added=='This Week')
				{
					$date=date('Y-m-d');
					$ts = strtotime($date);
					$start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
					$start_date = date('Y-m-d', $start);
					$end_date = date('Y-m-d', strtotime('next saturday', $start));
					$sql.=" and  DATE_FORMAT(o.date_added,'%Y-%m-%d') BETWEEN '".$start_date."' and '".$end_date."' ";
				}else if($added=='This Month')
				{
					$start_date=date('Y-m-01');
					$end_date=date('Y-m-t',strtotime($start_date.' 30 days'));
					$sql.=" and  DATE_FORMAT(o.date_added,'%Y-%m-%d') BETWEEN '".$start_date."' and '".$end_date."' ";
				}
	  	}
		}

		if(!empty($data['filter_assessments']))
		{
			if($data['filter_assessments'][0]=='Does Not Have Any Assessment')
			{
			$sql.=" and omo.id is null and oe.id is null and od.id is null ";
			}
			if(in_array('Has Montessori',$data['filter_assessments']))
			{
				$sql.=" and omo.id is not null";
			}
			if(in_array('Has Early Years Learning Framework',$data['filter_assessments']))
			{
				$sql.=" and oe.id is not null";
			}
			if(in_array('Has Developmental Milestones',$data['filter_assessments']))
			{
				$sql.=" and od.id is not null";
			}
			if(in_array('Does Not Have Montessori',$data['filter_assessments']))
			{
				$sql.=" and omo.id is  null";
			}
			if(in_array('Does Not Have Early Years Learning Framework',$data['filter_assessments']))
			{
				$sql.=" and oe.id is  null";
			}
			if(in_array('Does Not Have Developmental Milestones',$data['filter_assessments']))
			{
				$sql.=" and od.id is  null";
			}
		}

		if(!empty($data['filter_authors']))
		{
			$true=false;
			foreach($data['filter_authors'] as $author)
			{
				if($author=='Any')
				{
					break;
				}elseif($author=='Me')
				{
					if(!in_array('Staff',$data['filter_authors']))
					{
						$sql.=" and (u.userid=".$data['userid'].")";
					}else{
						$sql.=" and (u.userid=".$data['userid']."";
					}

					$true=true;
				}else if($author=='Staff')
				{
					if($true)
					{
						$sql.=" or u.userType='Staff')";
					}else{
						$sql.=" and  u.userType='Staff'";
					}

				}
			}
		}

		$sql.=" group by o.id order by o.date_added asc";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getFilterObservations($data=array())
	{
		
		$sql="SELECT o.id FROM observation o left join observationchild oc on (oc.observationId=o.id) left join users u on
		      (u.userid=o.userId) left join users a on (u.userid=o.approver) left join child c on (c.id=oc.childId) left join observationmedia om on
			  (om.observationId=o.id) left join observationmontessori omo on (omo.observationId=o.id) left join observationeylf oe on (oe.observationId=o.id)
			  left join observationdevmilestonesub od on (od.observationId=o.id) where o.status='Published'";

		if($data['id'])
		{
			$sql.=" and o.id <>".$data['id']." ";
		}



		if(!empty($data['filter_children']))
		{

			$sql.=" and  oc.childId  IN (".implode(',',$data['filter_children']).") ";
		}

		if(!empty($data['filter_assessments']))
		{
			if($data['filter_assessments'][0]=='Does Not Have Any Assessment')
			{
			$sql.=" and omo.id is null and oe.id is null and od.id is null ";
			}
			if(in_array('Has Montessori',$data['filter_assessments']))
			{
				$sql.=" and omo.id is not null";
			}
			if(in_array('Has Early Years Learning Framework',$data['filter_assessments']))
			{
				$sql.=" and oe.id is not null";
			}
			if(in_array('Has Developmental Milestones',$data['filter_assessments']))
			{
				$sql.=" and od.id is not null";
			}
			if(in_array('Does Not Have Montessori',$data['filter_assessments']))
			{
				$sql.=" and omo.id is  null";
			}
			if(in_array('Does Not Have Early Years Learning Framework',$data['filter_assessments']))
			{
				$sql.=" and oe.id is  null";
			}
			if(in_array('Does Not Have Developmental Milestones',$data['filter_assessments']))
			{
				$sql.=" and od.id is  null";
			}
		}
		if(!empty($data['filter_authors']))
		{
			$true=false;
			foreach($data['filter_authors'] as $author)
			{
				if($author=='Any')
				{
					break;
				}elseif($author=='Me')
				{
					if(!in_array('Staff',$data['filter_authors']))
					{
						$sql.=" and (u.userid=".$data['userid'].")";
					}else{
						$sql.=" and (u.userid=".$data['userid']."";
					}

					$true=true;
				}else if($author=='Staff')
				{
					if($true)
					{
						$sql.=" or u.userType='Staff')";
					}else{
						$sql.=" and  u.userType='Staff'";
					}

				}
			}
		}

		$sql.=" group by o.id";
		//echo $sql;
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getChilds()
	{
		
		$query = $this->db->query("SELECT * FROM child");
		return $query->result();
	}

	public function getMontessoriActivites($centerid='')
	{
		if ($centerid) {
			$sql = "SELECT ma.* FROM `montessoriactivity` ma INNER JOIN `montessoriactivityaccess` maa ON ma.idActivity = maa.idActivity WHERE maa.centerid = " . $centerid;
		}else{
			$sql = "SELECT * FROM montessoriactivity";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getMontessoriSubActivites($centerid='')
	{
		if ($centerid) {
			$sql = "SELECT msa.* FROM `montessorisubactivity` msa INNER JOIN `montessorisubactivityaccess` msaa ON msa.idSubActivity = msaa.idSubActivity WHERE msaa.centerid = " . $centerid;
		}else{
			$sql = "SELECT * FROM montessorisubactivity";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getmontessoriextras($centerid='')
	{
		if ($centerid) {
			$sql = "SELECT me.* FROM `montessoriextras` me INNER JOIN `montessorisubactivityextrasaccess` mea ON me.idExtra = mea.idExtra WHERE mea.centerid = " . $centerid;
		}else{
			$sql = "SELECT * FROM montessoriextras";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getEylfOutcomes()
	{
		$query = $this->db->query("SELECT * FROM eylfoutcome");
		return $query->result();
	}
	public function getEylfActivites($centerid='')
	{
		if ($centerid) {
			$sql = "SELECT ea.* FROM `eylfactivity` ea INNER JOIN `eylfactivityaccess` eaa ON ea.id = eaa.activityid WHERE eaa.centerid = " . $centerid;
		} else {
			$sql = "SELECT * FROM eylfactivity";
		}		
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getEylfSubActivites($centerid='') //$subactid='',$userId=''
	{
		if ($centerid != NULL) {
			$sql = "SELECT esa.* FROM `eylfsubactivity` esa INNER JOIN `eylfsubactivityaccess` esaa ON esa.id = esaa.subactivityid WHERE esaa.centerid = " . $centerid;
		} else {
			$sql = "SELECT * FROM eylfsubactivity";
		}		
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getDevelopmentalMilestone()
	{
		$query = $this->db->query("SELECT * FROM devmilestone");
		return $query->result();
	}

	public function getDevelopmentalMilestoneActivites($centerid='')
	{
		if ($centerid) {
			$sql = "SELECT dmm.* FROM `devmilestonemain` dmm INNER JOIN `devmilestonemainaccess` dmma ON dmm.id = dmma.idmain WHERE dmma.centerid = " . $centerid;
		} else {
			$sql = "SELECT * FROM devmilestonemain";
		}		
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getDevelopmentalMilestoneSubActivites($centerid='')
	{
		if ($centerid) {
			$sql = "SELECT dmms.* FROM `devmilestonesub` dmms INNER JOIN `devmilestonesubaccess` dmmsa ON dmms.id = dmmsa.idsubactivity WHERE dmmsa.centerid = " . $centerid;
		} else {
			$sql = "SELECT * FROM devmilestonesub";
		}		
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getDevMileSubActs($subid='',$userId='')
	{
		$query = $this->db->query("SELECT * FROM devmilestonesub");
		return $query->result();
	}
	
	public function getDevelopmentalMilestoneExtras($centerid='')
	{
		if ($centerid) {
			$sql = "SELECT dmmse.* FROM `devmilestoneextras` dmmse INNER JOIN `devmilestoneextrasaccess` dmmsaa ON dmmse.id = dmmsaa.idextra WHERE dmmsaa.centerid = " . $centerid;
		} else {
			$sql = "SELECT * FROM devmilestoneextras";
		}		
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getObservation($id)
	{
		$query = $this->db->query("SELECT * FROM observation where id=".$id);
		return $query->row();
	}
	public function getUserName($id='')
	{
		$query = $this->db->query("SELECT name FROM `users` WHERE userid = '".$id."'");
		return $query->row();
	}
	public function getObservations($id)
	{
		
		$sql="SELECT o.*,u.name as user_name FROM observation o left join users u on (u.userid=o.userId) ";
			if($id){
				$sql.=" where o.id<>".$id."";
			}
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function getPublishedObservations($id)
	{
		$sql="SELECT o.*,u.name as user_name,a.name as approverName FROM observation o left join users u on (u.userid=o.userId) left join users a on
		     (a.userid=o.approver) where o.status='Published' and o.id <> ".$id." ";

		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function getPublishedObservationsFromCenter($centerid)
	{
		$sql="SELECT o.*,u.name as user_name,a.name as approverName FROM observation o left join users u on (u.userid=o.userId) left join users a on (a.userid=o.approver) where o.status='Published' and o.centerid = ".$centerid." ORDER BY o.id DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function getObservationsList($data=array())
	{

		$sql="SELECT o.*,u.name as user_name,a.name as approverName FROM observation o left join users u on (u.userid=o.userId) left join users a on (a.userid=o.approver) WHERE o.centerid = ".$data['centerid'];
		/*	if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}*/
		$sql.=" ORDER BY o.date_added DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getObservationsList2($data = array())
{
	$sql="SELECT o.*, u.name AS user_name, a.name AS approverName
	FROM observation o
	LEFT JOIN users u ON u.userid = o.userId
	LEFT JOIN users a ON a.userid = o.approver
	WHERE o.centerid = ".$data['centerid']." AND o.userId = ".$data['userid'];;
	/*	if (isset($data['start']) || isset($data['limit'])) {
		if ($data['start'] < 0) {
			$data['start'] = 0;
		}

		if ($data['limit'] < 1) {
			$data['limit'] = 20;
		}

		$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
	}*/
	$sql.=" ORDER BY o.date_added DESC";
	$query = $this->db->query($sql);
	return $query->result();
    
}

	public function getObservationsTotal($data=array())
	{
		
		$sql="SELECT count(*) as total FROM observation WHERE centerid = ".$data['centerid'];
		$query = $this->db->query($sql);
		return $query->row();
	}
	public function getObservationsMedia($id)
	{
		
		$sql="SELECT * FROM observationmedia";
			if($id)
			{
				$sql.=" where id<>".$id."";
			}
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function getMedia($id)
	{
		
		$sql="SELECT * FROM observationmedia";
			if($id)
			{
				$sql.=" where observationId=".$id."";
			}
			$sql.=" ORDER BY priority ASC";
			$query = $this->db->query($sql);
			return $query->result();
	}
	public function getObservationUser($id)
	{
		
		$query = $this->db->query("SELECT o.*,u.name as user_name,a.name as approverName FROM observation o left join users u on (u.userid=o.userId) left join users a on (a.userid = o.approver) where o.id = ".$id."");
		return $query->row();
	}
	public function getReflectionUser($id)
	{
		
		$query = $this->db->query("SELECT o.*,u.name as user_name FROM reflection o  left join users u on (u.userid=o.createdBy) left join users a on (a.userid=o.createdBy) where o.id=".$id."");
		return $query->row();
	}
	public function getObservationsChildrens($id)
	{
		
		$sql="SELECT c.name as child_name,c.dob as dob,c.id as child_id,c.imageUrl,oc.observationId FROM observationchild oc left join
								  child c on (c.id = oc.childId)";
		   if($id)
			{
				$sql.=" where oc.observationId <>".$id."";
			}
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function getMontessoriCount($id)
	{
		
		$sql="SELECT count(*) as total,observationId FROM observationmontessori ";

		  if($id)
			{
				$sql.=" where observationId<>".$id."";
			}
			$sql.="  group by observationId";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function getObservationMontessoriCount($id)
	{
		
		$query = $this->db->query("SELECT count(*) as total FROM observationmontessori where observationId=".$id."");
		$query=$query->row();
		return $query->total;

	}
	public function getObservationEylfCount($id)
	{
		
		$query = $this->db->query("SELECT count(*) as total FROM observationeylf where observationId=".$id."");
		$query=$query->row();
		return $query->total;
	}
	public function getObservationMilestoneCount($id)
	{
		
		$query = $this->db->query("SELECT count(*) as total FROM observationdevmilestonesub where observationId=".$id."");
		$query=$query->row();
		return $query->total;
	}
	public function getEylfCount($id)
	{
		
		$sql="SELECT count(*) as total,observationId FROM observationeylf ";

		  if($id)
			{
				$sql.=" where observationId<>".$id."";
			}
			$sql.="  group by observationId";
		$query = $this->db->query($sql);
		return $query->result();

	}
	public function getMileCount($id)
	{
		
		$sql="SELECT count(*) as total,observationId FROM observationdevmilestonesub ";

		  if($id)
			{
				$sql.=" where observationId<>".$id."";
			}
			$sql.="  group by observationId";
		$query = $this->db->query($sql);
		return $query->result();

	}
	public function getobservationMedia($id)
	{
		$query = $this->db->query("SELECT * FROM observationmedia where observationId=".$id." ORDER BY priority DESC");
		return $query->result();
	}
	public function getobservationComments($id)
	{
		$query = $this->db->query("SELECT o.*,u.name as userName, u.imageUrl as img FROM observationcomments o left join users u on (u.userid=o.userId) where o.observationId=".$id."");
		return $query->result();
	}
	public function getobservationMontessori($id)
	{
		
		$query = $this->db->query("SELECT om.id as id, ome.id as ome_id,observationId ,idSubActivity, observationmontessoriid,assesment , ome.idExtra as idExtra FROM observationmontessori om INNER JOIN observationmontessoriextras ome on ome.observationmontessoriid = om.id  where observationId=".$id."");
		return $query->result();
	}

		public function getobsMontessori($id)
	{
		
		// $query = $this->db->query("SELECT om.id as id, ome.id as ome_id,observationId ,idSubActivity, observationmontessoriid,assesment , ome.idExtra as idExtra FROM observationmontessori om INNER JOIN observationmontessoriextras ome on ome.observationmontessoriid = om.id  where observationId=".$id."");
		$query = $this->db->query("SELECT * from observationmontessori where observationId=$id");
		return $query->result();
	}

	public function getobservationMontessoriDetails($id)
	{
		$query = $this->db->query("SELECT s.idSubject,s.name,ma.idActivity,ma.title,ms.title as subactivityName,ms.subject,e.title as extraName FROM
								  observationmontessori o left join montessorisubactivity ms on (ms.idSubActivity=o.idSubActivity)
								  left join montessoriactivity ma on (ma.idActivity=ms.idSubActivity) left join montessorisubjects s on (s.idSubject=ma.idSubject) left join montessoriextras e on (e.idExtra=o.idExtra) where o.observationId=".$id."");
		return $query->result();
	}

	public function getobservationMilestoneDetails($id)
	{
		
		// $query = $this->db->query("SELECT s.id,s.ageGroup,ma.id as idActivity,ma.name as title,ms.name as subactivityName,ms.subject,e.title as extraName FROM
		// 						  observationdevmilestonesub o left join devmilestonesub ms on (ms.id=o.devMilestoneId)
		// 						  left join devmilestonemain ma on (ma.id=ms.milestoneid) left join devmilestone s on
		// 						  (s.id=ma.ageId) left join devmilestoneextras e on (e.id=o.idExtra) where o.observationId=".$id."");
		$query = $this->db->query("SELECT s.id, s.ageGroup, ma.id AS idActivity, ma.name AS title, ms.name AS subactivityName, ms.subject FROM observationdevmilestonesub o LEFT JOIN devmilestonesub ms ON (ms.id = o.devMilestoneId) LEFT JOIN devmilestonemain ma ON (ma.id = ms.milestoneid) LEFT JOIN devmilestone s ON (s.id = ma.ageId) WHERE o.observationId = ".$id."");
		return $query->result();
	}
	public function getobservationEylf($id)
	{
		$query = $this->db->query("SELECT * FROM observationeylf where observationId=".$id."");
		return $query->result();
	}
	public function getobservationEylfDetails($id)
	{
		
		$query = $this->db->query("SELECT ou.id as outcomeId,ou.name,e.id as activityId,e.title as activityName,es.title as subactivityName FROM
								  observationeylf o left join eylfactivity e on (e.id=o.eylfActivityId) left join
								  eylfoutcome ou on (ou.id=e.outcomeId) left join eylfsubactivity es on (es.id=o.eylfSubactivityId)
								  where o.observationId=".$id."");
		return $query->result();
	}
	public function deleteLink($id,$linkId)
	{
		$query = $this->db->query("DELETE FROM observationlinks where observationId = $id AND linkid= $linkId");
	}

	public function deleteLinkbyId($linkId)
	{
		$query = $this->db->query("DELETE FROM observationlinks WHERE id= $linkId");
	}
	public function getobservationMilestones($id)
	{
		
		$query = $this->db->query("SELECT * FROM observationdevmilestonesub where observationId=".$id."");
		return $query->result();
	}
	public function getobservationLinks($id)
	{
		$query = $this->db->query("SELECT * FROM observationlinks where observationId=$id AND linktype = 'OBSERVATION'");
		return $query->result();
	}
	public function getReflectionLinks($id){
		$query = $this->db->query("SELECT * FROM observationlinks where observationId=$id AND linktype = 'REFLECTION'");
		return $query->result();
	}
	public function getQipLinks($id){
		$query = $this->db->query("SELECT * FROM observationlinks where observationId=$id AND linktype = 'QIP'");
		return $query->result();
	}
	public function getProgramPlanLinks($id){
		$query = $this->db->query("SELECT * FROM observationlinks where observationId=$id AND linktype = 'PROGRAMPLAN'");
		return $query->result();
	}
	public function getObservationChildrens($id)
	{
		$query = $this->db->query("SELECT CONCAT(c.name, ' ', c.lastname) as child_name, c.dob as dob, c.id as child_id, c.imageUrl FROM observationchild oc INNER JOIN child c ON (c.id = oc.childId) WHERE oc.observationId = ".$id."");
		return $query->result();
	}
	public function getReflectionChildrens($id)
	{
		$query = $this->db->query("SELECT c.name as child_name,c.dob as dob,c.id as child_id,c.imageUrl FROM reflectionchild oc left join child c on
								  (c.id = oc.childid) where oc.reflectionid=".$id."");
		return $query->result();
	}
	public function getMontessoriSubjects()
	{
		$query = $this->db->query("SELECT * FROM montessorisubjects");
		return $query->result();
	}
	
	public function getChildGroups()
	{
		$query = $this->db->query("SELECT c.name as child_name,c.dob as dob,c.id as child_id,cg.id as group_id,cg.name as group_name
								  FROM child_group_member cm left join child_group cg on (cm.group_id = cg.id) left
								  join child c on (cm.child_id=c.id)");
		return $query->result();
	}

	// Sagar Coded Onwards

	public function getParentChildGroups($userid)
	{
		$query = $this->db->query("SELECT c.name as child_name,c.dob as dob,c.id as child_id,cg.id as group_id,cg.name as group_name
								  FROM child_group_member cm left join child_group cg on (cm.group_id = cg.id) left
								  join child c on (cm.child_id=c.id) WHERE c.id IN (SELECT DISTINCT(childid) FROM `childparent` WHERE parentid = ".$userid.")");
		return $query->result();
	}

	public function getMontessoriActivities($subId=NULL)
	{
		if ($subId!=NULL) {
			$q = $this->db->get_where('montessoriactivity',array('idSubject'=>$subId));
		} else {
			$q = $this->db->get('montessoriactivity');
		}
		return $q->result();
	}

	public function getCenterMontessoriActivities($centerid='')
	{
		$q = $this->db->query("SELECT ma.* FROM `montessoriactivity` ma INNER JOIN montessoriactivityaccess maa ON maa.idActivity = ma.idActivity WHERE maa.centerid = ".$centerid);
		return $q->result();
	}

	public function getMontessoriSubActivities($actId=NULL)
	{
		if ($actId!=NULL) {
			$q = $this->db->get_where('montessorisubactivity',array('idActivity'=>$actId));
		} else {
			$q = $this->db->get('montessorisubactivity');
		}
		return $q->result();
	}

	public function getObsMonSubActs($obsId=NULL,$actId=NULL)
	{
		$sql = "SELECT om.id,msa.idSubActivity, msa.title, msa.subject, om.assesment FROM montessorisubactivity msa INNER JOIN observationmontessori om ON msa.idSubActivity = om.idSubActivity WHERE om.observationId = $obsId AND msa.idActivity = $actId";
		$q = $this->db->query($sql);
		return $q->result(); 
	}

	public function getMontSubActExtras($subActivityId=NULL)
	{
		if ($subActivityId!=NULL) {
			$q = $this->db->get_where('montessoriextras',array('idSubActivity'=>$subActivityId));
		} else {
			$q = $this->db->get('montessoriextras');
		}
		return $q->result();
	}

	public function getObsMonExtras($value='')
	{
		$sql = "SELECT * FROM montessoriextras me INNER JOIN observationmontessoriextras ome ON me.idExtra = ome.idextra WHERE observationmontessoriid = $value";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getEylfActivities($outcomeId=NULL)
	{
		if ($outcomeId!=NULL) {
			$q = $this->db->get_where('eylfactivity',array('outcomeId'=>$outcomeId));
		} else {
			$q = $this->db->get('eylfactivity');
		}
		return $q->result();
	}

	public function getEylfSubActivities($actId=NULL)
	{
		if ($actId!=NULL) {
			$q = $this->db->get_where('eylfsubactivity',array('activityid'=>$actId));
		} else {
			$q = $this->db->get('eylfsubactivity');
		}
		return $q->result();
	}

	public function getDevelopmentalMilestones($id=NULL)
	{
		if ($id!=NULL) {
			$q = $this->db->get_where('devmilestone',array('id'=>$id));
		} else {
			$q = $this->db->get('devmilestone');
		}
		return $q->result();
	}

	public function getDevMileMain($devMileId=NULL)
	{
		if ($devMileId!=NULL) {
			$q = $this->db->get_where('devmilestonemain',array('ageId'=>$devMileId));
		} else {
			$q = $this->db->get('devmilestonemain');
		}
		return $q->result();
	}

	public function getDevMileSub($subId=NULL)
	{
		if ($subId!=NULL) {
			$q = $this->db->get_where('devmilestonesub',array('milestoneid'=>$subId));
		} else {
			$q = $this->db->get('devmilestonesub');
		}
		return $q->result();

	}

	public function getDevMileExtra($titleid=NULL)
	{
		if ($titleid!=NULL) {
			$q = $this->db->get_where('devmilestoneextras',array('idsubactivity'=>$titleid));
		} else {
			$q = $this->db->get('devmilestoneextras');
		}
		return $q->result();
	}

	public function createObs($data){

		//adding observations data
		$obsData = array(
			"userId" => $data['userid'],
			"title" => $data['title'],
			"child_voice" => $data['child_voice'],
			"future_plan" => $data['future_plan'],
			"notes" => $data['notes'],
			"reflection" => isset($data['reflection']) ? $data['reflection'] : "",
			"status" => $data['status'],
			"approver" => $data['approver'],
			"centerid" => $data['centerid'],
			"date_added"=> date('Y-m-d h:i:s'),
			"date_modified"=> date('Y-m-d h:i:s')
		);

		$this->db->insert('observation', $obsData);

		$id = $this->db->insert_id();

		//storing childrens into observation
		if(!empty($data['childrens'])) {
			foreach ($data['childrens'] as $childId) {
				$childData = array(
					'observationId' => $id,
					'childId' => $childId
				);
				$this->db->insert('observationchild',$childData);
			}
		}
		return $id;
	}

	public function getMediaInfo($mediaId='')
	{
		$q = $this->db->get_where("media",array("id"=>$mediaId));
		return $q->row();
	}

	public function insertUploadedMedia($media='')
	{
		$arr = [
			"observationId" => $media->observationId,
			"mediaUrl" => $media->mediaUrl,
			"mediaType" => $media->mediaType,
			"caption" => $media->caption,
			"priority" => $media->priority
		];
		$this->db->insert("observationmedia",$arr);

		$id = $this->db->insert_id();
		return $id;
	}

	public function insertUploadedMediaChildTags($mediaId='',$childId='')
	{
		$this->db->insert("observationmediatags",array("mediaId"=>$mediaId,"childId"=>$childId));
	}

	public function insertUploadedMediaEducatorTags($mediaId='',$userId='')
	{
		$this->db->insert("observationmediaeducators",array("mediaId"=>$mediaId,"userId"=>$userId));
	}

	public function updateObservedImagePriority($obsMediaId='',$priority='')
	{
		$sql =$this->db->query("UPDATE observationmedia SET priority = '" . $priority ."' WHERE id = ". $obsMediaId ."");
	}

	public function getImageIdOfObs($obsId)
	{
		$q = $this->db->get_where("observationmedia",array('observationId'=>$obsId));
		return $q->result();
	}

	public function editObs($data){

		

		//adding observations data
		$obsData = array(
			"userId" => $data['userid'],
			"title" => $data['title'],
			"child_voice" => $data['child_voice'],
			"future_plan" => $data['future_plan'],
			"notes" => $data['notes'],
			"reflection" => $data['reflection'],
			// "status" => $data['status'],
			"date_added"=> date('Y-m-d h:i:s'),
			"date_modified"=> date('Y-m-d h:i:s'),
			"observationId" => $data['observationId']
		);

		// $this->db->insert('observation', $obsData);
		$this->db->query("UPDATE observation SET 
		title = '" . addslashes($data['title']) . "', 
		notes = '" . addslashes($data['notes']) . "', 
		reflection = '" . addslashes($data['reflection']) . "', 
		child_voice = '" . addslashes($data['child_voice']) . "', 
		future_plan = '" . addslashes($data['future_plan']) . "' 
		WHERE id = " . $data['observationId']
	);
		// , status = '". $data['status'] ."'

		// $id = $this->db->insert_id();

		## Here write insert observation child
		$this->db->query("DELETE FROM observationchild where observationId = " . $data['observationId'] . "");
		if(!empty($data['childrens'])) {
			foreach ($data['childrens'] as $child) {
				$result = $this->db->query("SELECT * FROM observationchild where id = '$child' and observationId = " . $data['observationId'] ." ");
				if($result->row() == null){
					$childData = array(
						'observationId' => $data['observationId'],
						'childId' => $child
					);
					$this->db->insert('observationchild',$childData);
				}
			}
		}
	}

	public function deleteMedia($mediaId){
		
		$query = $this->db->query("DELETE FROM observationmedia WHERE id = $mediaId ");
	}

	public function getPublishedReflections($centerid='')
	{
		if ($centerid) {
			$q = $this->db->query("SELECT r.*,u.name FROM reflection as r INNER JOIN users as u on r.createdBy = u.userid where r.status = 'PUBLISHED' AND r.centerid = " . $centerid );
		}else{
			$q = $this->db->query("SELECT r.*,u.name FROM reflection as r INNER JOIN users as u on r.createdBy = u.userid where r.status = 'PUBLISHED'");
		}
		
		return $q->result();
	}

	public function getReflectionMedia($reflid='')
	{
			$q = $this->db->get_where("reflectionmedia",['reflectionid'=>$reflid]);
			return $q->result();
	}

	public function getUserType($userid){
		$query = $this->db->query("SELECT * FROM users where userid = $userid");
		return $query->row();
	}

	public function getParentObservationsList($userid)
	{
		$sql = "SELECT DISTINCT o.*, u.name as user_name, a.name as approverName FROM `observation` o INNER JOIN `users` u ON o.userId = u.userid LEFT JOIN `users` a ON o.approver = a.userid INNER JOIN `observationchild` obsc ON o.id = obsc.observationId WHERE obsc.childid IN (SELECT childid FROM `childparent` WHERE parentid=$userid) ORDER BY o.date_added asc";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function createObsLinks($data){
		$this->db->query("DELETE FROM observationlinks where observationId = '" . $data['observationId'] . "'");
		foreach($data['link'] as $key=>$val)
		{
			 foreach($val as $v){
				  $this->db->query("INSERT INTO observationlinks SET observationId = " . $data['observationId'] . ", linkid = " . $v . ",linktype='".$key."'");
				}
		}

	}

	public function getCenterRooms($centerid)
	{
		$query = $this->db->get_where("room",array('centerid'=>$centerid));
		return $query->result();
	}

	public function getChildsFromRoom($roomid)
	{
		$query = $this->db->get_where("child",array('room'=>$roomid));
		return $query->result();
	}

	public function getChildsOfParent($parentid)
	{
		$q = $this->db->query("SELECT * FROM `child` WHERE id IN (SELECT childid FROM `childparent` WHERE parentid = $parentid)");
		return $q->result();
	}

	public function getEducators($centerid='')
	{
		if (empty($centerid)) {
			$q = $this->db->query("SELECT * FROM `users` WHERE userType = 'Staff'");
		} else {
			$q = $this->db->query("SELECT * FROM `users` WHERE userid IN (SELECT DISTINCT(userid) FROM `usercenters` WHERE centerid = $centerid) AND userType = 'Staff'");
		}
		return $q->result();
	}

	public function addImageInfo($data)
	{
		
		foreach ($data->obsImage as $oi) {
			$insArr = ["mediaId"=>$data->mediaId,"childId"=>$oi];
			$this->db->insert("observationmediatags",$insArr);
		}
		foreach ($data->obsEducator as $oe) {
			$insArr = ["mediaId"=>$data->mediaId,"userId"=>$oe];
			$this->db->insert("observationmediaeducators",$insArr);
		}

		$insArr = array(
		    'caption' => $data->obsCaption
		);

		$this->db->where('id', $data->mediaId);
		$this->db->update('observationmedia', $insArr);
		
	}

	public function getObsMediaChildTags($mediaId)
	{	
		$sql = "SELECT omt.*, c.name, c.imageUrl FROM observationmediatags omt LEFT JOIN child c ON omt.childId = c.id WHERE omt.mediaId = $mediaId";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getObsMediaEducatorTags($mediaId)
	{
		$sql = "SELECT ome.*, u.name, u.imageUrl FROM observationmediaeducators ome LEFT JOIN users u ON ome.userId = u.userid WHERE ome.mediaId = $mediaId";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getObsMediaById($mediaId)
	{
		$q =$this->db->get_where('observationmedia', array('id'=>$mediaId));
		return $q->row();
	}

	public function updateImageTags($data)
	{
		$this->db->delete("observationmediatags",array("mediaId"=>$data->emediaId));
		foreach ($data->childIds as $key => $cid) {
			$this->db->insert("observationmediatags",array("mediaId"=>$data->emediaId,"childId"=>$cid));
		}
	}

	public function updateEducatorTags($data)
	{
		$this->db->delete("observationmediaeducators",array("mediaId"=>$data->emediaId));
		foreach ($data->educatorIds as $key => $cid) {
			$this->db->insert("observationmediaeducators",array("mediaId"=>$data->emediaId,"userId"=>$cid));
		}
	}

	public function updateImageCaption($data)
	{
		$this->db->where("id",$data->emediaId);
		$this->db->update("observationmedia",array("caption"=>$data->imgCaption));
	}

	// public function getChildGroups()
	// {
	// 	$q = $this->db->get('child_group');
	// 	return $q->result();
	// }

	// public function getChildsFromGroups($groupId)
	// {	
	// 	$sql = "SELECT c.name as child_name,c.dob as dob,c.id as child_id FROM child c INNER JOIN child_group_member cgm ON c.id = cgm.child_id WHERE cgm.group_id = ".$groupId;
	// 	$q = $this->db->query($sql);
	// 	return $q->result();
	// }

	public function getObservationRow($obsid='')
	{
		$arr_criteria = ["id"=>$obsid];
		$q = $this->db->get_where('observation', $arr_criteria);
		return $q->row();
	}

	public function getMonSub($monSubId='')
	{
		$arr_criteria = ["idSubject"=>$monSubId];
		$q = $this->db->get_where('montessorisubjects', $arr_criteria);
		return $q->result();
	}

	public function getMonSubRow($monSubId='')
	{
		$arr_criteria = ["idSubject"=>$monSubId];
		$q = $this->db->get_where('montessorisubjects', $arr_criteria);
		return $q->row();
	}

	public function getMonSubRec($monSubId='')
	{
		$arr_criteria = ["idSubject"=>$monSubId];
		$q = $this->db->get_where('montessorisubjects', $arr_criteria);
		return $q->row();
	}

	public function getMonAct($monSubId='')
	{
		$arr_criteria = ["idSubject"=>$monSubId];
		$q = $this->db->get_where('montessoriactivity', $arr_criteria);
		return $q->result();
	}

	public function getDistObsEylfActId($obsId='')
	{
		$q = $this->db->query("SELECT DISTINCT(eylfActivityId) FROM `observationeylf` WHERE observationId = $obsId");
		return $q->result();
	}

	public function getDistObsEylfSubActId($obsId='')
	{
		$q = $this->db->query("SELECT DISTINCT(eylfSubactivityId) FROM `observationeylf` WHERE observationId = $obsId");
		return $q->result();
	}

	public function getObsEylfOutcomes($actId='')
	{
		$q = $this->db->query("SELECT DISTINCT(ea.outcomeId), ec.title FROM `eylfactivity` ea INNER JOIN `eylfoutcome` ec ON ea.outcomeId = ec.id  WHERE ea.id = $actId");
		return $q->result();
	}

	public function getEylfActs($outcomeId=NULL)
	{
		$q = $this->db->query("SELECT id,title FROM eylfactivity WHERE outcomeId = ".$outcomeId);
		return $q->result();
	}

	public function getEylfSubActs($activityId=NULL)
	{
		$q = $this->db->query("SELECT id,title FROM eylfsubactivity WHERE activityid = ".$activityId);
		return $q->result();
	}

	public function updateImagePriority($obj='')
	{
		$sql = "UPDATE `observationmedia` SET `priority`= ".$obj->priority." WHERE `id`= ".$obj->mediaid;
		$this->db->query($sql);
	}

	public function getUploadedMedia($userid='')
	{
		$arr_criteria = ['userid'=>$userid];
		$q = $this->db->get_where('media', $arr_criteria);
		return $q->result();
	}

	public function getObsMonSubActvts($obsId='')
	{
		$q = $this->db->get_where("observationmontessori",array("observationId"=>$obsId));
		return $q->result();
	}

	public function getDistObsMonActvts($obsId='')
	{
		$sql = "SELECT DISTINCT(idActivity) FROM montessorisubactivity WHERE idSubActivity IN (SELECT idSubActivity FROM observationmontessori WHERE observationId = '".$obsId."')";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getDistObsMonSubs($obsId='')
	{
		$sql = "SELECT idSubject,title FROM montessoriactivity WHERE `idActivity` IN (SELECT DISTINCT(idActivity) FROM montessorisubactivity WHERE idSubActivity IN (SELECT idSubActivity FROM observationmontessori WHERE observationId = '".$obsId."'))";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getMonActvts($subjectId='')
	{
		$q = $this->db->get_where("montessoriactivity",array('idSubject'=>$subjectId));
		return $q->result();
	}

	public function getMonSubActvts($activityId='')
	{
		$q = $this->db->get_where("montessorisubactivity",array('idActivity'=>$activityId));
		return $q->result();
	}

	public function getObsMonSubActvtsExtras($observationId='')
	{
		$sql = "SELECT me.idExtra FROM `montessoriextras` me INNER JOIN observationmontessoriextras ome ON me.idExtra = ome.idextra WHERE ome.observationmontessoriid = ".$observationId;
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getSubActivityExtras($subActivityId='')
	{
		$q = $this->db->get_where("montessoriextras",array("idSubActivity"=>$subActivityId));
		return $q->result();
	}

	public function getObsMilestone($obsId='')
	{
		$sql = "SELECT * FROM `devmilestone` WHERE id IN (SELECT DISTINCT(ageId) FROM `devmilestonemain` WHERE id IN (SELECT DISTINCT(milestoneid) FROM devmilestonesub WHERE id IN (SELECT DISTINCT(devMilestoneId) FROM observationdevmilestonesub WHERE observationId = ".$obsId.")))";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getObsMilestoneMain($obsId='')
	{
		$sql = "SELECT * FROM `devmilestonemain` WHERE id IN (SELECT DISTINCT(milestoneid) FROM devmilestonesub WHERE id IN (SELECT DISTINCT(devMilestoneId) FROM observationdevmilestonesub WHERE observationId = ".$obsId."))";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getObsMilestoneSub($obsId = '')
{
    $sql = "SELECT dms.*, odms.assessment 
            FROM devmilestonesub dms
            JOIN observationdevmilestonesub odms 
            ON dms.id = odms.devMilestoneId
            WHERE odms.observationId = ?";
    
    $q = $this->db->query($sql, [$obsId]);
    return $q->result();
}

	public function getObsMilestoneExtras($obsId='')
	{
		$sql = "SELECT dme.* FROM `observationmilestoneextras` ome INNER JOIN devmilestoneextras dme ON ome.idExtra = dme.id WHERE ome.milestoneid IN (SELECT DISTINCT(id) FROM observationdevmilestonesub WHERE observationId = ".$obsId.")";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getMileStone($milestoneId='')
	{
		$q = $this->db->get_where("devmilestone",array("id"=>$milestoneId));
		return $q->result();
	}

	public function getMileStoneMain($milestoneId='')
	{
		$q = $this->db->get_where("devmilestonemain",array("ageId"=>$milestoneId));
		return $q->result();
	}

	public function getMileStoneSubs($milestoneMainId='')
	{
		$q = $this->db->get_where("devmilestonesub",array("milestoneid"=>$milestoneMainId));
		return $q->result();
	}

	public function getMileStoneExtras($milestoneSubId='')
	{
		$q = $this->db->get_where("devmilestoneextras",array("idsubactivity"=>$milestoneSubId));
		return $q->result();
	}

	public function getAdminObsIds($centerid='')
	{
		$q = $this->db->get_where("observation",array("centerid"=>$centerid));
		return $q->result();
	}

	public function getStaffObsIds($userid='',$centerid='')
	{
		$q = $this->db->get_where("observation",array("centerid"=>$centerid,"userId"=>$userid));
		return $q->result();
	}

	public function getParentObsId($userid='', $centerid='')
	{
		$sql = "SELECT DISTINCT(o.id) FROM `observation` o INNER JOIN `observationchild` oc ON o.id = oc.observationId WHERE oc.childId IN (SELECT DISTINCT(oc.childId) FROM `observationchild` oc INNER JOIN `childparent` cp ON oc.childId = cp.childid WHERE cp.parentid = '".$userid."') AND o.centerid = '".$centerid."'";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function deleteMilestone($observationId='')
	{
		$this->db->delete("observationdevmilestonesub",array("observationId"=>$observationId));
	}

	public function deleteMilestoneExtras($devMilestoneId='')
	{
		$this->db->delete("observationmilestoneextras",array("milestoneid"=>$devMilestoneId));
	}

	public function getAllObsMilestones($obsId='')
	{
		$q = $this->db->get_where("observationdevmilestonesub",array("observationId"=>$obsId));
		return $q->result();
	}

	public function insertDevMilestone($data=[])
	{
		//Insert all milestone records
		foreach ($data as $key => $obj) {
			$insArr = [
				"observationId" => $obj->observationId,
				"devMilestoneId" => $obj->devMilestoneId,
				"assessment" => $obj->assessment
			];
			$this->db->insert("observationdevmilestonesub",$insArr);
			$id = $this->db->insert_id();
			//insert all extras for the milestones
			foreach ($obj->extras as $extras => $ext) {
				$extArr = [
					"milestoneid" => $id,
					"idExtra" => $ext
				];
				$this->db->insert("observationmilestoneextras",$extArr);
			}
		}
	}

	public function getPublishedQip($centerid)
	{
		$arr_criteria = array("centerId"=>$centerid);
		$q = $this->db->get_where('qip', $arr_criteria);
		return $q->result();
	}

	public function getPublishedProgPlan($centerid)
	{
		$sql = "SELECT * FROM programplanlist WHERE room_id IN (SELECT DISTINCT(id) FROM room WHERE centerid = '".$centerid."')";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getQipInfo($qipId='')
	{
		$q = $this->db->get_where('qip', array("id"=>$qipId));
		return $q->row();
	}

	public function fetchQipInfo($qipId='')
	{
		$sql = "SELECT q.id as qipId, q.name, u.userid, u.name AS approver, q.created_at as date_added FROM `qip` q LEFT JOIN `users` u ON q.created_by = u.userid WHERE q.id = " . $qipId;
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function getProgramPlanInfo($ppId='')
	{
		$q = $this->db->get_where('programplanlist', array("id"=>$ppId));
		return $q->row();
	}

	public function fetchProgramPlanInfo($ppId='')
	{
		$sql = "SELECT pp.id as ppId, pp.startdate, pp.enddate, u.userid, u.name AS approver, pp.createdAt as date_added FROM `programplanlist` pp LEFT JOIN `users` u ON pp.createdBy = u.userid WHERE pp.id = " . $ppId;
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function deleteObsDevMilestones($obsId='')
	{
		$this->db->delete("observationdevmilestonesub",array("observationId"=>$obsId));
	}

	public function getIdActivityOfMonSubActivity($data='')
	{
		$sql = "SELECT * FROM montessoriactivity WHERE idActivity IN (SELECT DISTINCT(idActivity) FROM `montessorisubactivity` WHERE idSubActivity IN (".implode(",", $data)."))";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getIdSubjectOfMonActivity($data='')
	{
		$sql = "SELECT * FROM montessorisubjects WHERE idSubject IN (SELECT DISTINCT(idSubject) FROM `montessoriactivity` WHERE idActivity IN (".implode(",", $data)."))";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getDistEylfActIdFromEylfSubActvt($eylfSubActIdArr='')
	{
		$sql = "SELECT * FROM eylfactivity WHERE id IN (SELECT DISTINCT(activityid) FROM eylfsubactivity WHERE id IN (".implode(",", $eylfSubActIdArr)."))";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getDistEylfOutcomesFromActvts($eylfActIdArr='')
	{
		$sql = "SELECT * FROM eylfoutcome WHERE id IN (SELECT DISTINCT(outcomeId) FROM eylfactivity WHERE id IN (".implode(",", $eylfActIdArr)."))";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getDevMainFromSubAct($devMilestoneSub='')
	{
		$sql = "SELECT * FROM devmilestonemain WHERE id IN (SELECT DISTINCT(milestoneid) FROM devmilestonesub WHERE id IN (".implode(",", $devMilestoneSub)."))";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getDevMileFromMain($devMilestoneMain='')
	{
		$sql = "SELECT * FROM devmilestone WHERE id IN (SELECT DISTINCT(ageId) FROM devmilestonemain WHERE id IN (".implode(",", $devMilestoneMain)."))";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getChildObservations($childid = '', $page = 0, $sort = 'DESC')
	{
		if ($page==0) {
			$sql = "SELECT DISTINCT(observationId) FROM `observationchild` WHERE childId = '".$childid."' ORDER BY observationId ".$sort;
		}else{
			$sql = "SELECT DISTINCT(observationId) FROM `observationchild` WHERE childId = '".$childid."' ORDER BY observationId ".$sort." LIMIT 10 OFFSET " . ($page - 1) * 10;
		}
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getMonSubActs($subActId='',$userId='')
	{
		if ($subActId == "") {
			$query = $this->db->query("SELECT idSubActivity AS id,title FROM montessorisubactivity");
			return $query->result();
		}else{
			$query = $this->db->query("SELECT idActivity FROM montessorisubactivity WHERE idSubActivity = $subActId");
			return $query->row();
		}
		
	}

	public function getAllStaffs()
	{
		$sql1 = "SELECT userid AS id,name, 'Staff' AS type FROM users WHERE userType = 'Staff'";
		$q1 = $this->db->query($sql1);
		return $q1->result();
	}

	public function getAllChilds()
	{
		$sql1 = "SELECT id,name, 'Child' AS type FROM child";
		$q1 = $this->db->query($sql1);
		return $q1->result();
	}

	public function insertMonSubActFromTags($obsId,$monSubId)
	{
		$array = ["observationId"=>$obsId, "idSubActivity"=>$monSubId, "assesment"=>"Introduced"];
		$this->db->delete('observationmontessori', $array);
		$this->db->insert('observationmontessori', $array);
	}

	public function checkMonAssessRecord($data=[])
	{
		$sql = "SELECT * FROM `userprogressplan` WHERE childid='".$data['child_id']."' AND subid='".$data['sub_activity_id']."'";
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function insertMonProgPlan($data='')
	{
		$insArr = [
			"childid"=>$data['child_id'],
			"activityid"=>$data['activity_id'],
			"status"=>$data['assessment'],
			"created_by"=>$data['userid'],
			"created_at"=>date("Y-m-d h:i:s"),
			"subid"=>$data['sub_activity_id']
		];
		$this->db->insert("userprogressplan",$insArr);
	}

	public function updateMonProgPlan($data='')
	{
		$updArr = [
			"childid"=>$data['child_id'],
			"activityid"=>$data['activity_id'],
			"status"=>$data['assessment'],
			"updated_by"=>$data['userid'],
			"updated_at"=>date("Y-m-d h:i:s"),
			"subid"=>$data['sub_activity_id']
		];
		$this->db->where(array("id"=>$data['id']));
		$this->db->update("userprogressplan",$updArr);
	}

	# Write By Dinesh on 02-09-2021

	function getTable(){
		$get_query = '
		SELECT *,main_child.id as child_id, main_child.name as child_name,main_child.imageUrl as image,
		ob_main.date_added as observation_date2,
		DATE_FORMAT(ob_main.date_added, "%Y-%m-%d") as observation_date,
		
		(SELECT count(*) FROM observationchild WHERE childId IN (main_child.id)) as observation_countid,

		(SELECT days FROM noticesettings WHERE centerid IN (main_centers.id)) as alter_day
			
		FROM observationchild AS ob_child

			LEFT JOIN observation AS ob_main ON ob_main.id=ob_child.observationId

			LEFT JOIN child AS main_child ON main_child.id=ob_child.childId

			LEFT JOIN room AS main_room ON main_room.id=main_child.room

			LEFT JOIN centers AS main_centers ON main_centers.id=main_room.centerid  GROUP BY child_name ;';


		$gettable_result = $this->db->query($get_query)->result();
 
		return $gettable_result;
	}

	public function changeObsStatus($data='')
	{
		if ($data->status == "1") {
			$sql = "UPDATE `observation` SET `status`='Published' WHERE id = $data->obsid";
		}else{
			$sql = "UPDATE `observation` SET `status`='Draft' WHERE id = $data->obsid";
		}
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getActTagInfo($data='')
	{
		if ($data->type == "Montessori") {
			$q = $this->db->get_where("montessorisubactivity",array("idSubActivity"=>$data->tagid));
			$extra = 1;
			$mon = 1;
		}elseif ($data->type == "Eylf"){
			$q = $this->db->get_where("eylfsubactivity",array("id"=>$data->tagid));
			$extra = 0;
		}else{
			$q = $this->db->get_where("devmilestonesub",array("id"=>$data->tagid));
			$extra = 1;
		}

		$result = $q->row();

		if($extra == 1){
				if (isset($mon)) {
					$extras = $this->db->get_where("montessoriextras",array("idSubActivity"=>$result->idSubActivity));
					$result->extras = $extras->result();
				}else{
					$extras = $this->db->get_where("devmilestoneextras",array("idsubactivity"=>$result->id));
					$result->extras = $extras->result();
				}
		}	

		return $result;
		
	}

	public function checkMonActAccess($centerid='',$actvtid='')
	{
		$q = $this->db->get_where("montessoriactivityaccess",array("centerid"=>$centerid,"idActivity"=>$actvtid));
		return $q->row();
	}

	public function checkMonSubActAccess($centerid='',$subactvtid='')
	{
		$q = $this->db->get_where("montessorisubactivityaccess",array("centerid"=>$centerid,"idSubActivity"=>$subactvtid));
		return $q->row();
	}

	public function checkMonSubActExtraAccess($centerid='',$extraid='')
	{
		$q = $this->db->get_where("montessorisubactivityextrasaccess",array("centerid"=>$centerid,"idExtra"=>$extraid));
		return $q->row();
	}

	// public function checkOutcomeAccess($centerid='',$outcomeid='')
	// {
	// 	$q = $this->db->get_where("eylfoutcomeaccess",array("centerid"=>$centerid,"outcomeid"=>$outcomeid));
	// 	return $q->row();
	// }

	public function checkActAccess($centerid='',$actvtid='')
	{
		$q = $this->db->get_where("eylfactivityaccess",array("centerid"=>$centerid,"activityid"=>$actvtid));
		return $q->row();
	}

	public function checkEylfSubActAccess($centerid='',$subactid='')
	{
		$q = $this->db->get_where("eylfsubactivityaccess",array("centerid"=>$centerid,"subactivityid"=>$subactid));
		return $q->row();
	}

	public function checkDevMileMainAccess($centerid='',$actvtid='')
	{
		$q = $this->db->get_where("devmilestonemainaccess",array("centerid"=>$centerid,"idmain"=>$actvtid));
		return $q->row();
	}

	public function checkDevMileSubAccess($centerid='',$subactvtid='')
	{
		$q = $this->db->get_where("devmilestonesubaccess",array("centerid"=>$centerid,"idsubactivity"=>$subactvtid));
		return $q->row();
	}

	public function checkDevMileSubExtraAccess($centerid='',$extraid='')
	{
		$q = $this->db->get_where("devmilestoneextrasaccess",array("centerid"=>$centerid,"idextra"=>$extraid));
		return $q->row();
	}

	public function getParentObsIds($user_id,$centerid)
	{
		$sql = "SELECT o.*,u.name as user_name,a.name as approverName FROM observation o left join users u on (u.userid=o.userId) left join users a on (a.userid=o.approver) WHERE o.centerid = ".$centerid." AND o.status = 'Published' and o.id IN (SELECT DISTINCT(observationId) FROM observationchild WHERE childId IN (SELECT DISTINCT(childid) FROM `childparent` WHERE parentid = ".$user_id."))";
		$sql.=" ORDER BY o.date_added DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}


	public function getAssessmentSettings($centerid='')
	{
		$q = $this->db->get_where("assessmentsettings",array("centerid"=>$centerid));
		return $q->row();
	}

	public function getPedagogySettings($centerid='')
	{
		$sql = "SELECT ps.pedagogy_id AS id, p.name, p.added_by FROM `pedagogy_settings` ps INNER JOIN pedagogy p ON ps.pedagogy_id = p.id WHERE ps.centerid = " . $centerid;
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function fetchSubactivityLinks($monSubActId='')
	{
		$q = $this->db->get_where("subactivity_links",array("mon_sub_act"=>$monSubActId));
		return $q->result();
	}

	public function getPedagogySubjects($pedagodyid='')
	{
		$q = $this->db->get_where('pedagogy_subjects', array('pedagogy_id'=>$pedagodyid));
		return $q->result();
	}

	public function getPedagogyActivities($pedagodysubid='')
	{
		$q = $this->db->get_where('pedagogy_activities', array('pedagogy_sub_id'=>$pedagodysubid));
		return $q->result();
	}

	public function getPedagogySubActivities($pedagodyactid='')
	{
		$q = $this->db->get_where('pedagogy_subactivities', array('pedagogy_subact_id'=>$pedagodyactid));
		return $q->result();
	}

	public function getAllObservationLinks($observationId='')
	{
		$q = $this->db->get_where('observationlinks', ['observationId'=>$observationId]);
		return $q->result();
	}

	public function getObservationInfo($obsId='')
	{
		$sql = "SELECT obs.id as obsId, obs.title, obs.status, u.userid, u.name AS approver, obs.date_added FROM `observation` obs LEFT JOIN `users` u ON obs.approver = u.userid WHERE obs.id = " . $obsId;
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function getReflectionInfo($refId='')
	{
		$sql = "SELECT ref.id as refId, ref.title, ref.status, u.userid, u.name AS approver, ref.createdAt as date_added FROM `reflection` ref LEFT JOIN `users` u ON ref.createdBy = u.userid WHERE ref.id = " . $refId;
		$q = $this->db->query($sql);
		return $q->row();
	}


	public function getDraftObservations() {
		$date = date('Y-m-d H:i:s', strtotime('-14 days'));
		
		return $this->db
			->select('id, title, date_added')
			->where('status', 'Draft')
			->where('date_added <', $date)
			->get('observation')
			->result_array();
	}
	
	public function deleteObservations($observationIds) {
		return $this->db
			->where_in('id', $observationIds)
			->delete('observation');
	}
	
	public function publishObservations($observationIds) {
		return $this->db
			->where_in('id', $observationIds)
			->update('observation', ['status' => 'Published']);
	}

	
}
?>
