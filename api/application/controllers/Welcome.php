<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function updatePedagogyData(){
		$this->load->database();

		$q = $this->db->query("SELECT * FROM montessorisubjects");
		
		foreach ($q->result() as $sub){
			$subjectId = $sub->idSubject;
			echo "SubjectId : ".$subjectId."<br>";
			$qa = $this->db->query("SELECT * FROM montessoriactivity WHERE idSubject = $subjectId");
			
			foreach ($qa->result() as $act){
				$activityId = $act->idActivity;
				echo "ActivityId : ".$activityId."<br>";
				$qs = $this->db->query("SELECT * FROM montessorisubactivity WHERE idActivity = $activityId");
				
				foreach ($qs->result() as $sact){
					$subactivityId = $sact->idSubActivity;
					echo "SubactivityId : ".$subactivityId."<br>";
				}
			}
		}
	}
}
