<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_sys extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function login($nrp, $password, $passwordenc)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->query("call sp_login('" . $nrp . "','" . $password . "','" . $passwordenc . "',@status,@gmenu,@nama,@departemen,@posisi)");
    return $db_sys->query('select @status as p_status, @gmenu as p_gmenu, @nama as p_nama, @departemen as p_departemen, @posisi as p_posisi')->result();
  }

  public function get_menu($nrp)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->where('nrp', $nrp);
    return $db_sys->get('vw_menu')->result();
  }

  public function change_password($nrp, $password)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->query("call sp_change_password('" . $nrp . "','" . $password . "')");
  }

  public function get_dash_pld($gmenu)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    return $db_sys->query("call sp_get_dash_pld('" . $gmenu . "')")->result();
  }

  public function get_dash_trend($gmenu)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    return $db_sys->query("call sp_get_dash_trend('" . $gmenu . "')")->result();
  }

  public function get_users($nrp)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->where('nrp!=', $nrp);
    return $db_sys->get('vw_user')->result();
  }

  public function modify_access($nrp)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    if (substr($nrp, -1) == 1) {
      // disable
      $db_sys->where('nrp', substr($nrp, 0, strlen($nrp) - 1));
      $db_sys->delete('tbl_m_user');
    } else if (substr($nrp, -1) == 0) {
      // enable
      $data = array('nrp' => substr($nrp, 0, strlen($nrp) - 1));
      $db_sys->insert('tbl_m_user', $data);
    }
  }

  public function need_to_appr($nrp)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->where('nrp', $nrp);
    $db_sys->where('status', 1);
    return $db_sys->get('vw_approval')->result();
  }

  public function do_approvement($appr, $id, $status, $note, $nrp, $level)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->query("call sp_do_approvement('" . $appr . "','" . $id . "','" . $status . "','" . $note . "','" . $nrp . "','" . $level . "')");
  }

  public function get_nrp_bawahan($level, $nrp, $dept)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->select("nrp, concat(nrp,' - ',nama) as lbl");
    if ($level == 'SM') {
      $db_sys->where("nrp!=''");
      $array = array('SH', 'SM');
      $db_sys->where_in('gmenu', $array);
    } else if ($level == 'SH') {
      $array = array('SH', 'GL', 'MAIN');
      $db_sys->where_in('gmenu', $array);
      $db_sys->where('dept', $dept);
    } else if ($level == 'GL') {
      $array = array('GL', 'MAIN');
      $db_sys->where_in('gmenu', $array);
      $db_sys->where('dept', $dept);
    } else if ($level == 'MAIN') {
      $db_sys->where('nrp', $nrp);
    }
    return $db_sys->get('vw_karyawan')->result();
  }

  public function insert_revisi_abs($nrp, $tanggal, $in, $out, $lokasi, $ket)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->query("call sp_insert_appr_abs_web('" . $nrp . "','" . $tanggal . "','" . $in . "','" . $out . "','" . $lokasi . "','" . $ket . "')");
  }

  public function get_modified_pass($nrp)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    return $db_sys->query("select case when defined_password is NULL then 1 else 1 end as pwd from vw_user where nrp = '" . $nrp . "'")->result();
  }

  public function get_pic_approval()
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->select('nrp,nama,dept,jabatan');
    $db_sys->where('appr_abs', 1);
    return $db_sys->get('vw_karyawan')->result();
  }

  public function get_nama_from($dept, $level)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->select("nrp, nama as nm, concat(nrp,' - ',nama) as nama");
    $db_sys->where('dept', $dept);
    $db_sys->where('appr_abs', NULL);
    $db_sys->where_in('gmenu', $level);
    $db_sys->order_by('nm ASC');
    return $db_sys->get('vw_karyawan')->result();
  }

  public function insert_pic_abs($nrp)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->query("insert into tbl_m_pic_approval (nrp,abs) values ('" . $nrp . "',1) on duplicate key update abs = 1");
  }

  public function remove_pic_abs($nrp)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->set('abs', NULL);
    $db_sys->where('nrp', $nrp);
    $db_sys->update('tbl_m_pic_approval');
  }

  public function get_rpt_rev_abs($level, $dept)
  {
    $db_sys = $this->load->database('db_sys', TRUE);

    if ($level == 'SH') {
      $db_sys->where_in('gmenu', array('SH', 'GL', 'MAIN'));
      $db_sys->where('dept', $dept);
    } else if ($level == 'GL') {
      $db_sys->where_in('gmenu', array('GL', 'MAIN'));
      $db_sys->where('dept', $dept);
    }
    return $db_sys->get('vw_revisi_abs')->result();
  }

  public function get_rpt_rev_abs_filter($level, $dept)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->where('dept', $dept);
    return $db_sys->get('vw_revisi_abs')->result();
  }

  public function get_revisi($nrp)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->where('nrp', $nrp);
    return $db_sys->get('vw_revisi_abs')->result();
  }

  public function get_need_appr_count($nrp)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->select('count(nrp)');
    $db_sys->where('status', 1);
    $db_sys->where('nrp', $nrp);
    return $db_sys->get('tbl_t_approval')->result();
  }

  public function update_level_user($nrp, $level)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->set('granted', $level);
    $db_sys->where('nrp', $nrp);
    $db_sys->update('tbl_m_user');
  }

  public function reset_password($nrp)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->set('password', NULL);
    $db_sys->where('nrp', $nrp);
    $db_sys->update('tbl_m_user');
  }

  public function add_user($nrp)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->query("insert into tbl_m_user (nrp, enable_login) values ('" . $nrp . "',1) on duplicate key update enable_login = 1");
  }

  public function disable_user($nrp)
  {
    $db_sys = $this->load->database('db_sys', TRUE);
    $db_sys->set('enable_login', NULL);
    $db_sys->where('nrp', $nrp);
    $db_sys->update('tbl_m_user');
  }
}
