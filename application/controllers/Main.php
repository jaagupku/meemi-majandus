<?php

class Main extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('cloudinarylib');
        $this->load->model('meme_model');
    }

    public function index() {
      redirect('/hot');
    }

    public function hot($from=0, $amount=20) {
      $this->_display_memes($this->meme_model->get_hot_memes($from, $amount), "Hot");
    }

    public function top($from=0, $amount=20) {
      $this->_display_memes($this->meme_model->get_top_memes($from, $amount), "Top");
    }

    public function new_memes($from=0, $amount=20) {
      $this->_display_memes($this->meme_model->get_new_memes($from, $amount), "New");
    }

    private function _display_memes($memes, $title) {
      $data['memes'] = $memes;

      foreach ($data['memes'] as $key => $row) {
        $data['memes'][$key]['Data']=$this->cloudinarylib->get_html_data($row['Data_Type'], $row['Data']);
      }

      $this->load->view('pages/header', array('username' => $this->session->username, 'title' => $title));
      $this->load->view('pages/testmemebody.php', $data);
      $this->load->view('pages/footer.php');
    }
}
