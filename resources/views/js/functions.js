/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function timeCross(t0, t1) {
    var cross = false;
    if (($t0[0] < $t1[0]) && ($t0[1] > $t1[1])) cross = true;
    if (($t0[0] > $t1[0]) && ($t0[1] < $t1[1])) cross = true;
    if (($t0[1] > $t2[0]) && ($t1[1] < $t1[1])) cross = true;
    if (($t0[0] > $t2[0]) && ($t1[1] < $t2[1])) cross = true;
    return cross;
}




