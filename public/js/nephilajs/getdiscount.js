function getdiscount(){
   var department = document.getElementById('department').value;
   var myarray= {};
   myarray['department']=department;
   if(department=="TVET"){
   var plan = document.getElementById('plan').value;    
   var course = document.getElementById('course').value;    
   myarray['plan']=plan;
   myarray['course']=course
   }
      $.ajax({
            type: "GET", 
            url: "/getdiscount" , 
            data: myarray,
            success:function(data){
                if(department=="TVET"){
                  $('#screendisplay').html(data);  
                }else{   
                $('#screendisplay').html("");
                $('#discountcontainer').html(data); 
            }
                }
            }); 
   
}

function compute(){
    var department = $('#department').val();
    var level = $('#level').val();
    var strand = $('#strand').val();
    var course= $('#course').val();
    var discount = $('#discount').val();
    var plan = $('#plan').val();
    var id=$('#id').val();
    
    var arrays ={} ;
    arrays["department"] = department;
    arrays["level"] = level; 
    arrays["strand"] = strand; 
    arrays["course"]= course; 
    arrays["discount"] = discount;
    arrays["plan"] = plan;
    arrays["id"]= id;
   $.ajax({
            type: "GET", 
            url: "/compute" ,
            data : arrays,
            success:function(data){
                $('#screendisplay').html(data); 
                
                }
            }); 
   
    
}

