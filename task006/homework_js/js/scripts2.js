
$(document).ready(function(){

	var content="<ol>";
	for(var i=0;i<7;i++) {
		content+="<li id='myList"+(i+1)+"'>опция "+(i+1)+"</li>";
	}
	content+="</ol>";
	
	$("#content").html(content); 
	
	$("#content ol li").click(function(){
		var id=$(this).attr("id");
		var number = id.split("myList");
		alert("Выбран пункт: "+number[1]);
		
	});
	
}); // end document.ready
