/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var pinOptions;

function init(sensorID){
    xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","getcd.php?q=sensorID"+sensorID,true);
    xmlhttp.send();
    xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
        console.log(xmlhttp.responseText);
    }
  }
}

function changed(){
    if (typeof obj.pinOption != 'undefined'){
        init();
    }
}
