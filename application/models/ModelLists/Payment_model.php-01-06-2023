<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends My_Model {
    var $column_order = array(null,'emp.name_of_card','emp.email','emp.transaction_id','emp.subscription_id','emp.amount','emp.payment_date','emp.payment_status',null); //set column field database for datatable orderable

    var $order = array('emp.id' => 'DESC');

    function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select('emp.*,subscription.subscription_name,users.companyname');
        $this->db->from('employer_subscription as emp');
        $this->db->join('subscription',"subscription.id=emp.subscription_id",'left');
        $this->db->join('users',"users.userId=emp.employer_id");
        $i = 0;

        if($_POST['search']['value']) // if datatable send POST for search
        {
            $explode_string = explode(' ', $_POST['search']['value']);
            foreach ($explode_string as $show_string)
            {
                $cond  = " ";
                $cond.=" ( emp.name_of_card LIKE '%".trim($show_string)."%' ";
                $cond.=" OR  emp.email LIKE '%".trim($show_string)."%' ";
                $cond.=" OR  subscription.subscription_name LIKE '%".trim($show_string)."%' ";
                $cond.=" OR  emp.payment_status LIKE '%".trim($show_string)."%') ";
                $this->db->where($cond);
            }
        }
        $i++;

        if(isset($_POST['order'])) // here order processing
        {
            //print_r($this->column_order);exit;
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        //$this->db->where($cond);
        return $query->result();
    }

    public function count_all()
    {
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }


    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
}
