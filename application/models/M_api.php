<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_api extends CI_Model
{

  public function getScoreList()
  {
    $db_akson = $this->load->database('db_akson', TRUE);
    $db_akson->select('score');
    return $db_akson->get('user')->result();
  }

  public function countScoreList()
  {
    $db_akson = $this->load->database('db_akson', TRUE);
    $db_akson->select('score');
    return $db_akson->get('user')->num_rows();
  }

  public function avgScoreList()
  {
    $db_akson = $this->load->database('db_akson', TRUE);
    $db_akson->select_avg('score');
    return $db_akson->get('user')->row();
  }

  public function addScore($score)
  {
    $db_akson = $this->load->database('db_akson', TRUE);

    $data = [
      'score' => $score
    ];
    $db_akson->insert('user', $data);
  }
}
