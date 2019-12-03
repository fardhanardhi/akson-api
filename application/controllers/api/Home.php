<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");


class Home extends CI_Controller
{
  use REST_Controller {
    REST_Controller::__construct as private __resTraitConstruct;
  }

  function __construct()
  {
    parent::__construct();
    $this->__resTraitConstruct();

    // Load these helper to create JWT tokens
    $this->load->helper(['jwt', 'authorization']);

    $this->load->model('M_sys');
    $this->load->model('M_api');
    $this->load->model('M_opr');
  }

  public function scoreList_get()
  {
    $scoreList = $this->M_api->getScoreList();
    $this->response($scoreList, 200);
  }

  public function scoreListByUser_get($idUser)
  {
    $scoreList = $this->M_api->getScoreListByUser($idUser);
    $this->response($scoreList, 200);
  }

  public function globalScoreAvg_get($age)
  {
    $totalScoreList = $this->M_api->countGlobalScoreList($age);
    $avgScoreList = $this->M_api->globalAvgScoreList($age);
    $result = [
      'average' => $avgScoreList->score,
      'total' => $totalScoreList,
    ];
    $this->response($result, 200);
  }

  public function userScoreAvg_get($idUser)
  {
    $totalScoreList = $this->M_api->countUserScoreList($idUser);
    $avgScoreList = $this->M_api->userAvgScoreList($idUser);
    $result = [
      'average' => $avgScoreList->score,
      'total' => $totalScoreList,
    ];
    $this->response($result, 200);
  }

  public function addScore_get($score, $idUser, $age)
  {
    // $score = $this->get('score');

    $this->M_api->addScore($score, $idUser, $age);

    $result = [
      'message' => 'Success'
    ];

    $this->response($result, 200);
  }

  public function checkUser_get($username)
  {
    $user =  $this->M_api->checkUser($username);
    if ($user != null) {
      $result = [
        'available' => true,
        'id' => $user->id,
        'username' => $username,
        'age' => $user->age
      ];
    } else {
      $result = [
        'available' => false
      ];
    }

    $this->response($result, 200);
  }

  public function createUser_get($username, $age)
  {
    $userCount =  $this->M_api->checkUser($username);
    $result = [];
    if ($userCount > 0) {
      $result = [
        'message' => 'Username already taken'
      ];
    } else {
      $this->M_api->createUser($username, $age);

      $result = [
        'message' => 'Success'
      ];
    }
    $this->response($result, 200);
  }

  public function user_get()
  {
    $user = $this->M_api->getUser();
    $this->response($user, 200);
  }

  public function updateAge_get($idUser, $newAge)
  {
    $user = $this->M_api->updateAge($idUser, $newAge);
    $this->response($user, 200);
  }
}
