

(function() {

	function onLiSelection(){
		$(this).addClass("selected").siblings().removeClass("selected");
	}
	
	
	
	$(function() {

		$("#admin-trial-block li").click(onLiSelection);
		$("#admin-node-block li").click(onLiSelection);
		$("#admin-sensor-block li").click(onLiSelection);
		
	});

})();
