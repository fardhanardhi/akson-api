<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_opr extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_refueling($nrp)
	{
		$db_opr = $this->load->database('db_opr',TRUE);
		$db_opr->where('nrp',$nrp);
		$db_opr->where('date(tanggal)>=',date('Y-m-d',strtotime("-1 days")));
		$db_opr->order_by('tanggal desc');
		return $db_opr->get('tbl_t_refueling')->result();
	}

	public function get_all_unit()
	{
		$db_opr = $this->load->database('db_opr',TRUE);
		$db_opr->select('code_number');
		$db_opr->order_by('code_number asc');
		return $db_opr->get('vw_unit')->result();
	}

	public function get_cn($type)
	{
		$db_opr = $this->load->database('db_opr',TRUE);
		$db_opr->select('code_number');
		$db_opr->where('type',$type);
		$db_opr->order_by('code_number asc');
		return $db_opr->get('vw_unit')->result();
	}

	public function insert_refueling($nrp,$ft,$cn,$volume,$lokasi)
	{
		$db_opr = $this->load->database('db_opr',TRUE);
		$db_opr->query("call sp_insert_refueling('".$nrp."','".$ft."','".$cn."','".$volume."','".$lokasi."')");
	}

	public function get_fuelman()
	{
		$db_opr = $this->load->database('db_opr',TRUE);
		return $db_opr->get('vw_fuelman')->result();
	}

	public function get_nama($posisi)
	{
		$db_opr = $this->load->database('db_opr',TRUE);
		$db_opr->select('nrp,nama,concat(nrp," - ",nama) as alias');
		$db_opr->like('posisi',$posisi);
		return $db_opr->get('db_hrga.vw_karyawan')->result();
	}

	public function get_cn_type($key)
	{
		$db_opr = $this->load->database('db_opr',TRUE);
		$db_opr->where('type',$key);
		return $db_opr->get('vw_unit')->result();
	}

	public function insert_fuelman($nrp,$ft)
	{
		$db_opr = $this->load->database('db_opr',TRUE);
		$db_opr->query('call sp_insert_fuelman("'.$nrp.'","'.$ft.'")');
	}

	public function update_fuelman($nrp,$ft)
	{
		$db_opr = $this->load->database('db_opr',TRUE);
		$db_opr->set('ft',$ft);
		$db_opr->where('nrp',$nrp);
		$db_opr->update('tbl_m_fuelman');
	}

	public function delete_fuelman($nrp)
	{
		$db_opr = $this->load->database('db_opr',TRUE);
		$db_opr->set('enable_login','0');
		$db_opr->where('nrp',$nrp);
		$db_opr->update('db_dcl.tbl_m_user');
	}

	public function get_excavator_set($tanggal,$shift)
	{
		$db_opr = $this->load->database('db_opr',TRUE);
		return $db_opr->query("call sp_get_excavator_set('".$tanggal."','".$shift."')")->result_array();
	}

	public function get_excavator_prod($tanggal,$shift)
	{
		$db_opr = $this->load->database('db_opr',TRUE);
		return $db_opr->query("call sp_get_excavator_prod('".$tanggal."','".$shift."')")->result_array();
	}

}