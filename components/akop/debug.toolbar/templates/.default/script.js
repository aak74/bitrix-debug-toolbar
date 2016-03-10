function safe_tags_regex(str) {
	return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

var debug_toolbar = {
	debugInfo: [],

	// Показ/скрытие меню
	toggleMenu: function(e) {
		e = e || window.event;
		$(".debug-toolbar").removeClass("hidden");
		$parent = $(e.target.parentNode);
		$parent.addClass("hidden");
		if ( $parent.hasClass("debug-toolbar-max") ) {
			$(".debug-info")
				.addClass("hidden");
		} else {
			$(".debug-info").removeClass("hidden");
		}
	},

	// свертывание/развертывание объекта
	toggleObject: function(e) {
		e = e || window.event;
		console.log("e toggleObject", e, e.target, e.target.tagName);
		var $target = false;
		switch(e.target.tagName) {
			case "SPAN":
				$target = $(e.target.parentNode);
				break;
			case "LI":
				$target = $(e.target);
				break;
		}
		if ( $target && $target.hasClass("object") ) {
			var closed = $target.hasClass("close");
			$target.parent().find("li").addClass("close").removeClass("active");
			// Открываем если только был закрыт
			if (closed) {
				$target.removeClass("close").addClass("active");
			}
			e.stopPropagation();
		}
	},

	// Показ/скрытие debug окна
	showDebugList: function() {
		$info = $(".debug-info");
		$info.toggleClass("open");
		if ($info.hasClass("open")) {
			$detail = $info.find(".debug-list");
			if ( $detail.html() === "" ) {
				var str = "<ul>";

				for (var i in debug_toolbar.debugInfo) {
					str += "<li data-index='" + i + "'>" + i + "</li>";
				}

				str += "</ul>";
				$detail.html(str);
				$(".debug-list li")
					.click(debug_toolbar.showDebugDetail);
			}
			var scrollHeight = window.innerHeight - parseInt($(".debug-toolbar")[0].offsetHeight);
	    	$info.css("height", scrollHeight);
	    	$(".debug-info > div").css("height", scrollHeight - 10); // на padding
		}
	},

	showDebugDetail: function(e) {
		e = e || window.event;

		$(e.target.parentNode).find("li").removeClass("active");
		e.target.classList.add("active");

		var str = "";
		str += debug_toolbar._getStr(debug_toolbar.debugInfo[e.target.dataset.index]).result;
    	$(".debug-detail")
    		.html(str)
    		.off()
    		.click(debug_toolbar.toggleObject);
	},

	_getStr: function(obj) {
		var res = {};
		var str = "";
		var type_ = typeof obj
		switch(type_) {
			case "number":
			case "boolean":
				str = '"' + obj + '"';
			    break;
			case "string":
				str = '"' + safe_tags_regex(obj) + '"';
			    break;
			case "object":
				if ( (obj == null) || (obj == undefined) ) {
					str = "null";
					type_ = "null";
				} else {
					if ( obj.length == 0 ) {
						str = "[]";
					} else {
						str += "<ul>";
						for (var key in obj) {
							res = debug_toolbar._getStr(obj[key]);
							console.log("res", res);
							str += "<li" + ( (res.type_ === "object") ? " class='close object'" : "") + ">";
							str += "<span>" + key + ":</span> " + res.result;
							str += "</li>";
						}
						str += "</ul>";
					}
				}
			    break;
		}
		return {"result": str, "type_": type_};
	},

	showRenderTime: function() {
    	$(".time-render").html( (performance.now() / 1000).toFixed(3) );
	},

	init: function() {
		debug_toolbar.showRenderTime();
		$(".debug-toolbar-toggler").click(debug_toolbar.toggleMenu);
		$(".debug").click(debug_toolbar.showDebugList);
		debug_toolbar.debugInfo = JSON.parse($(".debug-init").text());
	}
}

$(document).ready(function() {
	debug_toolbar.init();

});