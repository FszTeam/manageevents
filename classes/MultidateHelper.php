<?php

namespace FszTeam\ManageEvents\Classes;

use Carbon\Carbon;

/**
 * This class parses multidate possibilities
 * Requires min php 5.3.
 *
 * @author ChadStrat
 */
class MultidateHelper
{
    public function __construct($date_string, $recur, $thru)
    {
	    if(!is_array($date_string)){$date_string = json_decode($date_string,true);}$xa = $date_string; $dcount = count($xa['date']); $esst = new Carbon($xa['date'][0]); $ess = $esst->format('Y-m-d'); if ($recur && $recur != 'none') { $xs = array(); $excluded_dates = array(); $eet = new Carbon($thru); $ee = $eet->format('Y-m-d'); $diff = $esst->diff($eet); $xpn = $diff->days; $monthspan = $diff->m * $dcount; $mc = 0; $wc = 0; $wk = true; $iti = 0; if ($xpn > 7) { $xpn = $xpn + 1; } for ($d = 0;$d <= $xpn;$d += 1) { $iti++; $xn = date('Y-m-d', strtotime($esst)); if (!in_array($xn, $excluded_dates)) { switch ($recur) {case 'daily': $di = 0; foreach ($xa['date'] as $key => $esd) { $di++; $xs[$di][$iti]['date'] = $xn; $xs[$di][$iti]['sttime'] = $xa['sttime'][$key]; $xs[$di][$iti]['entime'] = $xa['entime'][$key]; $xs[$di][$iti]['dsID'] = $di; } break; case 'weekly': $di = 0; foreach ($xa['date'] as $key => $esd) { $di++; $es = date('Y-m-d', strtotime($esd)); $dvDd = date('D', strtotime($es)); $xnD = date('D', strtotime($xn)); if ($xnD == $dvDd) { $xs[$di][$iti]['date'] = $xn; $xs[$di][$iti]['sttime'] = $xa['sttime'][$key]; $xs[$di][$iti]['entime'] = $xa['entime'][$key]; $xs[$di][$iti]['dsID'] = $di; } } break; case 'every_other_week': $di = 0; foreach ($xa['date'] as $key => $esd) { $di++; $es = date('Y-m-d', strtotime($esd)); $dvDd = date('D', strtotime($es)); $xnD = date('D', strtotime($xn)); if ($xnD == $dvDd && $wk == true) { $xs[$di][$iti]['date'] = $xn; $xs[$di][$iti]['sttime'] = $xa['sttime'][$key]; $xs[$di][$iti]['entime'] = $xa['entime'][$key]; $xs[$di][$iti]['dsID'] = $di; $wc++; if ($wc == count($xa['date'])) { $wk = false; $wc = 0; } } elseif ($xnD == $dvDd && $wk == false) { $wc++; if ($wc == count($xa['date'])) { $wk = true; $wc = 0; } } } break; case 'monthly': $xnm = date('Y-m', strtotime($xn)); $xnmDay = date('d', strtotime($xn)); $g_array = array('01','08','15','22','29'); $di = 0; foreach ($xa['date'] as $key => $esd) { if ($mc < $monthspan) { $di++; $es = date('Y-m-d', strtotime($esd)); $esi = date('Y-m-d', strtotime($esd)); $dvm = date('Y-m', strtotime($es)); $dvD = date('d', strtotime($es)); $dvDa = date('D', strtotime($es)); $dvDaL = date('l', strtotime($es)); $dfd = date('Y-m-d', strtotime($dvm.'-01')); $dvDa = date('D', strtotime($dfd)); $mf = date('Y-m-d', strtotime($xnm.'-01')); $monthD = date('d', strtotime($mf)); $monthDa = date('D', strtotime($mf)); $dfd = date('Y-m-d', strtotime($dvm.'-01')); $em = date('m', strtotime($mf)); $g_first = 'first '; $g_second = 'second '; $g_third = 'third '; $g_fourth = 'fourth '; $g_fifth = 'fifth '; if (in_array($xnmDay, $g_array) && !in_array($dvD, $g_array)) { if ($xnmDay == '01') { $g_first = '+0 week '; $g_second = 'first '; $g_third = 'second '; $g_fourth = 'third '; $g_fifth = 'fourth '; $es = date('Y-m-d', strtotime('+0 week ', strtotime($es))); } else { $g_first = 'first '; $g_second = 'second '; $g_third = 'third '; $g_fourth = 'fourth '; $g_fifth = 'fifth '; $es = date('Y-m-d', strtotime('-1 week ', strtotime($es))); } } if (in_array($dvD, $g_array) && !in_array($xnmDay, $g_array)) { $es = date('Y-m-d', strtotime('+1 week ', strtotime($es))); } elseif (in_array($dvD, $g_array) && $xnmDay == '01') { $g_first = '+0 week '; $es = date('Y-m-d', strtotime('+0 week ', strtotime($es))); } if ($es == date('Y-m-d', strtotime($g_first.$dvDaL.'', strtotime($dfd)))) { if ($xn == date('Y-m-d', strtotime($g_first.$dvDaL.'', strtotime($mf)))) { $xs[$di][$iti]['date'] = $xn; $xs[$di][$iti]['sttime'] = $xa['sttime'][$key]; $xs[$di][$iti]['entime'] = $xa['entime'][$key]; $xs[$di][$iti]['dsID'] = $di; $mc++; } } elseif ($es == date('Y-m-d', strtotime($g_second.$dvDaL.'', strtotime($dfd)))) { if ($xn == date('Y-m-d', strtotime($g_second.$dvDaL.'', strtotime($mf)))) { $xs[$di][$iti]['date'] = $xn; $xs[$di][$iti]['sttime'] = $xa['sttime'][$key]; $xs[$di][$iti]['entime'] = $xa['entime'][$key]; $xs[$di][$iti]['dsID'] = $di; $mc++; } } elseif ($es == date('Y-m-d', strtotime($g_third.$dvDaL.'', strtotime($dfd)))) { if ($xn == date('Y-m-d', strtotime($g_third.$dvDaL.'', strtotime($mf)))) { $xs[$di][$iti]['date'] = $xn; $xs[$di][$iti]['sttime'] = $xa['sttime'][$key]; $xs[$di][$iti]['entime'] = $xa['entime'][$key]; $xs[$di][$iti]['dsID'] = $di; $mc++; } } elseif ($es == date('Y-m-d', strtotime($g_fourth.$dvDaL.'', strtotime($dfd)))) { if ($xn == date('Y-m-d', strtotime($g_fourth.$dvDaL.'', strtotime($mf)))) { $xs[$di][$iti]['date'] = $xn; $xs[$di][$iti]['sttime'] = $xa['sttime'][$key]; $xs[$di][$iti]['entime'] = $xa['entime'][$key]; $xs[$di][$iti]['dsID'] = $di; $mc++; } } elseif ($es == date('Y-m-d', strtotime($g_fifth.$dvDaL.'', strtotime($dfd)))) { if ($xn == date('Y-m-d', strtotime($g_fifth.$dvDaL.'', strtotime($mf)))) { $xs[$di][$iti]['date'] = $xn; $xs[$di][$iti]['sttime'] = $xa['sttime'][$key]; $xs[$di][$iti]['entime'] = $xa['entime'][$key]; $xs[$di][$iti]['dsID'] = $di; $mc++; } } } } break; case 'yearly': $di = 0; foreach ($xa['date'] as $key => $esd) { $di++; $es = date('Y-m-d', strtotime($esd)); $xny = date('m-d', strtotime($xn)); $dvy = date('m-d', strtotime($es)); if ($xny == $dvy) { $xs[$di][$iti]['date'] = $xn; $xs[$di][$iti]['sttime'] = $xa['sttime'][$key]; $xs[$di][$iti]['entime'] = $xa['entime'][$key]; $xs[$di][$iti]['dsID'] = $di; } } break; } } $esst->addDay(); } $this->dates = $xs; } else { foreach ($xa['date'] as $key => $esd) { $xs[0][$key]['date'] = $esd; $xs[0][$key]['sttime'] = $xa['sttime'][$key]; $xs[0][$key]['entime'] = $xa['entime'][$key]; $xs[0][$key]['dsID'] = 0; } $this->dates = $xs; }
    }

    public function getDates()
    {return $this->dates;
    }
}
