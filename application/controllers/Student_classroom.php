<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_classroom extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Student_classroom_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'student_classroom/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'student_classroom/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'student_classroom/index.html';
            $config['first_url'] = base_url() . 'student_classroom/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Student_classroom_model->total_rows($q);
        $student_classroom = $this->Student_classroom_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'student_classroom_data' => $student_classroom,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('student_classroom/student_classroom_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Student_classroom_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'classroom_id' => $row->classroom_id,
		'student_id' => $row->student_id,
	    );
            $this->load->view('student_classroom/student_classroom_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('student_classroom'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('student_classroom/create_action'),
	    'id' => set_value('id'),
	    'classroom_id' => set_value('classroom_id'),
	    'student_id' => set_value('student_id'),
	);
        $this->load->view('student_classroom/student_classroom_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'classroom_id' => $this->input->post('classroom_id',TRUE),
		'student_id' => $this->input->post('student_id',TRUE),
	    );

            $this->Student_classroom_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('student_classroom'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Student_classroom_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('student_classroom/update_action'),
		'id' => set_value('id', $row->id),
		'classroom_id' => set_value('classroom_id', $row->classroom_id),
		'student_id' => set_value('student_id', $row->student_id),
	    );
            $this->load->view('student_classroom/student_classroom_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('student_classroom'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'classroom_id' => $this->input->post('classroom_id',TRUE),
		'student_id' => $this->input->post('student_id',TRUE),
	    );

            $this->Student_classroom_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('student_classroom'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Student_classroom_model->get_by_id($id);

        if ($row) {
            $this->Student_classroom_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('student_classroom'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('student_classroom'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('classroom_id', 'classroom id', 'trim|required');
	$this->form_validation->set_rules('student_id', 'student id', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Student_classroom.php */
/* Location: ./application/controllers/Student_classroom.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-03-11 13:06:09 */
/* http://harviacode.com */