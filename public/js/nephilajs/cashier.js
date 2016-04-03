 function validate(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
        if ((key < 48 || key > 57) && !(key == 8 || key == 9 || key == 13 || key == 37 || key == 39 || key == 46) ){ 
            theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
        }
        
        if(key == 13){
            theEvent.preventDefault();
            return false;
            
        }
  
   
}
/*
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
        
      event.preventDefault();
      return false;
    }
  });
});
*/

function duenosubmit(event){
     if(event.keyCode == 13) {
         totaldue=document.getElementById('totaldue').value;
         totalmain=document.getElementById('totalmain').value;
         if(parseFloat(totaldue) > parseFloat(totalmain)){
            alert("The amount should not be greater than " + totalmain);
            document.getElementById('totaldue').value="";
           
        }else{
            
             document.getElementById('receivecash').focus(); 
             computetotal();
        }
      event.preventDefault();
      return false;
    }
    
}

function computetotal(){
    
    var totaldue = document.getElementById('totaldue').value;
    var totalprevious = document.getElementById('previous').value;
    var totalother = document.getElementById('totalother').value;
    var penalty = document.getElementById('penalty').value;
    var reservation = document.getElementById('reservation').value;
    var total = parseFloat(totaldue) + parseFloat(totalprevious) + parseFloat(totalother) + parseFloat(penalty) - parseFloat(reservation);
    document.getElementById('totalamount').value = total;
    //alert(total);
}

function submitprevious(event,amount){
    if(event.keyCode == 13) {
        totalprevious = parseFloat(document.getElementById('totalprevious').value);
        if( totalprevious < parseFloat(amount)){
            alert('Amount should not be more than ' + totalprevious)
            document.getElementById('previous').value=totalprevious;
        }
        else{
            
             document.getElementById('receivecash').focus(); 
             computetotal();
        }
      event.preventDefault();
      return false;
}

}

function submitother(event,amount,original,id){
    if(event.keyCode == 13) {
        
        if( parseFloat(original) < parseFloat(amount)){
            alert('Amount should not be more than ' + original)
            document.getElementById("other[" + id +"]").value=original;
        }
        else{
            
        document.getElementById('receive').focus(); 
        var totaldue = document.getElementById('totaldue').value;
        var totalprevious = document.getElementById('previous').value;
        var totalother = document.getElementById('totalother').value;
        var penalty = document.getElementById('penalty').value;
        var reservation = document.getElementById('reservation').value;
        var total = parseFloat(totaldue) + parseFloat(totalprevious) + parseFloat(totalother) + parseFloat(penalty) - parseFloat(reservation)+parseFloat(amount)-parseFloat(original);
        document.getElementById('totalamount').value = total;
        }
        event.preventDefault();
        return false;
}

}

function submitcash(event,amount){
      if(document.getElementById('submit').style.visibility == "visible"){
       document.getElementById('submit').style.visibility = "hidden" 
    }
    
    if(event.keyCode == 13) {  
       
     if(eval(document.getElementById("totalamount").value) == eval(amount)){ 
         
           document.getElementById('submit').style.visibility="visible";
          document.getElementById('submit').focus();
      }  else {
          
      document.getElementById('submit').style.visibility="hidden";    
      document.getElementById('iscbc').focus();
  }
      event.preventDefault();
      return false;
}
    
}

function nosubmit(event, whatbranch){
    if(event.keyCode == 13) {
        document.getElementById(whatbranch).focus();
        event.preventDefault();
        return false;
 }
}


function dosubmit(){
    if(confirm("Continue to process payment ?")){
        return true;
    }else{
        document.getElementById('submit').style.visibility="hidden";
        document.getElementById('receivecash').focus();
        return false;
    }
    
}

function submitiscbc(event, isSelected){
  if(event.keyCode == 13) {
  if(isSelected){
      document.getElementById('bank_branch').value="cbc";
      document.getElementById('check_number').focus();
  }else{
       document.getElementById('bank_branch').value="";
      document.getElementById('bank_branch').focus();
  }
        event.preventDefault();
        return false;
    }     
}

function submitcheck(event, amount){
    if(document.getElementById('submit').style.visibility == "visible"){
       document.getElementById('submit').style.visibility = "hidden" 
    }
    if(event.keyCode == 13) {
        if((eval(document.getElementById("receivecash").value)) + eval(amount) == eval(
                document.getElementById("totalamount").value)){
                document.getElementById('submit').style.visibility="visible";
                document.getElementById('submit').focus();
        } else {
            document.getElementById('submit').style.visibility="hidden";
            alert("Erroneous Amount");
        }
     event.preventDefault();
     return false;
        
    }
    
}