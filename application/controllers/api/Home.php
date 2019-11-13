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

  public function scoreAvg_get()
  {
    $totalScoreList = $this->M_api->countScoreList();
    $avgScoreList = $this->M_api->avgScoreList();
    $result = [
      'average' => $avgScoreList->score,
      'total' => $totalScoreList,
    ];
    $this->response($result, 200);
  }

  public function addScore_get($score)
  {
    // $score = $this->get('score');

    $this->M_api->addScore($score);

    $result = [
      'message' => 'Success'
    ];

    $this->response($result, 200);
  }
}
