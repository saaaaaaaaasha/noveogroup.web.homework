
//initialization function
function init() {

	//active validator to main form
	$('#registration').validator()
	
    var content="";
    var namemonth =["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"];
    
	//list of days
    for(var i=0; i<31; i++) {
		content+="<option value='"+(i+1)+"'>"+(i+1)+"</option>";
	}
    $("#day").html(content);
	
 	//list of month   
    for(var i=0,content=""; i<12; i++) {
		content+="<option value='"+(i+1)+"'>"+namemonth[i]+"</option>";
	}
    $("#month").html(content); 
	
  	//list of year      
    for(var i=1940,content=""; i< (new Date).getFullYear(); i++) {
		var select="";
		if (i==1993) select="selected";
		content+="<option "+select+" value='"+(i+1)+"'>"+(i+1)+"</option>";
	}
    $("#year").html(content);   
    
}

function isLeapYear (year) {
    return new Date(year, 1, 29).getMonth() == 1;
}

//check for 18 years old by date of birth
function eighteenyears(d,m,y){
	var t = new Date();
	var a = ( t.getFullYear() - y - ((t.getMonth() - --m||t.getDate() - d)<0) );
	return (a>17);
}

//function for additional processing date
function validatedate(){
	var er=eighteenyears($("#day").val(),$("#month").val(),$("#year").val());
	if (!er) {
		$("#day").parent().addClass("has-error");		
		return false;
	}
	$("#registration").validator('validate');
	$("#day").parent().removeClass("has-error");
	return true;
}

$(document).ready(function(){
     
    init();
    
	//Send data to server with ajax
	$("#submit").click( function(){
		//checking data
		$("#registration").validator('validate');
		//if date isn't valid or other data isn't valid, return false;
		if (!validatedate() || $(this).hasClass("disabled")) return false;	
	
		var data={};
		data[0]=$("#inputName").val();
		data[1]=$("input[name=inlineRadioOptions]").val();
		data[2]=$("#selectcity").val();
		data[3]=$("#inputEmail3").val();
		data[4]=$("#inputLogin").val();
		data[5]=$("#inputPassword").val();
		data[6]=$("#textareaAbout").val();
		data[7]=$("#day").val()+"/"+$("#month").val()+"/"+$("#year").val();
		
		var URL="functions.php?getdata=1";
		var dataString="";
		
		//formation request
		for(i=0;i<8;i++) {
		  dataString+="fl"+i+"= "+data[i]+"&";
		}
		dataString.substring(0, dataString.length - 1);

		//ajax
		$.ajax({
			type: "POST",
			url: URL,
			data: dataString,
			cache: false,
			success: function(content){
				$("#registration").html(content);
			}
		});
		return false;
    });   
    
    //change month of birthday
    $("#month").change(function(){
		validatedate();	
        var currmonth=$(this).val();
		var currday=$("#day").val();
		currmonth= 33 - new Date($("#year").val(), currmonth-1, 33).getDate();
		if (currday>currmonth) currday=currmonth;
		//getting days in this month
		for(var i=0,content=""; i<currmonth; i++) {
			var selected="";
			if (i==currday-1) selected="selected";
			content+="<option "+selected+" value='"+(i+1)+"'>"+(i+1)+"</option>";
		}
        $("#day").html(content);    
    });
	
    //change year of birthday    
    $("#year").change(function(){
        var curryear=$(this).val();
        $("#month").change();     
    });
	
	//sending data with the "Enter" key
    $(document).keyup(function(e){
		if(e.which==13) {
			$("#submit").click();
		}
	});
	
 }); // end document.ready
