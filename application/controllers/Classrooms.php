<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Classrooms extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Classrooms_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'classrooms/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'classrooms/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'classrooms/index.html';
            $config['first_url'] = base_url() . 'classrooms/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Classrooms_model->total_rows($q);
        $classrooms = $this->Classrooms_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'classrooms_data' => $classrooms,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('classrooms/classrooms_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Classrooms_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'room' => $row->room,
	    );
            $this->load->view('classrooms/classrooms_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('classrooms'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('classrooms/create_action'),
	    'id' => set_value('id'),
	    'room' => set_value('room'),
	);
        $this->load->view('classrooms/classrooms_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'room' => $this->input->post('room',TRUE),
	    );

            $this->Classrooms_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('classrooms'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Classrooms_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('classrooms/update_action'),
		'id' => set_value('id', $row->id),
		'room' => set_value('room', $row->room),
	    );
            $this->load->view('classrooms/classrooms_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('classrooms'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'room' => $this->input->post('room',TRUE),
	    );

            $this->Classrooms_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('classrooms'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Classrooms_model->get_by_id($id);

        if ($row) {
            $this->Classrooms_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('classrooms'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('classrooms'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('room', 'room', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Classrooms.php */
/* Location: ./application/controllers/Classrooms.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-03-11 12:03:21 */
/* http://harviacode.com */