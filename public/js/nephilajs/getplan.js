function getplan(varlevel){
 
    $.ajax({
            type: "GET", 
            url: "/getplan/" + varlevel + "/" + $("#department").val(), 
            success:function(data){
                $('#discountcontainer').html("");
                $('#screendisplay').html("");
                $('#trackcontainer').html("");
                if($('#department').val() == "Senior High School"){
                $('#plancontainer').html("");
                    $('#trackcontainer').html(data); 
                }
                else{
                    if($('#level').val() == "Grade 9" ||$('#level').val() == "Grade 10"){
                    $('#plancontainer').html("");
                    $('#trackcontainer').html(data);
                    }else{
                    $('#plancontainer').html(data);
                }
                }
                
                }
            }); 
    
}


