// Anonymous function to create a seperate namespace for this file.
(function() {

	function onLiSelection() {
		$(this).addClass("selected").siblings().removeClass("selected");
	}

	function intoList(list, objList, prop) {

		for ( var i = 0, len = objList.length; i < len; i++) {
			var obj = objList[i];

			var objLiElem = $('<li></li>');
			objLiElem.text(obj[prop]);

			list.append(objLiElem);
		}

		list.find('li').click(onLiSelection);
	}

	$.getJSON('ajax/administration_info.php', function(info) {

		$(function() {
			var trialList = $('#admin-trial-block ul');
			var nodeList = $('#admin-node-block ul');
			var sensorList = $('#admin-sensor-block ul');

			intoList(trialList, info.trials, 'description');
			intoList(nodeList, info.nodes, 'name');
			intoList(sensorList, info.sensors, 'description');
		});

	});

})();