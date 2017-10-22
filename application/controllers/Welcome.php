<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->model('item_model');
        $this->load->model('os_model');
    }
    
    public function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL)
    {
        $this->load->view('templates/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('templates/footer', $footerInfo);        
    }
    /**
     * Index Page for this controller.
     */
    public function index($searchText = "")
    {
        $this->global['os_list'] = $this->os_model->getAllOs();

        $this->global['pageTitle'] = 'Download App and Game free - Kohimedia';
        
        $this->load->library('pagination');
        
        $count = $this->item_model->itemListingCount($searchText);

        $returns = $this->paginationCompress ( "itemListing/", $count, 30 );
        $data['items'] = $this->item_model->itemListing($searchText, $returns["page"], $returns["segment"]);
        
        $this->loadViews("templates/index", $this->global, $data, NULL);
    }
    
    public function itemOs($osCode = "") 
    {
        $this->global['os_list'] = $this->os_model->getAllOs();

        $this->global['pageTitle'] = 'Download App and Game free - Kohimedia';
        
        $this->load->library('pagination');
        
        $os = $this->os_model->getByCode($osCode);
        
        $count = $this->item_model->itemListingOsCount($os->id);

        $returns = $this->paginationCompress ( "itemListing/", $count, 30 );
        $data['items'] = $this->item_model->itemListingOs($os->id, $returns["page"], $returns["segment"]);
        
        $this->loadViews("templates/index", $this->global, $data, NULL);        
    }

    public function itemDetail($itemId) {
        $this->global['os_list'] = $this->os_model->getAllOs();

        $item = $this->item_model->getById($itemId);
        if($item){
            $data['item'] = $item;
            $this->item_model->plusView($itemId);
        } else {
            $this->session->set_flashdata('error', 'Item is not exist!');
            redirect('/');
        }
        
        $this->global['pageTitle'] = $item->name . ' - Kohimedia';
        
        $this->loadViews("templates/item_detail", $this->global, $data, NULL);
    }
    /**
     * This function used provide the pagination resources
     * @param {string} $link : This is page link
     * @param {number} $count : This is page count
     * @param {number} $perPage : This is records per page limit
     * @return {mixed} $result : This is array of records and pagination data
     */
    private function paginationCompress($link, $count, $perPage = 10) {
            $this->load->library ( 'pagination' );

            $config ['base_url'] = base_url () . $link;
            $config ['total_rows'] = $count;
            $config ['uri_segment'] = SEGMENT;
            $config ['per_page'] = $perPage;
            $config ['num_links'] = 5;
            $config ['full_tag_open'] = '<nav><ul class="pagination">';
            $config ['full_tag_close'] = '</ul></nav>';
            $config ['first_tag_open'] = '<li class="arrow">';
            $config ['first_link'] = 'First';
            $config ['first_tag_close'] = '</li>';
            $config ['prev_link'] = 'Previous';
            $config ['prev_tag_open'] = '<li class="arrow">';
            $config ['prev_tag_close'] = '</li>';
            $config ['next_link'] = 'Next';
            $config ['next_tag_open'] = '<li class="arrow">';
            $config ['next_tag_close'] = '</li>';
            $config ['cur_tag_open'] = '<li class="active"><a href="#">';
            $config ['cur_tag_close'] = '</a></li>';
            $config ['num_tag_open'] = '<li>';
            $config ['num_tag_close'] = '</li>';
            $config ['last_tag_open'] = '<li class="arrow">';
            $config ['last_link'] = 'Last';
            $config ['last_tag_close'] = '</li>';

            $this->pagination->initialize ( $config );
            $page = $config ['per_page'];
            $segment = $this->uri->segment ( SEGMENT );

            return array (
                            "page" => $page,
                            "segment" => $segment
            );
    }
    
}
