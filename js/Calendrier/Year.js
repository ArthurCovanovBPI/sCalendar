function highlightColumn(colval)
{
	var cols = document.getElementsByClassName(colval);
for(i=0; i<cols.length; i++)
	{
		cols[i].classList.add("highlight");
	}
}
function lowlightColumn(colval)
{
	var cols = document.getElementsByClassName(colval);
for(i=0; i<cols.length; i++)
	{
		cols[i].classList.remove("highlight");
	}
}

function eventDescription(timeStamp, calendarCheck)
{
	$("#eventDescription").load("eventsDesc.php?timeStamp="+timeStamp+"&calendarCheck="+calendarCheck);
}

function monthEventDescription(timeStamp, calendarCheck)
{
	$("#eventDescription").load("eventsDesc.php?timeStamp="+timeStamp+"&calendarCheck="+calendarCheck+"&month=true");
}

function changeManifType()
{
	var _a = document.getElementById("checkTout").checked;
	var _0 = document.getElementById("checkManifPublique").checked;
	var _1 = document.getElementById("checkManifInterne").checked;
	var _2 = document.getElementById("checkCalendaire").checked;
	var _3 = document.getElementById("checkAdminRH").checked;
	var _4 = document.getElementById("checkFinancier").checked;

	var newManifType = ((_0)?"1":"0") + ((_1)?"1":"0") + ((_2)?"1":"0") + ((_3)?"1":"0") + ((_4)?"1":"0");
	if(_a)
		newManifType = "11111";

key = encodeURI("calendarCheck");
value = encodeURI(newManifType);

var kvp = document.location.split('&');
while(i--) 
{
x = kvp[i].split('=');

if (x[0]==key)
{
x[1] = value;
kvp[i] = x.join('=');
break;
}
}

if(i<0) {kvp[kvp.length] = [key,value].join('=');}

//this will reload the page, it's likely better to store this until finished
//document.location.search = kvp.join('&'); 

	alert(kvp.join('&'));
}

