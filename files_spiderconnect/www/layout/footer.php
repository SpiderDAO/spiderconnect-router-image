<?php

echo '

</div>
<!-- End footer -->
</div>
<!-- End Page wrapper  -->
</div>
<!-- End Wrapper -->
<!-- Bootstrap tether Core JavaScript -->
<script src="assets/js/lib/bootstrap/js/popper.min.js"></script>
<script src="assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="assets/js/jquery.slimscroll.js"></script>
<!--Menu sidebar -->
<script src="assets/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<!--Custom JavaScript -->
<script src="assets/js/custom.min.js"></script>
<script src="assets/js/stats2.js"></script>
<script src="assets/js/custom.js"></script>

<div class="overlay-bg"></div>

<div class="spinner-overlay">
    <div class="loading-animation"></div>
</div>


</div>


<div class="footer-con">
    <p>&nbsp;&nbsp;&nbsp;Version 0.63
    </p>

</div>

<script>


    $("#update_locations").click(function () {

        $("#update_locations").addClass("rotate");

        $.ajax({
            method: "GET",
            url: "/api/credentials.php?_=" + (new Date).getTime()
        }).done(function (data, textStatus, jqXHR) {

            $("#update_locations").removeClass("rotate");
            window.location.href = "/?show_locations_list=1";

        }).fail(function () {
            alert("Can\'t update list - try later.");
        });
    });

    function formatSpeedUnits(bytes) {
        if (bytes >= 1099511627776) {
            bytes = (bytes / 1099511627776).toFixed() + "Tbit";
        } else if (bytes >= 1073741824) {
            bytes = (bytes / 1073741824).toFixed() + "Gbit";
        } else if (bytes >= 1048576) {
            bytes = (bytes / 1048576).toFixed() + "Mbit";
        } else if (bytes >= 1024) {
            bytes = (bytes / 1024).toFixed() + "Kbit";
        } else if (bytes > 1) {
            bytes = bytes.toFixed() + "bites";
        } else if (bytes == 1) {
            bytes = bytes.toFixed() + "bit";
        } else {
            bytes = "0bit";
        }
        return bytes;
    }

    function formatSizeUnits(bytes, length) {
        if (bytes >= 1099511627776) {
            bytes = (bytes / 1099511627776).toFixed(length) + "TB";
        } else if (bytes >= 1073741824) {
            bytes = (bytes / 1073741824).toFixed(length) + "GB";
        } else if (bytes >= 1048576) {
            bytes = (bytes / 1048576).toFixed(length) + "MB";
        } else if (bytes >= 1024) {
            bytes = (bytes / 1024).toFixed(length) + "KB";
        } else if (bytes > 1) {
            bytes = bytes + "bytes";
        } else if (bytes == 1) {
            bytes = bytes + "byte";
        } else {
            bytes = "0byte";
        }
        return bytes;
    }

    function stats() {

        var timediff = (curchecktime - prevchecktime) / 1000;
		
		var current_updown_speed = i18next.t("lng.current_updown_speed");
		var total_data_used = i18next.t("lng.total_data_used");
		
        if (timediff > 0) {

            $(\'#stats\').html("<span class=\'smalltext\'>"+current_updown_speed+":</span><br/><i class=\'fa fa-long-arrow-down\'></i>&nbsp;" + formatSpeedUnits((downloaded1 - downloaded2) * 8 / ((curchecktime - prevchecktime) / 1000)) + "/s,&nbsp;<i class=\'fa fa-long-arrow-up\'></i>&nbsp;" + formatSpeedUnits((uploaded1 - uploaded2) * 8 / ((curchecktime - prevchecktime) / 1000)) + "<br/><span class=\'smalltext\'>"+total_data_used+":</span><br/><i class=\'fa fa-long-arrow-down\'></i>&nbsp;" + formatSizeUnits(downloaded1, 2) + ", &nbsp;<i class=\'fa fa-long-arrow-up\'></i>&nbsp;" + formatSizeUnits(uploaded1, 2));
        }
    }

    $(document).ready(function ($) {
		
		$(".navbar-header").fadeTo( "slow" , 1, function() {
			// Animation complete.
		});
		
		if ((window.innerWidth > 0 ? window.innerWidth : this.screen.width) < 767) {
			$("#collapsibleNavbar").addClass( "collapse" );
		}
		
        setInterval(function () {
            stats();
        }, 1000);
    })

    function ShowPassword() {
        var x = document.getElementById("router_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }


</script>
<!-- All Jquery -->


<script>
	
	var brand      = "'.file_get_contents("/brand/brand.txt").'";
	var shortbrand = "'.file_get_contents("/brand/shortbrand.txt").'";
	var feedback   = "'.file_get_contents("/brand/feedback.txt").'";
	var ipinfo     = "'.file_get_contents("/brand/ipinfo.txt").'";
	var wifissid1     = "'.file_get_contents("/brand/wifissid1.txt").'";
	var wifissid2     = "'.file_get_contents("/brand/wifissid2.txt").'";
	
	
	
	i18next.init({
		
		lng: $("html").attr("lang"), // "cimode" for debug, evtl. use language-detector https://github.com/i18next/i18next-browser-languageDetector
		//lng: "ar",
		fallbackLng: "en",
		debug: true,
		resources: { // evtl. load via xhr https://github.com/i18next/i18next-xhr-backend
			en: {
				translation: {
					lng: {
						turn_on: "VPN Not Connected",
						turn_on_title: "Press to select VPN location",
						you_are_protected: "You are not protected",
						select_location: "Select Location",
						connecting: "Connecting",
						disconnecting: "Disconnecting",
						connected: "VPN Connected",
						not_secure: "Your connection is not secure",
						on: "On",
						off: "Off",
						disabled: "Disabled",
						change_location: "Change Location",
						check_my_ip: "Check My IP Address",
						check_servers_status: "Click to check server status",
						update_locations_list: "Update Locations List",
						connection_information: "Connection Information",
						version: "Version",
						current_updown_speed: "Current Down/Up Speed",
						total_data_used: "Total Data Used with " + shortbrand,
						checking_wan_state: "Checking WAN state...",
						checking_vpn_state: "Checking VPN state...",
						home: " Home ",
						wifi_setup: " WiFi Setup ",
						wan_setup: " WAN Setup",
						killswith: " Kill Switch",
						dns_unblocker: " DNS Unblocker",
						expertmode: " Expert Mode",
						ipinfo: " Connection Info",
						helpnsupport: " Help & Support",
						createticket: "  Talk to Our Teem",
						myvpnaccount: "  My VPN Account",
						restart: "  Restart",
						factoryreset: "  Reset to factory defaults",
						updatefirmware: "  Update to latest Software",
						logout: "  Logout",
						routermemory: " Router Memory",
						wallet: " Wallet",
						wannocable: "Please connect the ethernet cable from the ISP router to the "+brand+"\'s Blue WAN port.",
						wanunknown: "1) Please make sure the ethernet cable from ISP is properly connected to "+brand+"\'s Blue WAN Port<br/>2) Make sure you are connected to "+wifissid1+" or "+wifissid1+" Wi-Fi SSID.<br/>3) Make sure the ethernet cable from "+brand+" is properly connected to your laptop/PC",
						
						activate: "Activate",
						password: "Password",
						bad_email: "You entered an incorrect username or password.",
						no_internet: "No Internet Connection.",
						something_wrong: "Something went wrong, please try again later.",
						reg_here: "Register here",
						
						factory_resetting: "Factory Resetting VPN Router...",
						rebooting: "Rebooting VPN Router...",
						updating: "Updating VPN Router...",
						
						low_memory1: "Low Flash Memory! Please free up some space.",
						low_memory2: "Please use a MicroSD card or a USB stick to extend memory.",
						checkingstatus: "Detecting status...",
						factoryreset2: "Factory Reset",
						paramsupdated: "Parameters have been successfully updated.",
						killswith2: "With this enabled, it will automatically cut your connection from the internet if VPN fails. It protects your original IP from getting exposed.",
						savechanges: "Save Changes",
						expertmode2: "The user is liable for any damage or issues that may occur when turning On expert mode.",
						expertmode3: "Router Access Login & Password",
						expertmode4: "Set this password so whenever you access anything from the " + brand + " Dashboard, it will prompt you for this password.",
						setrouterlogin: "Set Router Login",
						setrouterpassword: "Set Router Password",
						showpassword: " Show Password",
						dns_unblocker2: "Update your VPN DNS Unblocker mode",
						dns_unblocker3: "DNS Unblocker feature",
						customdnsservers: "Custom DNS Servers",
						wifi_setup2: "Personalize your WiFi Name and set an easy-to-remember password",
						autowifichannel: "Auto Channel",
						wifichannel: "Channel",
						autowifiwidth: "Auto Width",
						width: "Width",
						enabledisablessid: "Enable/Disable SSID",
						widiisolationtitle: "Isolates wireless clients from each other",
						widiisolation: "WiFi Client Isolation",
						nameyournetwork: "Name your network",
						restartrouter: "Restart Router",
						cancel: "Cancel",
						updatefirmware2: "Update your "+brand+" to Latest Software",
						updatefirmware3: "Click to select firmware upgrade",
						updatefirmware4: "Click to select firmware upgrade",
						keepsettings: "Keep settings",
						removesetting: "Remove settings",
						submit: "Submit",
						surefactoryreset: "Are you sure you want to reset your router to Factory Default Settings?",
						internetdisconnected: "Internet Disconnected",
						internetconnected: "Internet Connected",
						wannocable2: "WAN No ethernet cable connected",
						wandnsproblem: "WAN Connection, DNS Problem",
						wandnsproblem2: "WAN Connection, DNS-blocker detected, try to toggle dns-unblocker-feature",
						wandnsproblem3: "Your ISP is blocking the "+shortbrand+"-DNS. Click here and turn off DNS-Unblocker. Then select your desired location again.",
						wanunknownstate: "WAN unknown state",
						vpnconnected: "VPN Connected",
						vpndisconnected: "VPN Disconnected",
						vpndnsproblem: "VPN Connected, DNS Problem",
						vpndnsproblem2: "Your ISP is blocking the "+shortbrand+"-DNS. Click here and turn off DNS-Unblocker. Then select your desired location again.",
						vpnnoinet: "VPN Connected, No Internet - try different location",
						vpnnoinet2: "VPN Location Down! Please disconnect and try another VPN location.",
						
						plzwait: "Please wait while your request is processing.",
						noreferendumsavailable: "No Referendums Available",
						voteyes: "Vote Yes",
						voteno: "Vote No",
						finished: "Finished",
						noproposalsavailable: "No Proposals Available",
						second: "Second",
						propose: "Propose",
						storagefee: "Storage fee is",
						plzreloadpage: "Done, please reload this page now",
						cantsavedata: "Can\'t save date in router\'s flash memory.",
						youhavevoted: "You have voted",
						onreferrendum: "on Referendum",
						yousecondedproposal: "You Seconded Proposal",
						confirmation: "Confirmation",
						importwallet: "Import Wallet",
						proposal: "Proposal",
						createproposal: "Create Proposal",
						address: "Address",
						recipientaddress: "Recipient\'s username",
						balance: "Balance",
						mnemonic: "Mnemonic",
						privatekey: "Private Key",
						makesure: "Make sure you saved the wallet info in a safe location",
						gotoproposals: "Go to Proposals",
						seedphrase: "SEED PHRASE",
						import: " Import",
						sendnreceive: "Send & Receive",
						proposals: "Proposals",
						referendums: "Referendums",
						referendum: "Referendum",
						youraddress: "Your Address",
						goback: "Go back ",
						enterreceiversaddress: "Enter receiver\'s $SPDR Address",
						inputspdraddress: "Input $SPDR Address",
						amount: "Amount",
						send: "Send",
						receive: " Receive",
						chooseaproposal: "Choose a Proposal",
						success: "Success",
						createwallet: "Create Wallet",
						setupcablewan: "Setup Cable WAN Connection",
						staticip: "Static IP",
						ipv4placeholder: "IPv4 address - 192.168.1.2",
						netmaskplaceholder: "IPv4 netmask - 255.255.255.0",
						gatewayplaceholder: "IPv4 gateway - 192.168.1.1",
						dnsplaceholder: "DNS server - 8.8.8.8",
						detectingstatus: "Detecting status...",
						setupwifiwan: "Setup Wireless WAN Connection",
						joinnetwork: "Join network",
						ssidsdetected: "SSIDs detected",
						routerisnotaccessible: "Router is not accessible now",
						confirmdisconnectwifiwan: "Disconnect Wireless WAN?",
						enterssidpassword: "Please enter SSID password",
						ssidpasswordlength: "SSID password length must be between 8 to 63 simbols",
						nowwan: "No wireless WAN is connected",
						wwanok: "Wireless WAN is connected",
						wwannotok: "Wireless WAN is not connected",
						
						formatting: "Formatting",
						internalmemory: "Internal Flash Memory",
						used: "used",
						free: "free",
						externalmemory0: "<br/><br/>External USB Flash Memory - 0MB Free<br/><br/>Insert USB to Access External Memory",
						mmc: "Router booted from MicroSD,<br/> and have ",
						freespace: " free space<br/><br/>",
						usb: "Router booted from USB Pendrive,<br/> and have ",
						nonexpectedstatus: "Router is in non-expected status.<br/> Please reboot<br/><br/>",
						mmc1: "MicroSD card inserted<br/>",
						usb1: "USB flash drive inserted<br/>",
						size: "size",
						formattedfor: "formatted for",
						notformattedfor: "not formatted for",
						format: "Format",
						mmc0: "MicroSD",
						usb0: "USB PenDrive",
						active: "active",
						saferemove: "Safe Remove",
						rebootrouter: "Reboot router",
						reboottoactivate: "reboot to activate",
						routerwilloffnowmmc: "Router will off now and you will can safety remove USB Pendrive. Remove and insert back router\"s power cable to start router again. Continue?",
						routerwilloffnowusb: "Router will off now and you will can safety remove  MicroSD. Remove and insert back router\"s power cable to start router again. Continue?",
						confirmformatmmc: "Are you sure you want to format inserted MicroSD? All data will be lost!",
						confirmformatusb: "Are you sure you want to format inserted USB Pendrive? All data will be lost!",
						
					}
					
					
				}
			},
			ru: {
				translation: {
					lng: {
						turn_on: "VPN Не Подключен",
						turn_on_title: "Нажмите для выбора локации VPN",
						you_are_protected: "Вы не защищены",
						select_location: "Выбор локации",
						connecting: "Подключаюсь",
						connected: "VPN Подключен",
						not_secure: "Ваше подключение не защищено",
						on: "Включено",
						off: "Выключено",
						change_location: "Изменить локацию",
						check_my_ip: "Проверить мой IP адрес",
						check_servers_status: "Проверить статусы серверов",
						update_locations_list: "Обновить список локаций",
						connection_information: "Информация о подключении",
						version: "Версия",
						current_updown_speed: "Текущая скорость передачи",
						total_data_used: "Всего передано данных через " + shortbrand,
						checking_wan_state: "Проверяю статус WAN...",
						checking_vpn_state: "Проверяю статус VPN...",
						home: " Главная ",
						wifi_setup: " Настройка WiFi ",
						wan_setup: " Настройка WAN",
						killswith: " Kill Switch",
						dns_unblocker: " DNS Разблокировщик",
						expertmode: " Режим администратора",
						ipinfo: " Информация о подключении",
						helpnsupport: " Помощь и поддержка",
						createticket: "  Свяжитесь с нами",
						myvpnaccount: "  Мой VPN Аккаунт",
						restart: "  Перезагрузка",
						factoryreset: "  Сброс до заводских настроек",
						updatefirmware: "  Обновить прошивку роутера",
						logout: "  Выход из аккаунта",
						routermemory: " Расширение памяти роутера",
						wallet: " Кошелёк",
						wannocable: "Пожалуйста, подключите сетевой кабель от Вашего интернет-провайдера к СИНЕМУ порту "+brand,
						wanunknown: "1) Убедитесь, что кабель Вашего интернет-провайдера подключен к СИНЕМУ порту "+brand+".<br/>2) Убедитесь, что вы подключены к вай-фай сети "+wifissid1+" или "+wifissid1+".<br/>3) Убедитесь, что кабель от "+brand+" правильно подключен к Вашему ПК",
						
						activate: "Активировать",
						password: "Пароль",
						bad_email: "Вы ввели неверный адрес электронной почты или пароль.",
						no_internet: "Нет интернет подключения.",
						something_wrong: "Что-то пошло не так, повторите попытку позже.",
						reg_here: "Зарегистрироваться",
						
						factory_resetting: "Сбрасываю настройки VPN роутера на заводские...",
						rebooting: "Перезагружаю VPN роутер...",
						updating: "Обнровляю VPN роутер...",
						
						low_memory1: "Мало свободной флеш-памяти! Пожалуйста, увеличьте объём память.",
						low_memory2: "Используйте MicroSD карту или USB-флешку чтоы увеличить память роутера.",
						checkingstatus: "Проверка статуса...",
						factoryreset2: "Сброс на заводские настройки",
						paramsupdated: "Параметры успешно изменены.",
						killswith2: "Если включено - роутер будет блокировать интернет при отключении VPN-подключения. Это защитит Ваш оригинальный IP-адрес от утечки.",
						savechanges: "Сохранить изменения",
						expertmode2: "Пользователь берёт на себя ответсвенность за любые повреждения роутера, при включении Режима администратора.",
						expertmode3: "Логин и пароль доступа к роутеру",
						expertmode4: "Установите пароль, и при любом обращении к вэб-интерфейсу " + brand + " потребуется вводить этот пароль доступа.",
						setrouterlogin: "Установить логин для доступа",
						setrouterpassword: "Установить пароль",
						showpassword: " Показать пароль",
						dns_unblocker2: "Обновить статус DNS-разблокировщика",
						dns_unblocker3: "DNS-разблокировщик",
						customdnsservers: "Частные DNS-сервера",
						wifi_setup2: "Установите собственное имя сети и установите пароль",
						autowifichannel: "Авто-выбор канала WiFi",
						wifichannel: "Канал",
						autowifiwidth: "Автоматическая ширина канала",
						width: "Ширина",
						enabledisablessid: "Включить/Отключить SSID",
						widiisolationtitle: "Изолировать вай-фай клиентов друг от друга",
						widiisolation: "WiFi изоляция клиентов",
						nameyournetwork: "Назовите свою сеть",
						restartrouter: "Перезапустить роутер",
						cancel: "Отмена",
						updatefirmware2: "Обновите свой "+brand+" до последней версии",
						updatefirmware3: "Выбрать файл прошивки",
						updatefirmware4: "Сохранить текущие настройки в процессе пере-прошивки?",
						keepsettings: "Сохранить настройки",
						removesetting: "Удалить настройки",
						submit: "Начать",
						surefactoryreset: "Вы точно уверены, что хотите сбросить роутер до заводских настроек?",
						internetdisconnected: "Интернет Отключен",
						internetconnected: "Интернет Подключен",
						wannocable2: "Отключен сетевой кабель WAN",
						wandnsproblem: "WAN подключен, проблема с DNS",
						wandnsproblem2: "WAN подключен, обнаружен DNS-блокировщик - попробуйте изменить настройки DNS-разблокировщика",
						wandnsproblem3: "Ваш интернет-провайдер блокирует "+shortbrand+"-DNS. Измените настройки DNS-разблокировщика и повторите попытку подключения к VPN.",
						wanunknownstate: "Статус WAN неизвестен",
						vpnconnected: "VPN Подключен",
						vpndisconnected: "VPN Отключен",
						vpndnsproblem: "VPN подключен, проблема с DNS",
						vpndnsproblem2: "Ваш интернет-провайдер блокирует "+shortbrand+"-DNS. Измените настройки DNS-разблокировщика и повторите попытку подключения к VPN.",
						vpnnoinet: "VPN Подключен, Нет Интернета - попробуйте другую VPN-локацию",
						vpnnoinet2: "VPN Локация не работает! Пожалуйста отклчите текущую, а затем попробуйте другую VPN локацию.",
						
						plzwait: "Подождите, Ваш запрос выполняется...",
						noreferendumsavailable: "Нет доступных Референдумов",
						voteyes: "Проголосовать ДА",
						voteno: "Проголосовать НЕТ",
						finished: "Завершён",
						noproposalsavailable: "Нет доступных Предложений",
						second: "Поддержать",
						propose: "Предложить",
						storagefee: "Комиссия за операцию",
						plzreloadpage: "Выполнено, пожалуйста, перезагрузите текущую страницу",
						cantsavedata: "Ошибка при сохранении данных в памят роутера.",
						youhavevoted: "Вы проголосовали",
						onreferrendum: "в Референдуме",
						yousecondedproposal: "Вы поддержали Предложение",
						confirmation: "Подтверждение",
						importwallet: "Импорт Кошелька",
						proposal: "Предложение",
						createproposal: "Создать Предложение",
						address: "Адрес",
						recipientaddress: "Адрес получателя",
						balance: "Баланс",
						mnemonic: "Кодовая Фраза",
						privatekey: "Приватный Ключ",
						makesure: "Убедитесь, что сохранили данные кошелька в безопасном месте!",
						gotoproposals: "Перейти к Предложениям",
						seedphrase: "Кодовая Фраза",
						import: " Импорт",
						sendnreceive: "Получить и Отправить",
						proposals: "Предложения",
						referendums: "Референдумы",
						referendum: "Референдум",
						youraddress: "Ваш Адрес",
						goback: "Назад ",
						enterreceiversaddress: "Введите $SPDR адрес Получателя",
						inputspdraddress: "Введите $SPDR Адрес",
						amount: "Количество",
						send: "Отправить",
						receive: " Получить",
						chooseaproposal: "Выбрать Предложение",
						success: "Успешно",
						createwallet: "Создать Кошелёк",
						
						setupcablewan: "Настроить подключение к Интернет по кабелю",
						staticip: "Статический IP-адрес",
						ipv4placeholder: "IPv4 адрес - 192.168.1.2",
						netmaskplaceholder: "IPv4 маска сети - 255.255.255.0",
						gatewayplaceholder: "IPv4 шлюз - 192.168.1.1",
						dnsplaceholder: "DNS сервер - 8.8.8.8",
						detectingstatus: "Обновляю статус, ждите...",
						setupwifiwan: "Настроить подключение к Интернет через WiFi",
						joinnetwork: "Подлючиться к сети",
						ssidsdetected: "Вай-фай сетей найдено",
						routerisnotaccessible: "Роутер сейчас недоступен",
						confirmdisconnectwifiwan: "Отключить Интернет WiFi-клиент?",
						enterssidpassword: "Введите пароль Вай-фай сети",
						ssidpasswordlength: "Длина пароля вай-фай сети должна быть от 8 до 63 символов!",
						nowwan: "Интернет WiFi-клиент не используется",
						wwanok: "Интернет WiFi-клиент подключен",
						wwannotok: "Интернет WiFi-клиент отключен",
						
						formatting: "Форматирую",
						internalmemory: "Внутренняя флеш-память",
						used: "использовано",
						free: "свободно",
						externalmemory0: "<br/><br/>Внешняя USB-флеш память - 0MB свободно<br/><br/>Вставьте USB-флешку или карту MicroSD чтобы расширить память роутера",
						mmc: "Роутер загружен с MicroSD,<br/> и имеет ",
						freespace: " свободного места<br/><br/>",
						usb: "Роутер загружен с  USB-aktirb,<br/> и имеет ",
						nonexpectedstatus: "Статус роутера неизвестен.<br/> Перезагрузите роутер<br/><br/>",
						mmc1: "Вставлена карта MicroSD<br/>",
						usb1: "Вставлена USB-флешка<br/>",
						size: "объём",
						formattedfor: "отформатирована для",
						notformattedfor: "не отформатирована для",
						format: "Форматировать",
						mmc0: "MicroSD",
						usb0: "USB-флешка",
						active: "активна",
						saferemove: "Безопасно извлечь",
						rebootrouter: "Перезагрузить роутер",
						reboottoactivate: "Перезагрузите роутер, чтобы активировать",
						routerwilloffnowmmc: "Роутер сейчас будет выключен и Вы сможете безопасно извлечь USB-флешку. Выньте и затем вставьте кабель питания, чтобы снова включить роутер. Продолжить?",
						routerwilloffnowusb: "Роутер сейчас будет выключен и Вы сможете безопасно извлечь карту MicroSD. Выньте и затем вставьте кабель питания, чтобы снова включить роутер. Продолжить?",
						confirmformatmmc: "Вы уверены, что хотите отформатировать карту MicroSD? Все данные на ней будут стёрты!",
						confirmformatusb: "Вы уверены, что хотите отформатировать USB-флешку? Все данные на ней будут стёрты!",
						
					}
				}
			},
			ko: {
				translation: {
					lng: {
						turn_on: "홈 버튼",
						turn_on_title: "VPN 위치 선택",
						you_are_protected: "개인 정보 위험",
						select_location: "위치 선택",
						connecting: "연결 중",
						disconnecting: "연결 해제 중",
						connected: "VPN 연결 완료",
						not_secure: "연결이 안전하지 않습니다",
						on: "켜기",
						off: "끄기",
						disabled: "해제 완료",
						change_location: "위치 재설정",
						check_my_ip: "IP 주소 확인",
						check_servers_status: "서버 상태 확인",
						update_locations_list: "위치 목록 최신화",
						connection_information: "연결 정보",
						version: "버젼",
						current_updown_speed: "현재 다운로드/업로드 속도",
						total_data_used:	"총 데이터 소진",
						checking_wan_state: "WAN 상태 확인 ",
						checking_vpn_state: "VPN 상태 확인 중",
						home: "홈",
						wifi_setup: "WiFi 설정",
						wan_setup: "WAN 설정",
						killswith: "Switch 종료",
						dns_unblocker: "DNS 차단 해제",
						expertmode: "전문가 모드",
						ipinfo: "연결 정보",
						helpnsupport: "고객 지원",
						createticket: "문의하기",
						myvpnaccount: "내 VPN 계정",
						restart: "재시작",
						factoryreset: "기본 설정",
						updatefirmware: "소프트웨어 최신화",
						logout: "로그아웃",
						routermemory: "라우터 메모리 확인",
						wallet: "월렛",
						wannocable: "ISP 라우터에 있는 이더넷 케이블을 파란 WAN 포트에 연결해주세요",
						wanunknown: "1) ISP에 있는 이더넷 케이블이 파란 WAN 포트에 올바르게 연결되었는지 확인해주세요. 2) WiFi SSID에 연결되었는지 확인해주세요 3)이더넷 케이블이 귀하의 기기에 올바르게 연결되었는지 확인해주세요",
						activate: "활성화",
						password: "비밀번호",
						bad_email: "잘못된 비밀번호 및 아이디입니다",
						no_internet: "인터넷에 연결되어 있지 않습니다",
						something_wrong: "오류, 다시 한번 시도해주세요.",
						reg_here: "여기에 등록해주세요",
						
						factory_resetting: "VPN 라우터 초기화 중",
						rebooting: "VPN 라우터 재부팅 중",
						updating: "VPN 라우터 업데이트 중",
						
						low_memory1: "플래쉬 메모리 부족. 여유 공간 확보 필요",
						low_memory2: "추가 메모리를 위해 MicroSD 카드 혹은 USB 필요",
						checkingstatus: "상태 확인 중",
						factoryreset2: "초기화 설정",
						paramsupdated: "파라미터 업데이트 완료",
						killswith2: "활성화 시, VPN 연결 해제 경우 인터넷 연결 자동 비활성화. 고유 IP 주소 노출 방지하기 위함",
						savechanges: "변경 사항 저장",
						expertmode2: "전문가 모드 활성시, 모든 피해와 문제는 사용자가 집니다",
						expertmode3: "라우터 접속 로그인 및 비밀번호",
						expertmode4: "Spider Dashbord을 접근 할때, 해당 암호 확인 메세지 기능을 설정해주십시오",
						setrouterlogin: "라우터 로그인 설정",
						setrouterpassword: "라우터 비밀번호 설정",
						showpassword: "비밀번호 공개",
						dns_unblocker2: "VPN DNS 연결 해제 모드 업데이투",
						dns_unblocker3: "DNS 연결 해제 기능",
						customdnsservers: "DNS 서버 개인설정",
						wifi_setup2: "WiFi 이름과 기억하기 쉬운 비밀번호 설정해주세요",
						autowifichannel: "자동 채널",
						wifichannel: "채널",
						autowifiwidth: "자동 Width",
						width: "Width",
						enabledisablessid: "SSID 활성화/비활성화",
						widiisolationtitle: "Wireless 고객 간 연결 해제",
						widiisolation: "WiFi 사용자 연결 해제",
						nameyournetwork: "네트워크 이름 설정",
						restartrouter: "라우터 재시작",
						cancel: "취소",
						updatefirmware2: "[]을 최신 소프트웨어로 업데이트 해주세요",
						updatefirmware3: "펌웨어 업그레이드 위해 클릭해주세요",
						updatefirmware4: "펌웨어 업그레이드 위해 클릭해주세요",
						keepsettings: "설정 유지",
						removesetting: "설정 제거",
						submit: "제출",
						surefactoryreset: "라우터의 초기화에 동의하십니까?",
						internetdisconnected: "인터넷 연결 해제",
						internetconnected: "인터넷 연결 완료",
						wannocable2: "WAN 이더넷 케이블 연결",
						wandnsproblem: "WAN 연결 상태 - DNS 오류 감지",
						
						
						wanunknownstate: "WAN 상태 확인 불가",
						vpnconnected: "VPN 연결 완료",
						vpndisconnected: "VPN 연결해제",
						vpndnsproblem: "VPN 연결 완료 DNS 오류",
						vpndnsproblem2: "ISP가 DNS 연결을 막고 있습니다. DNS 연결 해제 기능을 꺼주세요. 이후 원하는 위치를 다시 한번 선택해주세요",
						vpnnoinet: "VPN 연결, 인터넷 연결 해제 - 다른 위치 해보세요",
						vpnnoinet2: "VPN 위치 오류! 연결 해제 후 다른 VPN 위치 선택해주세요",
						
						plzwait: "요청 사항 진행 중",
						noreferendumsavailable: "진행 중인 투표 없음",
						voteyes: "동의 ",
						voteno: "미동의 ",
						finished: "완료",
						noproposalsavailable: "현재 접수된 제안 없음",
						second: "동의",
						propose: "건의사항",
						storagefee: "보관 수수료는 다음과 같습니다",
						plzreloadpage: "완료, 새로고침 해주세요",
						cantsavedata: "라우터 플래쉬 메모리 부족. 저장 불가",
						youhavevoted: "투표 완료하셨습니다",
						onreferrendum: "투표 진행 중",
						yousecondedproposal: "건의사항에 동의하셨습니다",
						confirmation: "확인",
						importwallet: "월렛 갖고오기",
						proposal: "거의사항",
						createproposal: "건의사항 제안",
						address: "주소",
						recipientaddress: "입금 주소 이름",
						balance: "잔고",
						mnemonic: "Mnemonic (니모닉)",
						privatekey: "프라이빗 키",
						makesure: "지갑의 정보를 안전한 장소에 보관해주세요",
						gotoproposals: "건의사항으로 가기",
						seedphrase: "SEED PHRASE",
						import: "갖고오기",
						sendnreceive: "전송 및 입금",
						proposals: "건의사항",
						referendums: "총 투표사항",
						referendum: "투표",
						youraddress: "나의 주소",
						goback: "이전",
						enterreceiversaddress: "수신인 SPDR 지갑 주소 입력",
						inputspdraddress: "SPDR 지갑 주소 입력",
						amount: "수량",
						send: "전송",
						receive: "입금",
						chooseaproposal: "건의사항 선택하기",
						success: "성공",
						createwallet: "지갑 생성",
						setupcablewan: "케이블 WAN 연결 설정",
						staticip: "고정 IP 주소",
						ipv4placeholder: "IPv4 주소 -192.168.1.2",
						netmaskplaceholder: "IPv4 netmask - 255.255.255.0",
						gatewayplaceholder: "IPv4 gateway - 192.168.1.1",
						dnsplaceholder: "DNS 서버 - 8.8.8.8",
						detectingstatus: "상태 확인 중",
						setupwifiwan: "무선 WAN 연결 설정",
						joinnetwork: "네트워크 합류",
						ssidsdetected: "SSID 탐지",
						routerisnotaccessible: "라우터 접속 불가",
						confirmdisconnectwifiwan: "무선 WAN 연결 해제",
						enterssidpassword: "SSID 비밀번호 입력해주세요",
						ssidpasswordlength: "SSID 비밀번호는 8~63자리로 설정해주세요",
						nowwan: "무선 WAN이 연결되어 있지 않습니다",
						wwanok: "무선 WAN이 연결되었습니다",
						wwannotok: "무선 WAN이 연결되지 않았습니다",
						
						formatting: "포맷 중",
						internalmemory: "내부 플래쉬 메모리",
						used: "사용 완료",
						free: "남음",
						externalmemory0: "외부 USN 플래쉬 메모리 - 0MB 남음. USB를 연결하여 외부 메모리 생성",
						mmc: "라우터 MicroSD로 부팅",
						freespace: "여유 공간",
						usb: "라우터 USB Pendrive로 부팅",
						nonexpectedstatus: "라우는 현재 확인되지 않은 상태에 있음. 부팅해주세요",
						mmc1: "MicroSD 카드 연결됨",
						usb1: "USB 플래쉬 드라이브 연결됨",
						size: "크기",
						formattedfor: "포",
						
						format: "포맷",
						mmc0: "MicroSD",
						usb0: "USB PenDrive",
						active: "활성 중",
						saferemove: "안전한 제거",
						rebootrouter: "라우터 재시작",
						reboottoactivate: "재부팅 후 작동해주세요",
						routerwilloffnowmmc: "이제 라우터가 꺼지고 USB Pendrive를 안전하게 제거할 수 있습니다. 라우터를 다시 시작하려면 라우터의 전원 케이블을 빼고 재연결합니다. 진행하시겠습니까?",
						routerwilloffnowusb: "이제 라우터가 꺼지고 MicroSD를 안전하게 제거할 수 있습니다. 라우터를 다시 시작하려면 라우터의 전원 케이블을 빼고 재연결합니다. 진행하시겠습니까?",
						confirmformatmmc: "연결한 MicroSD를 포맷하시겠습니까? 모든 데이터가 삭제됩니다",
						confirmformatusb: "연결한 USB Pendrive를 포맷하시겠습니까? 모든 데이터가 삭제됩니다",
						
					}
				}
			},
			ar: {
				translation: {
					lng: {
						turn_on: "منزل، بيت",
						turn_on_title: "اضغط لتحديد موقع VPN",
						you_are_protected: "أنت لست محميًا",
						select_location: "اختر موقعا",
						connecting: "توصيل",
						disconnecting: "قطع الاتصال",
						connected: "VPN متصل",
						not_secure: "اتصالك غير آمن",
						on: "على",
						off: "عن",
						disabled: "معاق",
						change_location: "تغيير الموقع",
						check_my_ip: "تحقق من عنوان IP الخاص بي",
						check_servers_status: "انقر للتحقق من حالة الخادم",
						update_locations_list: "تحديث قائمة المواقع",
						connection_information: "معلومات الاتصال",
						version: "إصدار",
						current_updown_speed: "السرعة الحالية لأسفل / أعلى",
						total_data_used: "إجمالي البيانات المستخدمة مع " + shortbrand,
						checking_wan_state: "التحقق من حالة WAN...",
						checking_vpn_state: "التحقق من حالة VPN...",
						home: " منزل، بيت ",
						wifi_setup: " إعداد WiFi ",
						wan_setup: " إعداد WAN ",
						killswith: " قتل التبديل",
						dns_unblocker: " أنبلوكير DNS",
						expertmode: " وضع الخبراء",
						ipinfo: " معلومات الاتصال",
						helpnsupport: " ساعد لدعم",
						createticket: "  تحدث إلى فريقنا",
						myvpnaccount: " حساب VPN الخاص بي",
						restart: "  إعادة تشغيل",
						factoryreset: "  الرجوع الى ضبط المصنع",
						updatefirmware: " قم بالتحديث إلى أحدث البرامج",
						logout: "  تسجيل خروج",
						routermemory: " ذاكرة جهاز التوجيه",
						wallet: " محفظة",

						wannocable: "يرجى توصيل كبل Ethernet من موجه ISP بمنفذ Blue WAN الخاص بـ "+ brand +".",
						wanunknown: "1) يرجى التأكد من توصيل كابل إيثرنت من مزود خدمة الإنترنت بشكل صحيح "+brand+" منفذ WAN الأزرق<br/>2) تأكد من أنك متصل بـ "+wifissid1+" أو "+wifissid1+" شبكة Wi-Fi SSID.<br/>3) تأكد من أن كابل إيثرنت من "+brand+" متصل بشكل صحيح بجهاز الكمبيوتر المحمول / الكمبيوتر الشخصي",
						
						activate: "تفعيل",
						password: "كلمه السر",
						bad_email: "لقد أدخلت اسم مستخدم أو كلمة مرور غير صحيحة.",
						no_internet: "لا يوجد اتصال بالإنترنت.",
						something_wrong: "هناك شئ خاطئ، يرجى المحاولة فى وقت لاحق.",
						reg_here: "سجل هنا",
						
						factory_resetting: "إعادة ضبط المصنع لجهاز توجيه VPN...",
						rebooting: "إعادة تشغيل جهاز توجيه VPN...",
						updating: "تحديث راوتر VPN...",
						
						low_memory1: "ذاكرة فلاش منخفضة! الرجاء إخلاء بعض المساحة.",
						low_memory2: "يرجى استخدام بطاقة MicroSD أو عصا USB لتوسيع الذاكرة.",
						checkingstatus: "كشف الحالة...",
						factoryreset2: "اعدادات المصنع",
						paramsupdated: "تم تحديث المعلمات بنجاح.",
						killswith2: "عند تمكين هذا ، سيتم قطع اتصالك بالإنترنت تلقائيًا في حالة فشل VPN. إنه يحمي عنوان IP الأصلي الخاص بك من التعرض.",
						savechanges: "حفظ التغييرات",
						expertmode2: "المستخدم مسؤول عن أي ضرر أو مشاكل قد تحدث عند تشغيل وضع الخبير.",
						expertmode3: "الدخول إلى جهاز التوجيه وكلمة المرور",
						expertmode4: "قم بتعيين كلمة المرور هذه ، لذا عندما تصل إلى أي شيء من " + brand + " Dashboard ، ستطالبك بكلمة المرور هذه.",
						setrouterlogin: "تعيين تسجيل الدخول إلى جهاز التوجيه",
						setrouterpassword: "تعيين كلمة مرور جهاز التوجيه",
						showpassword: "عرض كلمة المرور",
						dns_unblocker2: "قم بتحديث وضع VPN DNS Unblocker الخاص بك",
						dns_unblocker3: "ميزة إلغاء حظر DNS",
						customdnsservers: "خوادم DNS المخصصة",
						wifi_setup2: "قم بتخصيص اسم WiFi الخاص بك وقم بتعيين كلمة مرور سهلة التذكر",
						autowifichannel: "قناة السيارات",
						wifichannel: "قناة",
						autowifiwidth: "العرض التلقائي",
						width: "عرض",
						enabledisablessid: "تمكين / تعطيل SSID",
						widiisolationtitle: "يعزل العملاء اللاسلكيين عن بعضهم البعض",
						widiisolation: "عزل عميل WiFi",
						nameyournetwork: "قم بتسمية شبكتك",
						restartrouter: "أعد تشغيل جهاز التوجيه",
						cancel: "Cancel",
						updatefirmware2: "تحديث الخاص بك "+brand+" لأحدث البرامج",
						updatefirmware3: "انقر لتحديد ترقية البرنامج الثابت",
						updatefirmware4: "انقر لتحديد ترقية البرنامج الثابت",
						keepsettings: "حافظ على الإعدادات",
						removesetting: "إزالة إعدادات",
						submit: "إرسال",
						surefactoryreset: "هل أنت متأكد أنك تريد إعادة تعيين جهاز التوجيه الخاص بك إلى إعدادات المصنع الافتراضية؟",
						internetdisconnected: "انقطع الاتصال بالإنترنت",
						internetconnected: "متصل بالإنترنت",
						wannocable2: "WAN لا يوجد كابل إيثرنت متصل",
						wandnsproblem: "اتصال WAN ، مشكلة DNS",
						wandnsproblem2: "اتصال WAN ، تم اكتشاف DNS-blocker ، حاول تبديل ميزة dns-unlocker",
						wandnsproblem3: "يقوم مزود خدمة الإنترنت الخاص بك بحظر ملف "+shortbrand+"-DNS. انقر هنا وقم بإيقاف تشغيل DNS-Unblocker. ثم حدد الموقع المطلوب مرة أخرى.",
						wanunknownstate: "حالة WAN غير معروفة",
						vpnconnected: "VPN متصل",
						vpndisconnected: "VPN غير متصل",
						vpndnsproblem: "اتصال VPN ، مشكلة DNS",
						vpndnsproblem2: "يقوم مزود خدمة الإنترنت الخاص بك بحظر ملف "+shortbrand+"-DNS. انقر هنا وقم بإيقاف تشغيل DNS-Unblocker. ثم حدد الموقع المطلوب مرة أخرى.",
						vpnnoinet: "اتصال VPN ، لا يوجد إنترنت - جرب موقعًا مختلفًا",
						vpnnoinet2: "موقع VPN معطل! يرجى قطع الاتصال ومحاولة موقع VPN آخر.",
						
						plzwait: "يرجى الانتظار بينما يتم معالجة طلبك.",
						noreferendumsavailable: "لا توجد استفتاءات متاحة",
						voteyes: "التصويت نعم",
						voteno: "التصويت لا",
						finished: "تم الانتهاء من",
						noproposalsavailable: "لا توجد مقترحات متاحة",
						second: "ثانية",
						propose: "اقترح",
						storagefee: "رسوم التخزين",
						plzreloadpage: "تم ، الرجاء إعادة تحميل هذه الصفحة الآن",
						cantsavedata: "لا يمكن حفظ التاريخ في ذاكرة فلاش لجهاز التوجيه.",
						youhavevoted: "لقد صوتت",
						onreferrendum: "على الاستفتاء",
						yousecondedproposal: "أنت اقتراح ثان",
						confirmation: "تأكيد",
						importwallet: "استيراد المحفظة",
						proposal: "عرض",
						createproposal: "إنشاء اقتراح",
						address: "عنوان",
						recipientaddress: "اسم مستخدم المستلم",
						balance: "توازن",
						mnemonic: "ذاكري",
						privatekey: "مفتاح سري",
						makesure: "تأكد من حفظ معلومات المحفظة في مكان آمن",
						gotoproposals: "انتقل إلى العروض",
						seedphrase: "صيغة البذور",
						import: " يستورد",
						sendnreceive: "إرسال استقبال",
						
						proposals: "اقتراحات",
						referendums: "الاستفتاءات",
						referendum: "استفتاء",
						youraddress: "عنوانك",
						goback: "عد ",
						enterreceiversaddress: "أدخل عنوان $ SPDR الخاص بالمستلم",
						inputspdraddress: "أدخل عنوان $ SPDR",
						amount: "كمية",
						send: "إرسال",
						receive: " تسلم",
						chooseaproposal: "اختر عرضا",
						success: "نجاح",
						createwallet: "إنشاء المحفظة",
						setupcablewan: "إعداد اتصال كابل WAN",
						staticip: "رقم تعريف حاسوب ثابت",
						ipv4placeholder: "عنوان IPv4 - 192.168.1.2",
						netmaskplaceholder: "قناع شبكة IPv4 - 255.255.255.0",
						gatewayplaceholder: "بوابة IPv4 - 192.168.1.1",
						dnsplaceholder: "خادم DNS - 8.8.8.8",
						detectingstatus: "كشف الحالة...",
						setupwifiwan: "Setup Wireless WAN Connection",
						joinnetwork: "الانضمام إلى الشبكة",
						ssidsdetected: "تم الكشف عن SSIDs",
						routerisnotaccessible: "جهاز التوجيه غير متاح الآن",
						confirmdisconnectwifiwan: "هل تريد قطع اتصال WAN اللاسلكي؟",
						enterssidpassword: "الرجاء إدخال كلمة مرور SSID",
						ssidpasswordlength: "يجب أن يتراوح طول كلمة مرور SSID بين 8 إلى 63 رمزًا",
						nowwan: "لا توجد شبكة WAN لاسلكية متصلة",
						wwanok: "تم توصيل WAN اللاسلكي",
						wwannotok: "Wireless WAN is not connected",
						formatting: "تنسيق",
						
					}
					
					
				}
			},
		}
	  }, function(err, t) {
		// for options see
		// https://github.com/i18next/jquery-i18next#initialize-the-plugin
		jqueryI18next.init(i18next, $);
		// start localizing, details:
		// https://github.com/i18next/jquery-i18next#usage-of-selector-function
		$("body").localize();
	  });
	
	var wannocable = i18next.t("lng.wannocable");
	var wanunknown = i18next.t("lng.wanunknown");


</script>


</body>

</html>';
