<?php
/**
 * User: aviginsberg
 * IDE: PhpStorm.
 * Date: 1/28/17
 *
 * Avi Ginsberg
 * Monmouth University
 * CS-514 - Algorithm Design
 *
 * HW1 - Problem 4
 * Implement the stable matching algorithm.
 * Write an input generator which creates completely random preference lists, so that each M has a random permutation of the W's for preference, and vice-versa.
 * The goodness of a match for an individual can be measured by the position in the preference list of the match,w. The overall goodness for the M's would be the sum over each m , of his rank for the matching w. Similarly, the goodness for the W 's can be defined.
 *
 */
require_once "man.php";
require_once "woman.php";

//Number of pairs to generate
$number_of_pairs = 20;



$mated_men = Array();

//initialize our men and women objects
for ($i = 1; $i <= $number_of_pairs; $i++)
{
    $free_men['M'.$i] = new man($number_of_pairs,'M'.$i);
    $women['W'.$i] = new woman($number_of_pairs,'W'.$i);
}


//var_dump($free_men);

//die();

function check_for_remaining_free_men()
{
    //bring in our global vars
    global $number_of_pairs, $free_men;

    //check if we have men left in the free_men array. if not, return false.
    if (count($free_men)<=0){return false;}

    //check each man left in the free_man array to see if they have proposed to every woman
    foreach ($free_men as $freeman)
    {
        if(count($freeman->get_unique_proposal_list()) < $number_of_pairs){return true;}
    }

    //if we get here we know that there are no free men remaining so return false
    return false;
}

function logmsg($msg)
{
    echo "\n".$msg;
}

while (check_for_remaining_free_men())
{
    foreach ($free_men as $m)
    {
        $w = $m->get_best_woman_not_proposed_to();
        $manID = $m->get_name();

        //if w is free (m,w) become engaged
        if(!$women[$w]->check_if_currently_free())
        {


            //log the proposal
            $free_men[$manID]->log_proposal($w);

            //say what's going on
            logmsg("$manID proposed to $w. $w is currently free. Pairing.");

            //move the man from our free men array to mated men array
            $mated_men[$manID] = $free_men[$manID];
            unset($free_men[$manID]);

            //set the man's mate to the woman & update his status
            $mated_men[$manID]->set_mate($w);
            $mated_men[$manID]->set_mated_status(true);

            //set the woman's mate to the man & update her status
            $women[$w]->set_mate($manID);
            $women[$w]->set_mated_status(true);
        }
        //else if w is currently engaged to another man
        else
        {
            //if w prefers m' to m then m remains free
            //logmsg("checking if ".$women[$w]->get_mate()." is more desirable");
            //print_r($women[$w]->get_pref_list());
            if($women[$w]->get_pref_list_pos_of_man($women[$w]->get_mate()) < $women[$w]->get_pref_list_pos_of_man($manID))
            {
                //log the proposal
                $free_men[$manID]->log_proposal($w);

                //say what's going on
                logmsg("$manID proposed to $w. $w was already mated and preferred her current mate to $manID. $manID remains free.");
            }
            //else w prefers m to m': (m,w) become engaged and m' becomes free
            else
            {
                //log the proposal
                $free_men[$manID]->log_proposal($w);

                //mark m' as free and put back in free men array
                $m_prime_ID = $women[$w]->get_mate();
                //move the man from our mated men array to free men array
                $free_men[$m_prime_ID] = $mated_men[$m_prime_ID];
                unset($mated_men[$m_prime_ID]);
                //mark man as free and remove mate info
                $free_men[$m_prime_ID]->set_mate(NULL);
                $free_men[$m_prime_ID]->set_mated_status(false);

                //pair (m,w)
                //move the man from our free men array to mated men array
                $mated_men[$manID] = $free_men[$manID];
                unset($free_men[$manID]);

                //set the man's mate to the woman & update his status
                $mated_men[$manID]->set_mate($w);
                $mated_men[$manID]->set_mated_status(true);

                //set the woman's mate to the man (no need to update her status)
                $women[$w]->set_mate($manID);

                //say what's going on
                logmsg("$manID proposed to $w. $w preferred $manID to her old mate $m_prime_ID. $manID is now engaged to $w.");
            }
        }




    }


}


$m_goodness_sum = 0;
$w_goodness_sum = 0;

echo "\n\n\n\n\nPrinting final pairs:\n";
foreach($mated_men as $m)
{
    $m_name = $m->get_name();
    $w_name = $m->get_mate();
    $m_match_goodness = $m->get_match_goodness();
    $m_goodness_sum += $m_match_goodness;
    $w_match_goodness = $women[$w_name]->get_match_goodness();
    $w_goodness_sum += $w_match_goodness;
    echo "\n$m_name is engaged to ".$m->get_mate()." | man match goodness: $m_match_goodness | woman match goodness: $w_match_goodness";
}

echo "\n\nAverage man match goodness: ".(round(($m_goodness_sum/$number_of_pairs),3)).
        "\nAverage woman match goodness: ".(round(($w_goodness_sum/$number_of_pairs),3));













