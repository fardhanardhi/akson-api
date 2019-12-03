<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_api extends CI_Model
{

  public function getScoreList()
  {
    $db_akson = $this->load->database('db_akson', TRUE);
    $db_akson->select('score');
    return $db_akson->get('score')->result();
  }

  public function getScoreListByUser($idUser)
  {
    $db_akson = $this->load->database('db_akson', TRUE);
    $db_akson->select('score');
    $db_akson->where('id_user', $idUser);
    return $db_akson->get('score')->result();
  }

  public function countGlobalScoreList($age)
  {
    $db_akson = $this->load->database('db_akson', TRUE);
    $db_akson->select('score');
    $db_akson->where('age', $age);
    return $db_akson->get('score')->num_rows();
  }

  public function countUserScoreList($idUser)
  {
    $db_akson = $this->load->database('db_akson', TRUE);
    $user = $db_akson->select('age');
    $user->where('id', $idUser);
    $hUser = $user->get('user')->row();

    $db_akson = $this->load->database('db_akson', TRUE);
    $db_akson->select('score');
    $db_akson->where('age', $hUser->age);
    $db_akson->where('id_user', $idUser);
    return $db_akson->get('score')->num_rows();
  }

  public function globalAvgScoreList($age)
  {
    $db_akson = $this->load->database('db_akson', TRUE);
    $db_akson->select('age');
    $db_akson->where('age', $age);
    $db_akson->select_avg('score');
    return $db_akson->get('score')->row();
  }

  public function userAvgScoreList($idUser)
  {
    $db_akson = $this->load->database('db_akson', TRUE);
    $user = $db_akson->select('age');
    $user->where('id', $idUser);
    $hUser = $user->get('user')->row();

    $db_akson->select('age');
    $db_akson->where('age', $hUser->age);
    $db_akson->where('id_user', $idUser);
    $db_akson->select_avg('score');
    return $db_akson->get('score')->row();
  }

  public function addScore($score, $idUser, $age)
  {
    $db_akson = $this->load->database('db_akson', TRUE);

    $data = [
      'score' => $score,
      'id_user' => $idUser,
      'age' => $age
    ];
    $db_akson->insert('score', $data);
  }

  public function checkUser($username)
  {
    $db_akson = $this->load->database('db_akson', TRUE);

    $db_akson->select('id, username, age');
    $db_akson->where('username', $username);

    return $db_akson->get('user')->row();
  }

  public function createUser($username, $age)
  {
    $db_akson = $this->load->database('db_akson', TRUE);

    $data = [
      'username' => $username,
      'age' => $age
    ];
    $db_akson->insert('user', $data);
  }

  public function getUser()
  {
    $db_akson = $this->load->database('db_akson', TRUE);
    $db_akson->select('username, age');
    return $db_akson->get('user')->result();
  }

  public function updateAge($idUser, $newAge)
  {
    $db_akson = $this->load->database('db_akson', TRUE);
    $db_akson->set('age', $newAge);
    $db_akson->where('id', $idUser);
    $db_akson->update('user');
  }
}
