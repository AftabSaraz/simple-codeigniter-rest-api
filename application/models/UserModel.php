<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

    public function offers()
    {
        $offers = $this->db->select('*')->from('offers')->get()->result_array();
        if($offers){
			return array('status' => 200,'message' => "Offers",'total ofers '=>count($offers),'data'=>$offers);
        }else{
            return array('status' => 400,'message' => "Offers not availble");
        } 
    }
    public function addCustomerAddress($data)
    { 
        if(count($data) ==1){
            return array('status' => 400,'message' => 'Data is required.');
        }else{
            $result  = $this->db->insert('customer_addresses',$data);
            if($result){
                return array('status' => 200,'message' => 'Address added Successfully');
            }else{
                return array('status' => 400,'message' => 'Address Not added,try again');
            }
        } 
    }
    public function getCustomerAddresses($data)
    { 
        if(count($data) ==1 && $data['user_id']){
            $customer_addresses = $this->db->select('*')->from('customer_addresses')->where('user_id',$data['user_id'])->get()->result_array();
            if($customer_addresses){
                return array('status' => 200,'message' => 'Customer Addresses','Tolat Customer Addresses'=>count($customer_addresses),'data'=>$customer_addresses);
            }else{
                return array('status' => 400,'message' => 'Address Not added,try again');
            }
        }else{
            return array('status' => 400,'message' => "Address Not availble");
        } 
    }
    public function updateCustomerAddressLabel($data)
    {   
        $required = ['label','address_id'];
        if (count($data)==1) { return array('status' => 400,'message' =>"label and address_id is required"); } 
        foreach($required as $column){
            if (!array_key_exists($column, $data)) {
                return array('status' => 400,'message' => "$column field is required");
            } else if(trim($data[$column]) === '') {
                return array('status' => 400,'message' => "$column can not be empty");
            }
        }
        $user_id = $data['user_id'];
        $address_id = $data['address_id'];
        unset($data['address_id']);
        unset($data['address_id']);
        $this->db->set($data);
        $this->db->where(['address_id'=>$address_id,'user_id'=>$user_id]);
        $result = $this->db->update('customer_addresses'); 
        if($result){
            return array('status' => 200,'message' => "Data has been updated");
        }else{
            return array('status' => 400,'message' => "Data not Updated");
        }
    }
}
