<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Students extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Students_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'students/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'students/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'students/index.html';
            $config['first_url'] = base_url() . 'students/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Students_model->total_rows($q);
        $students = $this->Students_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'students_data' => $students,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('students/students_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Students_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'name' => $row->name,
		'email' => $row->email,
		'birdthdate' => $row->birdthdate,
	    );
            $this->load->view('students/students_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('students'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('students/create_action'),
	    'id' => set_value('id'),
	    'name' => set_value('name'),
	    'email' => set_value('email'),
	    'birdthdate' => set_value('birdthdate'),
	);
        $this->load->view('students/students_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
		'email' => $this->input->post('email',TRUE),
		'birdthdate' => $this->input->post('birdthdate',TRUE),
	    );

            $this->Students_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('students'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Students_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('students/update_action'),
		'id' => set_value('id', $row->id),
		'name' => set_value('name', $row->name),
		'email' => set_value('email', $row->email),
		'birdthdate' => set_value('birdthdate', $row->birdthdate),
	    );
            $this->load->view('students/students_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('students'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
		'email' => $this->input->post('email',TRUE),
		'birdthdate' => $this->input->post('birdthdate',TRUE),
	    );

            $this->Students_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('students'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Students_model->get_by_id($id);

        if ($row) {
            $this->Students_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('students'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('students'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('name', 'name', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('birdthdate', 'birdthdate', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Students.php */
/* Location: ./application/controllers/Students.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-03-11 12:03:27 */
/* http://harviacode.com */