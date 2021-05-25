var curchecktime=0
var prevchecktime=0;

var downloaded1=0;
var downloaded2=0;
var uploaded1=0;
var uploaded2=0;

var waitpagereload=0;
var hidelogos=0;

window.onload = function(){
	var timerId1 = setTimeout(UpdateState, 1)
}

var start_time = new Date().getTime();

function UpdateState()
{
	var Handler = function(Request)
	{
		
		downloaded2 = downloaded1;
		uploaded2   = uploaded1;
		
		//////////////////////////////
		
		try {
			
			$(".last-error").text("");
			
			
			var jsonObj = JSON.parse(Request.responseText);
			
			if (hidelogos == 0) {
			
				$('#flag').attr("src", '/assets/flags/' + jsonObj.locselected + '.png');
				$("#servername").text(jsonObj.loclabel);
				
				$("#ping1").removeClass("green");
				$("#ping1").removeClass("grey");
				$("#ping1").removeClass("red");
				if (jsonObj.wan1 == 1 && jsonObj.wan1cable != "0") {
					$("#ping1").addClass("green");
					$("#ping1label").text(i18next.t("lng.internetconnected"));
				} else if (jsonObj.wan1cable == "0") {
					$("#ping1").addClass("red");
					$("#ping1label").text(i18next.t("lng.wannocable2"));
					$(".last-error").text(wannocable);
				} else if (jsonObj.wan1 == 4 || jsonObj.wan1 == 3 || jsonObj.wan1 == 0) {
					if (jsonObj.wan1 == 0) {
						$("#ping1").addClass("red");
						$("#ping1label").text();
					} else if (jsonObj.wan1 == 3) {
						$("#ping1").addClass("red");
						$("#ping1label").text(i18next.t("lng.wandnsproblem"));
					} else if (jsonObj.wan1 == 4) {
						$("#ping1").addClass("red");
						$("#ping1label").text(i18next.t("lng.wandnsproblem2"));
						$(".last-error").text(i18next.t("lng.wandnsproblem3"));
					}
				} else {
					$("#ping1").addClass("grey");
					$("#ping1label").text(i18next.t("lng.wanunknownstate"));
					$(".last-error").html(wanunknown);
				}
				
				$("#ping2").removeClass("green");
				$("#ping2").removeClass("grey");
				$("#ping2").removeClass("red");
				if (jsonObj.vpn1 == 1) {
					$("#ping2").addClass("green");
					$("#ping2label").text(i18next.t("lng.vpnconnected"));
					$("#first-screen").hide();
					$("#third-connect").show();
				} else if (jsonObj.vpn1 == 0) {
					$("#ping2").addClass("grey");
					$("#ping2label").text(i18next.t("lng.vpndisconnected"));
					$("#first-screen").show();
					$("#third-connect").hide();
				} else if (jsonObj.vpn1 == 3) {
					$("#ping2").addClass("red");
					$("#ping2label").text(i18next.t("lng.vpndnsproblem"));
					$(".last-error").text(i18next.t("lng.vpndnsproblem2"));
					$("#first-screen").hide();
					$("#third-connect").show();
				} else {
					$("#ping2").addClass("red");
					$("#ping2label").text(i18next.t("lng.vpnnoinet"));
					$(".last-error").text(i18next.t("lng.vpnnoinet2"));
					$("#first-screen").hide();
					$("#third-connect").show();
				}
				
				if ($("#last-error").text() == "") {
					$(".last-error").html(jsonObj.lasterror);
				}
			}
			
			
			downloaded1  = jsonObj.rx;
			uploaded1    = jsonObj.tx;
			
			if (downloaded2 == 0 || uploaded2 == 0) {
				downloaded2 = downloaded1;
				uploaded2   = uploaded1;
			}
			
			//////////////////////////////
			
			if (prevchecktime == 0) {
				prevchecktime  = new Date().getTime();
			} else {
				prevchecktime  = curchecktime;
			}
			
			curchecktime       = new Date().getTime();
			
			if (waitpagereload == 1) {
				document.location.reload(true);
				return;
			}
		}
		catch (e) {
			if (hidelogos == 0) {
				$("#ping1").addClass("grey");
				$("#ping1label").text(i18next.t("lng.wanunknownstate"));
				$(".last-error").html(wanunknown);
			}
			
			downloaded1 = 0;
			uploaded1   = 0;
			downloaded2 = 0;
			uploaded2   = 0;
		}
		
		if ((new Date().getTime() - start_time) > 1000) {
			setTimeout(UpdateState, 1);
			start_time = new Date().getTime();
		} else {
			setTimeout(function() {
				setTimeout(UpdateState, 1);
				start_time = new Date().getTime();
			},
				1000-(new Date().getTime() - start_time));
		}

	}
	SendRequest("GET", "/config_api.php?getstate=1&_"+ (new Date).getTime(), "", Handler);
}

function ReadFile(filename, container)
{
    //Создаем функцию обработчик
    var Handler = function(Request)
    {
        document.getElementById(container).innerHTML = Request.responseText;
    }
    
    //Отправляем запрос
    SendRequest("GET", filename, "", Handler);
    
} 


function CreateRequest()
{
    var Request = false;

    if (window.XMLHttpRequest)
    {
        //Gecko-совместимые браузеры, Safari, Konqueror
        Request = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        //Internet explorer
        try
        {
             Request = new ActiveXObject("Microsoft.XMLHTTP");
        }    
        catch (CatchException)
        {
             Request = new ActiveXObject("Msxml2.XMLHTTP");
        }
    }
 
    if (!Request)
    {
        alert("Невозможно создать XMLHttpRequest");
    }
    
    return Request;
} 

function SendRequest(r_method, r_path, r_args, r_handler)
{
    //Создаём запрос
    var Request = CreateRequest();
    
    //Проверяем существование запроса еще раз
    if (!Request)
    {
        return;
    }
    
    //Назначаем пользовательский обработчик
    Request.onreadystatechange = function()
    {
        //Если обмен данными завершен
        if (Request.readyState == 4)
        {
            //Передаем управление обработчику пользователя
            r_handler(Request);
        }
    }
    
    //Проверяем, если требуется сделать GET-запрос
    if (r_method.toLowerCase() == "get" && r_args.length > 0)
    r_path += "?" + r_args;
    
    //Инициализируем соединение
    Request.open(r_method, r_path, true);
    
    Request.timeout = 60000; // time in milliseconds
	
    if (r_method.toLowerCase() == "post")
    {
        //Если это POST-запрос
        
        //Устанавливаем заголовок
        Request.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=utf-8");
        //Посылаем запрос
        Request.send(r_args);
    }
    else
    {
        //Если это GET-запрос
        
        //Посылаем нуль-запрос
        Request.send(null);
    }
} 