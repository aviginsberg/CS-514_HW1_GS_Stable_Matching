<?php

/**
 * User: aviginsberg
 * IDE: PhpStorm.
 * Date: 1/28/17
 */
class woman
{
    protected $preference_list=Array();
    protected $mate;
    protected $is_mated = false;
    protected $my_name;


    function __construct($number_of_pairs, $my_name)
    {
        $this->my_name = $my_name;
        for ($i = 1; $i <= $number_of_pairs; $i++)
        {
            array_push($this->preference_list,"M".$i);
            shuffle($this->preference_list);
        }
    }

    function get_pref_list()
    {
        return $this->preference_list;
    }

    function get_pref_list_pos_of_man($man)
    {
       return array_search($man, $this->preference_list);
    }

    function check_if_currently_free()
    {
        return $this->is_mated;
    }

    function get_mate()
    {
        return $this->mate;
    }

    function set_mate($man)
    {
        $this->mate = $man;
    }

    function set_mated_status($status)
    {
        $this->is_mated = $status;
    }

    function get_name()
    {
        return $this->my_name;
    }

}