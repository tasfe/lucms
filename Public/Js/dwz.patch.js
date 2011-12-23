
function initUI(_box){
	var $p = $(_box || document);

	//tables
	$("table.table", $p).jTable();
	
	// css tables
	$('table.list', $p).cssTable();

	//auto bind tabs
	$("div.tabs", $p).each(function(){
		var $this = $(this);
		var options = {};
		options.currentIndex = $this.attr("currentIndex") || 0;
		options.eventType = $this.attr("eventType") || "click";
		$this.tabs(options);
	});

	$("ul.tree", $p).jTree();
	
	/********uuleaf progress ztree end******/
	$('div.accordion', $p).each(function(){
		var $this = $(this);
		$this.accordion({fillSpace:$this.attr("fillSpace"),alwaysOpen:true,active:0});
	});

	$(":button.checkboxCtrl, :checkbox.checkboxCtrl", $p).checkboxCtrl($p);
	
	if ($.fn.combox) $("select.combox",$p).combox();
	
	if ($.fn.xheditor) {
		$("textarea.editor", $p).each(function(){
			var $this = $(this);
			var op = {html5Upload:false, skin: 'nostyle',tools: $this.attr("tools") || 'full'};
			var upAttrs = [
				["upLinkUrl","upLinkExt","zip,rar,txt"],
				["upImgUrl","upImgExt","jpg,jpeg,gif,png"],
				["upFlashUrl","upFlashExt","swf"],
				["upMediaUrl","upMediaExt","avi"]
			];
			
			$(upAttrs).each(function(i){
				var urlAttr = upAttrs[i][0];
				var extAttr = upAttrs[i][1];
				
				if ($this.attr(urlAttr)) {
					op[urlAttr] = $this.attr(urlAttr);
					op[extAttr] = $this.attr(extAttr) || upAttrs[i][2];
				}
			});
			
			$this.xheditor(op);
		});
	}
	
	if ($.fn.uploadify) {
		$(":file[uploader]", $p).each(function(){
			var $this = $(this);
			var options = {
				uploader: $this.attr("uploader"),
				script: $this.attr("script"),
				cancelImg: $this.attr("cancelImg"),
				queueID: $this.attr("fileQueue") || "fileQueue",
				fileDesc: $this.attr("fileDesc") || "*.jpg;*.jpeg;*.gif;*.png;*.pdf",
				fileExt : $this.attr("fileExt") || "*.jpg;*.jpeg;*.gif;*.png;*.pdf",
				folder	: $this.attr("folder"),
				auto: true,
				multi: true,
				onError:uploadifyError,
				onComplete: uploadifyComplete,
				onAllComplete: uploadifyAllComplete
			};
			if ($this.attr("onComplete")) {
				options.onComplete = DWZ.jsonEval($this.attr("onComplete"));
			}
			if ($this.attr("onAllComplete")) {
				options.onAllComplete = DWZ.jsonEval($this.attr("onAllComplete"));
			}
			if ($this.attr("scriptData")) {
				options.scriptData = DWZ.jsonEval($this.attr("scriptData"));
			}
			$this.uploadify(options);
		});
	}
	
	// init styles
	$("input[type=text], input[type=password], textarea", $p).addClass("textInput").focusClass("focus");

	$("input[readonly], textarea[readonly]", $p).addClass("readonly");
	$("input[disabled=true], textarea[disabled=true]", $p).addClass("disabled");

	$("input[type=text]", $p).not("div.tabs input[type=text]", $p).filter("[alt]").inputAlert();

	//Grid ToolBar
	$("div.panelBar li, div.panelBar", $p).hoverClass("hover");

	//Button
	$("div.button", $p).hoverClass("buttonHover");
	$("div.buttonActive", $p).hoverClass("buttonActiveHover");
	
	//tabsPageHeader
	$("div.tabsHeader li, div.tabsPageHeader li, div.accordionHeader, div.accordion", $p).hoverClass("hover");
	
	$("div.panel", $p).jPanel();

	//validate form
	$("form.required-validate", $p).each(function(){
		$(this).validate({
			focusInvalid: false,
			focusCleanup: true,
			errorElement: "span",
			ignore:".ignore",
			invalidHandler: function(form, validator) {
				var errors = validator.numberOfInvalids();
				if (errors) {
					var message = DWZ.msg("validateFormError",[errors]);
					alertMsg.error(message);
				} 
			}
		});
	});

	if ($.fn.datepicker){
		$('input.date', $p).each(function(){
			var $this = $(this);
			var opts = {};
			if ($this.attr("format")) opts.pattern = $this.attr("format");
			if ($this.attr("yearstart")) opts.yearstart = $this.attr("yearstart");
			if ($this.attr("yearend")) opts.yearend = $this.attr("yearend");
			$this.datepicker(opts);
		});
	}

	// navTab
	$("a[target=navTab]", $p).each(function(){
		$(this).click(function(event){
			var $this = $(this);
			var title = $this.attr("title") || $this.text();
			var tabid = $this.attr("rel") || "_blank";
			var fresh = eval($this.attr("fresh") || "true");
			var external = eval($this.attr("external") || "false");
			var url = unescape($this.attr("href")).replaceTmById($p);
			DWZ.debug(url);
			if (!url.isFinishedTm()) {
				alertMsg.error($this.attr("warn") || DWZ.msg("alertSelectMsg"));
				return false;
			}
			navTab.openTab(tabid, url,{title:title, fresh:fresh, external:external});

			event.preventDefault();
		});
	});
	
	// dwz.ajax.js
	/********uuleaf ajaxTodo*******/
	if ($.fn.ajaxTodo) $("a[target=ajaxTodo]", $p).ajaxTodo($p);
	if ($.fn.dwzExport) $("a[target=dwzExport]", $p).dwzExport($p);
				
	//dialogs
	$("a[target=dialog]", $p).each(function(){
		$(this).click(function(event){
			var $this = $(this);
			var title = $this.attr("title") || $this.text();
			var rel = $this.attr("rel") || "_blank";
			var options = {};
			var w = $this.attr("width");
			var h = $this.attr("height");
			if (w) options.width = w;
			if (h) options.height = h;
			options.max = eval($this.attr("max") || "false");
			options.mask = eval($this.attr("mask") || "false");
			options.maxable = eval($this.attr("maxable") || "true");
			options.minable = eval($this.attr("minable") || "true");
			options.fresh = eval($this.attr("fresh") || "true");
			options.resizable = eval($this.attr("resizable") || "true");
			options.drawable = eval($this.attr("drawable") || "true");
			options.close = eval($this.attr("close") || "");
			options.param = $this.attr("param") || "";
			
			var url = unescape($this.attr("href")).replaceTmById($p);
			DWZ.debug(url);
			if (!url.isFinishedTm()) {
				alertMsg.error($this.attr("warn") || DWZ.msg("alertSelectMsg"));
				return false;
			}
			$.pdialog.open(url, rel, title, options);
			
			return false;
		});
	});
	$("a[target=ajax]", $p).each(function(){
		$(this).click(function(event){
			var $this = $(this);
			var rel = $this.attr("rel");
			if (rel) {
				var $rel = $("#"+rel); 
				$rel.loadUrl($this.attr("href"), {}, function(){
					$rel.find("[layoutH]").layoutH();
				});
			}

			event.preventDefault();
		});
	});
	
	$("div.pagination", $p).each(function(){
		var $this = $(this);
		$this.pagination({
			targetType:$this.attr("targetType"),
			rel:$this.attr("rel"),
			totalCount:$this.attr("totalCount"),
			numPerPage:$this.attr("numPerPage"),
			pageNumShown:$this.attr("pageNumShown"),
			currentPage:$this.attr("currentPage")
		});
	});
	/********uuleaf progress bar start ******/
	$("div.progressBar", $p).each(function(){
		var $this = $(this);
		//$this.progressBar();
	});
	/********uuleaf progress bar end******/

	if ($.fn.lookup) $("a[lookupName]", $p).lookup();
	if ($.fn.suggest) $("input[suggestFields]", $p).suggest();
	if ($.fn.itemDetail) $("table[itemDetail]", $p).itemDetail();
	if ($.fn.selectedTodo) $("a[target=selectedTodo]", $p).selectedTodo();
	if ($.fn.pagerForm) $("form[rel=pagerForm]", $p).pagerForm({parentBox:$p});
}

/********uuleaf file:dwz.ajax.js*******/
function ajaxTodo(url, callback, data){
	var $callback = callback || navTabAjaxDone;
	var $data = data || '';
	if (! $.isFunction($callback)) $callback = eval('(' + callback + ')');
	$.ajax({
		type:'POST',
		url:url,
		dataType:"json",
		data:data,
		cache: false,
		success: $callback,
		error: DWZ.ajaxError
	});
}
/********uuleaf file:dwz.ajax.js*******/
$.fn.extend({
	ajaxTodo:function($p){
		return this.each(function(){
			var $this = $(this);
			$this.click(function(event){
				var url = unescape($this.attr("href")).replaceTmById($p);
				var data = $this.attr("data");
				DWZ.debug(url);
				if (!url.isFinishedTm()) {
					alertMsg.error($this.attr("warn") || DWZ.msg("alertSelectMsg"));
					return false;
				}
				var title = $this.attr("title");
				if (title) {
					alertMsg.confirm(title, {
						okCall: function(){
							ajaxTodo(url, $this.attr("callback"),data);
						}
					});
				} else {
					ajaxTodo(url, $this.attr("callback"),data);
				}
				event.preventDefault();
			});
		});
	}
});
/********uuleaf file:dwz.database.js*******/
(function($){
	var _lookup = {currentGroup:"",currentName:"",index:-1};
	var _util = {
		_lookupPrefix: function(){
			var indexStr = _lookup.index < 0 ? "" : "["+_lookup.index+"]";
			var preFix = _lookup.currentGroup + indexStr;
			return preFix ? preFix+"." : "";
		},
		lookupPk: function(key){
			return _util._lookupPrefix() + _lookup.currentName + "." + key;
		},
		lookupField: function(key){
			return _util._lookupPrefix() + "dwz_" + _lookup.currentName + "." + key;
		}
	};
	
	$.extend({
		bringBackSuggest: function(args, targetType){
			var $box = targetType == "dialog" ? $.pdialog.getCurrent() : navTab.getCurrentPanel();
			/********edit by uuleaf startI1*******/
			if(typeof(args.todom) != 'undefined'){
				$box = $("#"+args.todom);
				delete args.todom;
			}
			/********edit by uuleaf endI1*******/
			$box.find(":input").each(function(){
				/********edit by uuleaf startI2*******/
				var $input = $(this), inputName = $input.attr("rel");
				if(args.todom ) delete args.todom;
				/********edit by uuleaf endI2*******/
				for (var key in args) {
					var name = ("id" == key) ? _util.lookupPk(key) : _util.lookupField(key);
					if (name == inputName) {
						$input.val(args[key]);
						break;
					}
				}
			});
		},
		bringBack: function(args, targetType){
			$.bringBackSuggest(args, targetType);
			$.pdialog.closeCurrent();
		}
	});
	
	$.fn.extend({
		lookup: function(){
			return this.each(function(){
				var $this = $(this), options = {mask:true, 
					width:$this.attr('width')||820, height:$this.attr('height')||400,
					maxable:eval($this.attr("maxable") || "true"),
					resizable:eval($this.attr("resizable") || "true")
				};
				$this.click(function(event){
					_lookup = $.extend(_lookup, {
						currentGroup: $this.attr("lookupGroup") || "", 
						currentName:$this.attr("lookupName") || "",
						index: parseInt($this.attr("index")|| -1)
					});
					$.pdialog.open($this.attr("href"), "_blank", $this.attr("title") || $this.text(), options);
					return false;
				});
			});
		},
		suggest: function(){
			var op = {suggest$:"#suggest", suggestShadow$: "#suggestShadow"};
			var selectedIndex = -1;
			return this.each(function(){
				var $input = $(this).attr('autocomplete', 'off').keydown(function(event){
					if (event.keyCode == DWZ.keyCode.ENTER) return false; //屏蔽回车提交
				});
				
				var suggestFields=$input.attr('suggestFields').split(",");
				
				function _show(){
					var offset = $input.offset();
					var iTop = offset.top+this.offsetHeight;
					var $suggest = $(op.suggest$);
					if ($suggest.size() == 0) $suggest = $('<div id="suggest"></div>').appendTo($('body'));

					$suggest.css({
						left:offset.left+'px',
						top:iTop+'px'
					}).show();
					
					_lookup = $.extend(_lookup, {
						currentGroup: $input.attr("lookupGroup") || "", 
						currentName:$input.attr("lookupName") || "",
						index: parseInt($input.attr("index")|| -1)
					});

					$.ajax({
						type:'POST', dataType:"json", url:$input.attr("suggestUrl"), cache: false,
						data:{inputValue:$input.val()},
						success: function(response){
							if (!response) return;
							var html = '';

							$.each(response, function(i){
								var liAttr = '', liLabel = '';
								
								for (var i=0; i<suggestFields.length; i++){
									var str = this[suggestFields[i]];
									if (str) {
										if (liLabel) liLabel += '-';
										liLabel += str;
										if (liAttr) liAttr += ',';
										liAttr += suggestFields[i]+":'"+str+"'";
									}
								}
								html += '<li lookupId="'+this["id"]+'" lookupAttrs="'+liAttr+'">' + liLabel + '</li>';
							});
							$suggest.html('<ul>'+html+'</ul>').find("li").hoverClass("selected").click(function(){
								_select($(this));
							});
						},
						error: function(){
							$suggest.html('');
						}
					});

					$(document).bind("click", _close);
					return false;
				}
				function _select($item){
					var jsonStr = "{id:'"+$item.attr('lookupId')+"'," + $item.attr('lookupAttrs') +"}";
					$.bringBackSuggest(DWZ.jsonEval(jsonStr));
				}
				function _close(){
					$(op.suggest$).html('').hide();
					selectedIndex = -1;
					$(document).unbind("click", _close);
				}
				
				$input.focus(_show).click(false).keyup(function(event){
					var $items = $(op.suggest$).find("li");
					switch(event.keyCode){
						case DWZ.keyCode.ESC:
						case DWZ.keyCode.TAB:
						case DWZ.keyCode.SHIFT:
						case DWZ.keyCode.HOME:
						case DWZ.keyCode.END:
						case DWZ.keyCode.LEFT:
						case DWZ.keyCode.RIGHT:
							break;
						case DWZ.keyCode.ENTER:
							_close();
							break;
						case DWZ.keyCode.DOWN:
							if (selectedIndex >= $items.size()-1) selectedIndex = -1;
							else selectedIndex++;
							break;
						case DWZ.keyCode.UP:
							if (selectedIndex < 0) selectedIndex = $items.size()-1;
							else selectedIndex--;
							break;
						default:
							_show();
					}
					$items.removeClass("selected");
					if (selectedIndex>=0) {
						var $item = $items.eq(selectedIndex).addClass("selected");
						_select($item);
					}
				});
			});
		},
		
		itemDetail: function(){
			return this.each(function(){
				var $table = $(this).css("clear","both"), $tbody = $table.find("tbody");
				var itemDetail = $table.attr("itemDetail") || "", fields=[];

				$table.find("tr:first th[type]").each(function(){
					var $th = $(this);
					var field = {
						type: $th.attr("type") || "text",
						patternDate: $th.attr("format") || "yyyy-MM-dd",
						name: $th.attr("name") || "",
						size: $th.attr("size") || "12",
						enumName: $th.attr("enumName") || "",
						enumUrl: $th.attr("enumUrl") || "",
						lookupName: $th.attr("lookupName") || "",
						lookupUrl: $th.attr("lookupUrl") || "",
						suggestUrl: $th.attr("suggestUrl"),
						suggestFields: $th.attr("suggestFields"),
						fieldClass: $th.attr("fieldClass") || ""
					};
					fields.push(field);
				});
				
				$tbody.find("a.btnDel").click(function(){
					var $btnDel = $(this);
					function delDbData(){
						$.ajax({
							type:'POST', dataType:"json", url:$btnDel.attr('href'), cache: false,
							success: function(){
								$btnDel.parents("tr:first").remove();
								initSuffix($tbody);
							},
							error: DWZ.ajaxError
						});
					}
					
					if ($btnDel.attr("title")){
						alertMsg.confirm($btnDel.attr("title"), {okCall: delDbData});
					} else {
						delDbData();
					}
					
					return false;
				});

				var addButTxt = $table.attr('addButton') || "Add New";
				if (addButTxt) {
					var $addBut = $('<div class="button"><div class="buttonContent"><button type="button">'+addButTxt+'</button></div></div>').insertBefore($table).find("button");
					var $rowNum = $('<input type="text" name="dwz_rowNum" class="textInput" style="margin:2px;" value="1" size="2"/>').insertBefore($table);
					
					var trTm = "";
					$addBut.click(function(){
						if (! trTm) trTm = trHtml(fields, itemDetail);
						var rowNum = 1;
						try{rowNum = parseInt($rowNum.val())} catch(e){}
	
						for (var i=0; i<rowNum; i++){
							var $tr = $(trTm.replaceAll("#index#", $tbody.find(">tr").size()));
							$tr.appendTo($tbody).initUI().find("a.btnDel").click(function(){
								$(this).parents("tr:first").remove();
								initSuffix($tbody);
								return false;
							});
						}
					});
				}
			});
			
			/**
			 * 删除时重新初始化下标
			 */
			function initSuffix($tbody) {
				$tbody.find('>tr').each(function(i){
					$(':input', this).each(function(){
						var $input = $(this);
						var name = $input.attr('name').replaceAll('\[[0-9]+\]','['+i+']');
						$input.attr('name', name);
					});
				});
			}
			function tdHtml(field, itemDetail){
				var html = '', fieldName = itemDetail+'[#index#].'+field.name;
				var lookupFieldName = itemDetail+'[#index#].dwz_'+field.lookupName+'.'+field.name;
				switch(field.type){
					case 'del':
						html = '<a href="javascript:void(0)" class="btnDel '+ field.fieldClass + '">删除</a>';
						break;
					case 'lookup':
						var suggestFrag = '';
						if (field.suggestFields) {
							suggestFrag = 'autocomplete="off" lookupGroup="'+itemDetail+'" lookupName="'+field.lookupName+'" index="#index#" suggestUrl="'+field.suggestUrl+'" suggestFields="'+field.suggestFields+'"';
						}

						html = '<input type="hidden" name="'+itemDetail+'[#index#].'+field.lookupName+'.id"/>'
							+ '<input type="text" name="'+lookupFieldName+'"'+suggestFrag+' size="'+field.size+'" class="'+field.fieldClass+'"/>'
							+ '<a class="btnLook" href="'+field.lookupUrl+'" lookupGroup="'+itemDetail+'" lookupName="'+field.lookupName+'" index="#index#" title="查找带回">查找带回</a>';
						break;
					case 'lookupField':
						html = '<input type="text" name="'+lookupFieldName+'" size="'+field.size+'" class="'+field.fieldClass+'" readonly="readonly"/>';
						break;
					case 'attach':
						html = '<input type="hidden" name="'+itemDetail+'[#index#].'+field.lookupName+'.id"/>'
							+ '<input type="text" name="'+lookupFieldName+'" size="'+field.size+'" readonly="readonly" class='+field.fieldClass+'"/>'
							+ '<a class="btnAttach" href="'+field.lookupUrl+'" lookupGroup="'+itemDetail+'" lookupName="'+field.lookupName+'" index="#index#" width="560" height="300" title="查找带回">查找带回</a>';
						break;
					case 'enum':
						$.ajax({
							type:"POST", dataType:"html", async: false,
							url:field.enumUrl, 
							data:{enumName:field.enumName, inputName:fieldName}, 
							success:function(response){
								html = response;
							}
						});
						break;
					case 'date':
						html = '<input type="text" name="'+fieldName+'" class="date '+field.fieldClass+'" format="'+field.patternDate+'" size="'+field.size+'"/>'
							+'<a class="inputDateButton" href="javascript:void(0)">选择</a>';
						break;
					default:
						html = '<input type="text" name="'+fieldName+'" size="'+field.size+'" class="'+field.fieldClass+'"/>';
						break;
				}
				return '<td>'+html+'</td>';
			}
			function trHtml(fields, itemDetail){
				var html = '';
				$(fields).each(function(){
					html += tdHtml(this, itemDetail);
				});
				return "<tr>"+html+"</tr>";
			}
		},
		
		selectedTodo: function(){
			
			function _getIds(selectedIds, targetType){
				var ids = "";
				var $box = targetType == "dialog" ? $.pdialog.getCurrent() : navTab.getCurrentPanel();
				$box.find("input:checked").filter("[name='"+selectedIds+"']").each(function(i){
					var val = $(this).val();
					ids += i==0 ? val : ","+val;
				});
				return ids;
			}
			return this.each(function(){
				var $this = $(this);
				var selectedIds = $this.attr("rel") || "ids";
				var postType = $this.attr("postType") || "map";

				$this.click(function(){
					var ids = _getIds(selectedIds, $this.attr("targetType"));
					if (!ids) {
						alertMsg.error($this.attr("warn") || DWZ.msg("alertSelectMsg"));
						return false;
					}
					function _doPost(){
						$.ajax({
							type:'POST', url:$this.attr('href'), dataType:'json', cache: false,
							data: function(){
								if (postType == 'map'){
									return $.map(ids.split(','), function(val, i) {
										return {name: selectedIds, value: val};
									})
								} else {
									var _data = {};
									_data[selectedIds] = ids;
									return _data;
								}
							}(),
							success: navTabAjaxDone,
							error: DWZ.ajaxError
						});
					}
					var title = $this.attr("title");
					if (title) {
						alertMsg.confirm(title, {okCall: _doPost});
					} else {
						_doPost();
					}
					return false;
				});
				
			});
		}
	});
})(jQuery);

/********uuleaf added*******/
function doAjaxDone(json){
    DWZ.ajaxDone(json);
    if (json.statusCode == 1) {
		//dialog app
		var dialogact = json.act.dialog;
		var dialogid = dialogact.id || '';
		//alert(dialogid);
		if (dialogact.close) {
            if (dialogid == '') {
				//alert('1');
                setTimeout(function(){
					$.pdialog.closeCurrent(); 
                }, 100);
            }
            else {
				//alert('2');
                setTimeout(function(){
					$.pdialog.close(dialogid); 
                }, 100);
            }
            
        }
		
		if(dialogact.reload){
			if (dialogid == '') {
				// alert('3');
                 $.pdialog.reload(); 
            }
            else {
				 //alert('4');
                //navTab.reloadFlag(navid);
            }
		}
		if(dialogact.forward){
			var url = navact.forward || '';
			if (navid == '') {
				//alert('5');
                $.pdialog.reload(url); 
            }
            else {
				//alert('6');
                $.pdialog.reload(url,dialogid); 
            }
		}
		var navact = json.act.navtab;
		var navid = navact.id || '';
		if (navact.close) {
            if (navid == '') {
                setTimeout(function(){
					//$.pdialog.closeCurrent(); 
                    navTab.closeCurrentTab();
                }, 100);
            }
            else {
                setTimeout(function(){
					//$.pdialog.close(navid); 
                    navTab.closeCurrentTab();
                }, 100);
            }
            
        }
		
		if(navact.reload){
			if (navid == '') {
                 navTabPageBreak(); //重新载入当前navTab页面
            }
            else {
                navTab.reloadFlag(navid);
            }
		}
		
		if(navact.forward){
			var url = navact.forward || '';
			if (navid == '') {
                 navTab.reload(url);
            }
            else {
                navTab.reloadFlag(navid);
            }
		}

        
    }
}