<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    private $recaptcha_secret = "6LcoiJEqAAAAAG_UIxK766CXoB4VvK-5Iu0ocm39";

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
        $this->load->library('form_validation');
        $this->load->database();
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            $this->redirect_by_role(); // Rolüne göre yönlendir
        }

        $this->load->view('login'); // Giriş sayfasını yükle
    }

    public function authenticate()
    {
        $this->form_validation->set_rules('username', 'Kullanıcı Adı', 'required');
        $this->form_validation->set_rules('password', 'Şifre', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login');
        } else {
            // reCAPTCHA doğrulaması
            $captcha_response = $this->input->post('g-recaptcha-response');
            if (!$this->verify_recaptcha($captcha_response)) {
                $this->session->set_flashdata('error', 'reCAPTCHA doğrulaması başarısız oldu.');
                redirect('login');
            }

            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $query = $this->db->get_where('users', array('username' => $username));
            $user = $query->row();

            if ($user && password_verify($password, $user->password)) {
                $session_data = array(
                    'id'       => $user->id,
                    'username' => $user->username,
                    'email'    => $user->email,
                    'role'     => $user->role,
                    'logged_in' => true
                );
                $this->session->set_userdata($session_data);

                $this->redirect_by_role(); // Rolüne göre yönlendir
            } else {
                $this->session->set_flashdata('error', 'Geçersiz kullanıcı adı veya şifre');
                redirect('login');
            }
        }
    }

    private function verify_recaptcha($captcha_response)
    {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $data = array(
            'secret' => $this->recaptcha_secret,
            'response' => $captcha_response
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response);

        return isset($result->success) && $result->success;
    }

    private function redirect_by_role()
    {
        $role = $this->session->userdata('role');
        if ($role == 'admin') {
            redirect('admin');
        } else {
            redirect('dashboard');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
