<?php

/**
 * User: aviginsberg
 * IDE: PhpStorm.
 * Date: 1/28/17
 */
class man
{

    protected $preference_list = Array();
    protected $proposal_list = Array();
    protected $unique_proposal_list = Array();
    protected $mate;
    protected $is_mated = false;
    protected $my_name;

    function __construct($number_of_pairs, $my_name)
    {
        $this->my_name = $my_name;
        for ($i = 1; $i <= $number_of_pairs; $i++)
        {
            array_push($this->preference_list,"W".$i);
            shuffle($this->preference_list);
        }
    }

    function get_pref_list()
    {
        return $this->preference_list;
    }

    function log_proposal($woman)
    {
        array_push($this->proposal_list,$woman);
        if(!in_array($woman, $this->unique_proposal_list, true)){
            array_push($this->unique_proposal_list, $woman);
        }
    }

    function check_if_currently_free()
    {
        return $this->is_mated;
    }

    function get_mate()
    {
        return $this->mate;
    }

    function set_mate($woman)
    {
        $this->mate = $woman;
    }

    function set_mated_status($status)
    {
        $this->is_mated = $status;
    }

    function get_name()
    {
        return $this->my_name;
    }

    function get_proposal_list()
    {
        return $this->proposal_list;
    }

    function get_unique_proposal_list()
    {
        return $this->unique_proposal_list;
    }

    function get_best_woman_not_proposed_to()
    {
        foreach($this->preference_list as $pref)
        {
            if(!in_array($pref, $this->unique_proposal_list, true))
            {
                return $pref;
            }
        }
    }

}