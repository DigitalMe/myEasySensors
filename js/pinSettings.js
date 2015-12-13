/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var pinOptions;

function setSensorPins(formID){
    var xmlhttp = new XMLHttpRequest();
    var url = "/myEasySensors/php/ajaxHandler.php";
    var selects = document.forms["child"+formID].getElementsByTagName("select");
    var childID = document.forms["child"+formID].elements["childID"].value;
    var nodeID = document.getElementById("nodeID").innerHTML;
    
    var vars = "func=savePinSettings&nodeID="+nodeID+ "&childID=" + childID;    var selectedPins = [];
    for (i = 0, length = selects.length; i < length; i++){
        vars += "&setPin_" + i + "=" + selects[i].options[selects[i].selectedIndex].value;
    }

    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function() {
          if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                  var return_data = xmlhttp.responseText;
                      document.getElementById("status"+childID).innerHTML = return_data;
          }
    }
    xmlhttp.send(vars);
  
}

function changed(){
    if (typeof obj.pinOption != 'undefined'){
        init();
    }
}
