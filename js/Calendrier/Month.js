function eventDescription(timeStamp, calendarCheck)
{
	$("#eventDescription").load("eventsDesc.php?timeStamp="+timeStamp+"&calendarCheck="+calendarCheck);
}

function changeManifType()
{
	var _0 = document.getElementById("checkManifPublique").checked;
	var _1 = document.getElementById("checkManifInterne").checked;
	var _2 = document.getElementById("checkCalendaire").checked;
	var _3 = document.getElementById("checkAdminRH").checked;
	var _4 = document.getElementById("checkFinancier").checked;

	var newManifType = ((_0)?"1":"0") + ((_1)?"1":"0") + ((_2)?"1":"0") + ((_3)?"1":"0") + ((_4)?"1":"0");

	var url = location.href;

	if(url.indexOf("?")==-1)
	{
		url += ("?calendarCheck"+newManifType);
	}
	else if(url.indexOf("calendarCheck")==-1)
	{
		url += ("&calendarCheck"+newManifType);
	}
	else
	{
		key = encodeURI("calendarCheck");
		value = encodeURI(newManifType);

		var attr = url.split('?');

		var kvp = attr[1].split('&');
		var i=kvp.length;
		var x;
		while(i--) 
		{
			x = kvp[i].split('=');

			if(x[0]==key)
			{
				x[1] = value;
				kvp[i] = x.join('=');
				break;
			}
		}

		if(i<0) {kvp[kvp.length] = [key,value].join('=');}

		attr[1]=(kvp.join('&'));
		url=attr.join('?');
	}
	location.href = url;
}

function changeA()
{
	if(document.getElementById("checkTout").checked)
	{
		document.getElementById("checkManifPublique").checked=true;
		document.getElementById("checkManifInterne").checked=true;
		document.getElementById("checkCalendaire").checked=true;
		document.getElementById("checkAdminRH").checked=true;
		document.getElementById("checkFinancier").checked=true;
	}
	else
	{
		document.getElementById("checkManifPublique").checked=true;
		document.getElementById("checkManifInterne").checked=true;
		document.getElementById("checkCalendaire").checked=true;
		document.getElementById("checkAdminRH").checked=false;
		document.getElementById("checkFinancier").checked=false;
	}

	changeManifType();
}

