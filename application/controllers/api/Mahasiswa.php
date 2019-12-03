<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends CI_Controller
{
  use REST_Controller {
  REST_Controller::__construct as private __resTraitConstruct;
  }

  function __construct()
  {
    parent::__construct();
    $this->__resTraitConstruct();

    $this->load->model('Mahasiswa_model');
  }

  public function index_get()
  {
    $mahasiswa = $this->Mahasiswa_model->getMahasiswa();
    $this->response($mahasiswa, 200); // OK (200) being the HTTP response code
    // ($mahasiswa);
  }
}
